<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['Rent', 'Sale', 'Investment']);
            $table->string('category'); // 1 Bedroom, 2 Bedroom, etc.
            $table->decimal('price', 15, 2);
            $table->string('location');
            $table->string('address');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('parking')->nullable();
            $table->decimal('size', 10, 2)->nullable(); // Square meters
            $table->json('features')->nullable(); // Swimming pool, gym, etc.
            $table->json('images')->nullable();
            $table->string('video_url')->nullable();
            $table->enum('status', ['Available', 'Pending', 'Sold', 'Rented'])->default('Available');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_featured')->default(false);
            $table->text('rejection_reason')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['type', 'category', 'status']);
            $table->index(['location', 'price']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
