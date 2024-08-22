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
        Schema::table('dishes', function (Blueprint $table) {
            $table->string('name_fr')->nullable();
            $table->string('description_fr')->nullable();
            $table->string('name_en')->nullable();
            $table->string('description_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dishes', function (Blueprint $table) {
            $table->dropColumn([
                'name_fr',
                'description_fr',
                'name_en',
                'description_en',
            ]);
        });
    }
};
