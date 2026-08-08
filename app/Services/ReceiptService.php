<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Receipt;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReceiptService
{
    public static function paymentMethodLabel(?string $method): string
    {
        $method = strtolower(trim((string) $method));

        return match ($method) {
            'pos' => 'POS',
            'bank_transfer' => 'Bank Transfer',
            'cash' => 'Cash',
            'cheque' => 'Cheque',
            'installment' => 'Installment',
            '' => 'Bank Transfer',
            default => ucwords(str_replace('_', ' ', $method)),
        };
    }

    public static function resolvePublicFile(string $relative): ?string
    {
        $roots = [public_path(), base_path('public')];

        if (isset($_SERVER['SCRIPT_FILENAME']) && is_string($_SERVER['SCRIPT_FILENAME']) && $_SERVER['SCRIPT_FILENAME'] !== '') {
            $docroot = dirname($_SERVER['SCRIPT_FILENAME']);
            if (!in_array($docroot, $roots, true)) {
                $roots[] = $docroot;
            }
        }

        foreach (array_unique($roots) as $root) {
            $full = rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($relative, DIRECTORY_SEPARATOR);
            if (is_file($full) && filesize($full) > 0) {
                return $full;
            }
        }

        return null;
    }

    private function buildPdf(Payment $payment, Receipt $receipt)
    {
        $pdf = Pdf::loadView('pdf.receipt', compact('payment', 'receipt'));
        $pdf->setPaper([0, 0, 425.2, 620], 'portrait');

        return $pdf;
    }

    public function generate(Payment $payment): Receipt
    {
        $receipt = Receipt::create([
            'payment_id' => $payment->id,
            'receipt_number' => Receipt::generateReceiptNumber(),
            'generated_by' => Auth::id(),
            'generated_at' => now(),
        ]);

        $filename = 'receipts/receipt-' . $receipt->receipt_number . '.pdf';
        Storage::disk('public')->put($filename, $this->buildPdf($payment, $receipt)->output());

        $receipt->update(['file_path' => $filename]);

        ActivityLog::log(
            Auth::id(),
            'receipt_generated',
            "Receipt {$receipt->receipt_number} generated for payment {$payment->reference}",
            $receipt,
            ['amount' => $payment->amount]
        );

        return $receipt;
    }

    public function regenerateFile(Payment $payment, Receipt $receipt): void
    {
        Storage::disk('public')->put($receipt->file_path, $this->buildPdf($payment, $receipt)->output());
    }

    /**
     * Generate a PNG image of the receipt (used for WhatsApp sharing).
     * Mirrors the pdf.receipt invoice design (logo, billed-to, meta, items, totals, footer).
     */
    public function generateImage(Payment $payment, Receipt $receipt): string
    {
        $fontDir = storage_path('fonts');
        $fallbackDir = base_path('vendor/dompdf/dompdf/lib/fonts');
        $font = is_file($fontDir . '/Poppins-Regular.ttf')
            ? $fontDir . '/Poppins-Regular.ttf'
            : $fallbackDir . '/DejaVuSans.ttf';
        $fontMedium = is_file($fontDir . '/Poppins-Medium.ttf')
            ? $fontDir . '/Poppins-Medium.ttf'
            : $fallbackDir . '/DejaVuSans-Bold.ttf';
        $fontBold = is_file($fontDir . '/Poppins-SemiBold.ttf')
            ? $fontDir . '/Poppins-SemiBold.ttf'
            : $fallbackDir . '/DejaVuSans-Bold.ttf';
        $amountFont = $fallbackDir . '/DejaVuSans-Bold.ttf';

        $width = 620;
        $margin = 40;
        $right = $width - $margin;
        $contentW = $right - $margin;

        // ---- colors ----
        $colors = [
            'white'      => [255, 255, 255],
            'navy'       => [29, 45, 122],
            'blue'       => [59, 91, 219],
            'orange'     => [249, 115, 22],
            'dark'       => [17, 24, 39],
            'gray'       => [107, 114, 128],
            'mid'        => [75, 85, 99],
            'line'       => [229, 231, 235],
            'green'      => [5, 150, 105],
            'lighter'    => [156, 163, 175],
        ];

        // ---- logo ----
        $logo = null;
        $logoW = 0;
        $logoH = 0;
        foreach (['images/logo-receipt.jpg', 'images/logo.png'] as $logoFile) {
            $full = self::resolvePublicFile($logoFile);
            if (!$full) {
                continue;
            }
            $logo = str_ends_with($logoFile, '.png') ? @imagecreatefrompng($full) : @imagecreatefromjpeg($full);
            if ($logo) {
                break;
            }
        }
        if ($logo) {
            $sw = imagesx($logo);
            $sh = imagesy($logo);
            $logoH = 44;
            $logoW = (int) round($logoH * $sw / max($sh, 1));
            if ($logoW > 120) {
                $logoW = 120;
                $logoH = (int) round($logoW * $sh / max($sw, 1));
            }
        }

        // ---- meta / detail data ----
        $metaRows = [
            ['Invoice No.', $receipt->receipt_number],
            ['Payment Ref', $payment->reference],
            ['Date & Time', $receipt->generated_at->format('d M Y') . ' | ' . $receipt->generated_at->format('h:i A')],
            ['Payment Method', self::paymentMethodLabel($payment->payment_method)],
            ['Status', 'PAID'],
        ];

        $detailLines = [$payment->property->title ?? 'Property'];
        if ($payment->property && $payment->property->location) {
            $detailLines[] = 'Location: ' . $payment->property->location;
        }
        if ($payment->property && $payment->property->category) {
            $detailLines[] = 'Category: ' . ucfirst($payment->property->category);
        }
        $detailLines[] = 'Sale Type: ' . ucfirst($payment->type);
        if ($payment->installment_number && $payment->total_installments) {
            $detailLines[] = 'Installment: ' . $payment->installment_number . ' of ' . $payment->total_installments;
        }

        $buyerLines = [$payment->buyer_name];
        if ($payment->buyer_email) {
            $buyerLines[] = $payment->buyer_email;
        }
        if ($payment->buyer_phone) {
            $buyerLines[] = $payment->buyer_phone;
        }

        $amount = $payment->formatted_amount;

        // ---- layout ----
        $dividerY = $margin + max($logoH, 70) + 12;
        $metaTop = $dividerY + 20;
        $billToBottom = $metaTop + 26 + count($buyerLines) * 22;
        $metaBottom = $metaTop + 26 + count($metaRows) * 24;
        $itemsTop = max($billToBottom, $metaBottom) + 18;
        $bodyH = count($detailLines) * 19 + 14;
        $totalsTop = $itemsTop + 26 + $bodyH + 18;
        $grandH = 36;
        $footerLineY = $totalsTop + 24 + $grandH + 22;
        $height = $footerLineY + 100;

        $img = imagecreatetruecolor($width, $height);
        $pal = [];
        foreach ($colors as $name => [$r, $g, $b]) {
            $pal[$name] = imagecolorallocate($img, $r, $g, $b);
        }
        imagefilledrectangle($img, 0, 0, $width, $height, $pal['white']);

        $textWidth = function (string $text, string $f, int $size) {
            $b = imagettfbbox($size, 0, $f, $text);
            return abs($b[2] - $b[0]);
        };

        $draw = function (string $text, string $f, int $size, int $x, int $baseline, $color) use ($img, $textWidth) {
            imagettftext($img, $size, 0, $x, $baseline, $color, $f, $text);
        };

        $rightText = function (string $text, string $f, int $size, int $rightX, int $baseline, $color) use ($img, $textWidth) {
            $tw = $textWidth($text, $f, $size);
            imagettftext($img, $size, 0, $rightX - $tw, $baseline, $color, $f, $text);
        };

        $centerText = function (string $text, string $f, int $size, int $baseline, $color) use ($img, $width, $textWidth) {
            $tw = $textWidth($text, $f, $size);
            imagettftext($img, $size, 0, (int) (($width - $tw) / 2), $baseline, $color, $f, $text);
        };

        // ---- header ----
        $y = $margin;
        if ($logo) {
            imagecopyresampled($img, $logo, $margin, $y, 0, 0, $logoW, $logoH, imagesx($logo), imagesy($logo));
        }
        $cx = $margin + $logoW + 14;
        $draw(config('bfamily.company.name'), $fontBold, 19, $cx, $y + 22, $pal['navy']);
        $draw(config('bfamily.company.address'), $font, 11, $cx, $y + 44, $pal['gray']);
        $draw('Tel: ' . config('bfamily.company.phone') . ' | ' . config('bfamily.company.email'), $font, 11, $cx, $y + 62, $pal['gray']);
        $rightText('INVOICE', $fontBold, 38, $right, $y + 28, $pal['orange']);
        $rightText('OFFICIAL PAYMENT RECEIPT', $font, 10, $right, $y + 44, $pal['lighter']);

        imagefilledrectangle($img, $margin, $dividerY, $right, $dividerY + 3, $pal['navy']);
        imagefilledrectangle($img, $margin, $dividerY + 5, $right, $dividerY + 7, $pal['orange']);

        // ---- billed to / meta ----
        $draw('BILLED TO', $fontBold, 10, $margin, $metaTop + 10, $pal['blue']);
        $by = $metaTop + 30;
        foreach ($buyerLines as $i => $line) {
            $draw($line, $i === 0 ? $fontMedium : $font, $i === 0 ? 14 : 11, $margin, $by, $i === 0 ? $pal['dark'] : $pal['mid']);
            $by += 22;
        }

        $metaRightX = (int) ($margin + $contentW * 0.56);
        $my = $metaTop + 30;
        foreach ($metaRows as [$label, $value]) {
            $draw($label, $font, 11, $metaRightX, $my, $pal['gray']);
            $isStatus = $label === 'Status';
            $rightText($value, $fontMedium, 12, $right, $my, $isStatus ? $pal['green'] : $pal['dark']);
            $my += 24;
        }

        // ---- items table ----
        imagefilledrectangle($img, $margin, $itemsTop, $right, $itemsTop + 26, $pal['navy']);
        $draw('#', $fontBold, 11, $margin + 10, $itemsTop + 18, $pal['white']);
        $draw('ITEM', $fontBold, 11, $margin + 32, $itemsTop + 18, $pal['white']);
        $draw('DETAILS', $fontBold, 11, $margin + 150, $itemsTop + 18, $pal['white']);
        $rightText('AMOUNT', $fontBold, 11, $right - 10, $itemsTop + 18, $pal['white']);

        $rowTop = $itemsTop + 26;
        $draw('1', $font, 12, $margin + 14, $rowTop + 20, $pal['gray']);
        $draw('Property Purchase', $fontMedium, 12, $margin + 32, $rowTop + 19, $pal['dark']);

        $dl = $rowTop + 19;
        foreach ($detailLines as $i => $line) {
            $isTitle = $i === 0;
            $draw($line, $isTitle ? $fontMedium : $font, $isTitle ? 12 : 11, $margin + 150, $dl, $isTitle ? $pal['dark'] : $pal['mid']);
            $dl += 19;
        }
        $rightText($amount, $amountFont, 12, $right - 10, $rowTop + 20, $pal['dark']);

        $rowBottom = $rowTop + $bodyH;
        imageline($img, $margin, $rowBottom, $right, $rowBottom, $pal['line']);

        // ---- totals ----
        $totalsLeft = $right - 260;
        $totalsTop = $rowBottom + 18;
        $draw('Total Amount', $font, 12, $totalsLeft, $totalsTop + 17, $pal['mid']);
        $rightText($amount, $amountFont, 12, $right, $totalsTop + 17, $pal['dark']);

        $grandTop = $totalsTop + 24;
        imagefilledrectangle($img, $totalsLeft, $grandTop, $right, $grandTop + $grandH, $pal['orange']);
        $draw('Amount Paid', $fontBold, 13, $totalsLeft + 10, $grandTop + 24, $pal['white']);
        $rightText($amount, $amountFont, 16, $right - 10, $grandTop + 25, $pal['white']);

        // ---- footer ----
        $footerLineY = $grandTop + $grandH + 22;
        imagefilledrectangle($img, $margin, $footerLineY, $right, $footerLineY + 4, $pal['navy']);
        $fy = $footerLineY + 28;
        $centerText(config('bfamily.company.name'), $fontBold, 13, $fy, $pal['navy']);
        $centerText('Thank you for your business - this is an official payment receipt.', $font, 11, $fy + 22, $pal['gray']);
        $centerText('Keep this receipt for your records.', $font, 11, $fy + 44, $pal['gray']);
        $centerText(config('bfamily.company.name') . ' | ' . config('bfamily.company.phone'), $font, 10, $fy + 66, $pal['lighter']);

        // ---- save ----
        $filename = 'receipts/receipt-' . $receipt->receipt_number . '.png';
        ob_start();
        imagepng($img);
        $png = ob_get_clean();
        imagedestroy($img);

        Storage::disk('public')->put($filename, $png);

        return $filename;
    }
}
