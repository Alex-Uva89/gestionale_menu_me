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
            $table->text('instructions')->nullable()->change();
            $table->text('instructions_en')->nullable()->change();
            $table->text('instructions_fr')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drinks', function (Blueprint $table) {
            $table->string('instructions')->nullable()->change();
            $table->string('instructions_en')->nullable()->change();
            $table->string('instructions_fr')->nullable()->change();
        });
    }
};
