<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // property_approved, property_rejected, registration_approved, registration_rejected, payment_received, upgrade_request, etc.
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable();
            $table->string('color')->default('primary'); // primary, success, warning, danger, info
            $table->morphs('notifiable'); // polymorphic relation for property, user, payment, etc.
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
