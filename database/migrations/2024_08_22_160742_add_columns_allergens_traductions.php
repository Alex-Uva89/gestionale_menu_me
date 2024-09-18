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
        Schema::table('allergens', function (Blueprint $table) {
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('allergens', function (Blueprint $table) {
            $table->dropColumn([
                'name_fr',
                'name_en',
            ]);
        });
    }
};