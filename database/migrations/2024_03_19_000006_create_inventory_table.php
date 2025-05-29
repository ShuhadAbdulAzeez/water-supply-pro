<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')->constrained()->onDelete('cascade');
            $table->integer('filled_bottles_count')->default(0);
            $table->integer('empty_bottles_count')->default(0);
            $table->integer('damaged_bottles_count')->default(0);
            $table->date('inventory_date'); // Added the missing column
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Index for better query performance
            $table->index(['truck_id', 'inventory_date']);
            $table->index('inventory_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};