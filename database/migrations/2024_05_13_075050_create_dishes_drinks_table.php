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
        Schema::create('pairings_dishes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('dish_id')->constrained()->onDelete('cascade');
            $table->foreignId('drink_id')->constrained()->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pairings_dishes');
    }
};
