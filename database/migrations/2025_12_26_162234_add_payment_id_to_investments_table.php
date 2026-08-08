<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null')->after('property_id');
            $table->integer('duration_months')->nullable()->after('total_return');
            $table->enum('status', ['pending', 'active', 'completed', 'withdrawn'])->default('pending')->change();
            $table->date('start_date')->nullable()->change();
            $table->date('maturity_date')->nullable()->change();
            $table->timestamp('withdrawal_requested_at')->nullable()->after('maturity_date');
            $table->enum('withdrawal_status', ['none', 'requested', 'approved', 'paid', 'rejected'])->default('none')->after('withdrawal_requested_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropColumn(['payment_id', 'withdrawal_requested_at', 'withdrawal_status']);
            $table->enum('status', ['active', 'completed', 'withdrawn'])->default('active')->change();
        });
    }
};
