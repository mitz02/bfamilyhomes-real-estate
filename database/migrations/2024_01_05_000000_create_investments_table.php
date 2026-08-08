<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('reference')->unique();
            $table->decimal('amount', 15, 2);
            $table->decimal('roi_percentage', 5, 2)->default(0); // Return on Investment percentage
            $table->decimal('total_return', 15, 2)->default(0);
            $table->date('start_date');
            $table->date('maturity_date');
            $table->enum('status', ['active', 'completed', 'withdrawn'])->default('active');
            $table->text('terms')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['investor_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
