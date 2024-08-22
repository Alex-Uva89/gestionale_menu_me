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
            $table->string('color_fr')->nullable();
            $table->string('color_en')->nullable();
            $table->string('origin_fr')->nullable();
            $table->string('origin_en')->nullable();
            $table->string('production_method_fr')->nullable();
            $table->string('production_method_en')->nullable();
            $table->string('flavour_fr')->nullable();
            $table->string('flavour_en')->nullable();
            $table->string('breeding_method_fr')->nullable();
            $table->string('breeding_method_en')->nullable();
            $table->string('nose_fr')->nullable();
            $table->string('nose_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drinks', function (Blueprint $table) {
            $table->dropColumn([
                'color_fr',
                'color_en',
                'origin_fr',
                'origin_en',
                'production_method_fr',
                'production_method_en',
                'flavour_fr',
                'flavour_en',
                'breeding_method_fr',
                'breeding_method_en',
                'nose_fr',
                'nose_en',
            ]);
        });
    }
};
