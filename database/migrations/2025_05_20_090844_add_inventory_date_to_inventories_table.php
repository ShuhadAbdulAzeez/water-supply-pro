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
        Schema::table('inventories', function (Blueprint $table) {
            $table->date('inventory_date')->after('damaged_bottles_count');
            
            // Add indexes for better performance
            $table->index(['truck_id', 'inventory_date']);
            $table->index('inventory_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropIndex(['truck_id', 'inventory_date']);
            $table->dropIndex(['inventory_date']);
            $table->dropColumn('inventory_date');
        });
    }
};