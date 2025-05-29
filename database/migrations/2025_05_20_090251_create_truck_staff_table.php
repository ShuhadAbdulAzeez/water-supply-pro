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
        Schema::create('truck_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')->constrained('trucks')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->string('role')->default('driver'); // driver, helper, mechanic, etc.
            $table->timestamp('assigned_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Prevent duplicate assignments of same staff to same truck with same role
            $table->unique(['truck_id', 'staff_id', 'role'], 'unique_truck_staff_role');
            
            // Index for better query performance
            $table->index(['truck_id', 'is_active']);
            $table->index(['staff_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_staff');
    }
};