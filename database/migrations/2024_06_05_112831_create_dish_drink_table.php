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
        Schema::create('dish_drink', function (Blueprint $table) {
            $table->unsignedBigInteger('dish_id');
            $table->unsignedBigInteger('drink_id');

            $table->foreign('dish_id')->references('id')->on('dishes')->onDelete('cascade');
            $table->foreign('drink_id')->references('id')->on('drinks')->onDelete('cascade');

            $table->primary(['dish_id', 'drink_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish_drink');
    }
};
