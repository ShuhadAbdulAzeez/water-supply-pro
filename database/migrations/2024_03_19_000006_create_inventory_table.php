<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('filled_bottles_count')->default(0);
            $table->integer('empty_bottles_count')->default(0);
            $table->integer('damaged_bottles_count')->default(0);
            $table->date('inventory_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
}; 