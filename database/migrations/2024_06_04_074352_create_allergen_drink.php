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
        Schema::create('allergen_drink', function (Blueprint $table) {
            $table->unsignedBigInteger('allergen_id');
            $table->unsignedBigInteger('drink_id');

            $table->foreign('allergen_id')->references('id')->on('allergens')->onDelete('cascade');
            $table->foreign('drink_id')->references('id')->on('drinks')->onDelete('cascade');

            $table->primary(['allergen_id', 'drink_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allergen_drink');
    }
};
