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
        Schema::create('harvests', function (Blueprint $table) {
            $table->id('harvest_id');
            $table->foreignId('farmer_id')->constrained('farmers')->onDelete('cascade');
            $table->enum('season', ['dry', 'wet']);
            $table->date('planting_date');
            $table->date('harvest_date');
            $table->decimal('yield_amount', 6, 2);
            $table->string('variety_used', 255);
            $table->timestamps();
            
            $table->index('season');
            $table->index('harvest_date');
            $table->index('planting_date');
            $table->index(['farmer_id', 'season']);
            
            // $table->check('harvest_date > planting_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvests');
    }
};
