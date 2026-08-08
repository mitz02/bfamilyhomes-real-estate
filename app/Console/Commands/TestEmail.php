<?php

namespace App\Console\Commands;

use App\Mail\VerifyEmailMail;
use App\Mail\PasswordResetMail;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test 
                            {type : The type of email to test (verify|reset|welcome)} 
                            {email : The email address to send to}
                            {--name= : The name to use in the email (default: Test User)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email sending functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $email = $this->argument('email');
        $name = $this->option('name') ?? 'Test User';

        // Create a test user object (not saved to database)
        $user = new User([
            'name' => $name,
            'email' => $email,
            'verification_token' => 'test-token-' . uniqid(),
        ]);

        $this->info("Testing {$type} email to {$email}...");

        try {
            switch ($type) {
                case 'verify':
                    $verificationUrl = route('verify.email', ['token' => $user->verification_token]);
                    Mail::to($email)->send(new VerifyEmailMail($user, $verificationUrl));
                    $this->info('✓ Verification email sent successfully!');
                    $this->line('Verification URL: ' . $verificationUrl);
                    break;

                case 'reset':
                    $resetToken = 'test-reset-' . uniqid();
                    $resetUrl = route('password.reset', ['token' => $resetToken, 'email' => $email]);
                    Mail::to($email)->send(new PasswordResetMail($user, $resetUrl));
                    $this->info('✓ Password reset email sent successfully!');
                    $this->line('Reset URL: ' . $resetUrl);
                    break;

                case 'welcome':
                    Mail::to($email)->send(new WelcomeMail($user));
                    $this->info('✓ Welcome email sent successfully!');
                    break;

                default:
                    $this->error('Invalid email type. Use: verify, reset, or welcome');
                    return 1;
            }

            $this->newLine();
            $this->info('Email has been sent!');
            
            if (config('mail.default') === 'log') {
                $this->warn('Using LOG driver. Check storage/logs/laravel.log for the email content.');
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to send email: ' . $e->getMessage());
            return 1;
        }
    }
}

