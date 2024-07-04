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
        Schema::create('drinks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->integer('price')->nullable();
            $table->text('description')->nullable();
            $table->string('instructions')->nullable();
            $table->string('degrees')->nullable();
            $table->string('origin')->nullable();
            $table->string('color')->nullable();
            $table->string('production_method')->nullable();
            $table->string('flavour')->nullable();
            
            $table->foreignId('category_id')->constrained();
            $table->foreignId('venue_id')->constrained();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drinks');
    }
};
