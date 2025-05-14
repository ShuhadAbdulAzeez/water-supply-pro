<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bill_bottle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained()->onDelete('cascade');
            $table->foreignId('bottle_id')->constrained()->onDelete('cascade');
            $table->enum('action', ['delivered', 'collected']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_bottle');
    }
}; 