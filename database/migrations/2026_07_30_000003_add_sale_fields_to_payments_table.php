<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->timestamp('sale_date')->nullable()->after('approved_at');
            $table->string('payment_method')->nullable()->after('sale_date');
            $table->text('staff_notes')->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['sale_date', 'payment_method', 'staff_notes']);
        });
    }
};
