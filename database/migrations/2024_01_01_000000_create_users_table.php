<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['user', 'agent', 'investor', 'admin'])->default('user');
            $table->enum('status', ['active', 'blocked', 'pending'])->default('active');
            $table->string('avatar')->nullable();
            $table->text('address')->nullable();
            $table->string('verification_token')->nullable();
            $table->timestamp('investor_requested_at')->nullable();
            $table->timestamp('investor_approved_at')->nullable();
            $table->timestamp('agent_requested_at')->nullable();
            $table->timestamp('agent_approved_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
