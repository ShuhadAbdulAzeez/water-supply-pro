<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bottles', function (Blueprint $table) {
            $table->id();
            $table->string('bottle_number')->unique();
            $table->enum('status', ['filled', 'empty', 'damaged'])->default('filled');
            $table->enum('size', ['small', 'medium', 'large'])->default('medium');
            $table->foreignId('truck_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->date('last_filled_date')->nullable();
            $table->date('last_returned_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bottles');
    }
}; 