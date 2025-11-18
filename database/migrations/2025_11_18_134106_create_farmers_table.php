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
        Schema::create('farmers', function (Blueprint $table) {
            $table->id('farmer_id');
            $table->string('farmer_name', 255);
            $table->string('contact_number', 11);
            $table->string('farm_location', 255);
            $table->decimal('farm_size', 8, 2);
            $table->timestamps(); 
            $table->softDeletes();
            
            $table->index('farm_location');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmers');
    }
};
