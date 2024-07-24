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
        Schema::table('drinks', function (Blueprint $table) {
            $table->string('producer')->nullable(); 
            $table->string('grape_variety')->nullable();
            $table->string('denomination')->nullable();
            $table->year('vintage')->nullable(); 
            $table->string('breeding_method')->nullable(); 
            $table->string('format')->nullable(); 
            $table->string('serving_temperature')->nullable();
            $table->string('nose')->nullable();
            $table->string('certifications')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drinks', function (Blueprint $table) {
            $table->dropColumn([
                'producer',
                'grape_variety',
                'denomination',
                'vintage',
                'breeding_method',
                'format',
                'serving_temperature',
                'nose',
                'certifications',
            ]);
        });
    }
};
