<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Venue;
use Illuminate\Support\Facades\DB;

class CategoryVenueTableSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();
        $venues = Venue::all();

        foreach ($categories as $category) {
            foreach ($venues as $venue) {
                DB::table('category_venue')->insert([
                    'category_id' => $category->id,
                    'venue_id' => $venue->id,
                ]);
            }
        }
    }
}
