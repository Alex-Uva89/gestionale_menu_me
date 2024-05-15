<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('messages')->insert([
            'content' => 'Hello World',
            'is_read' => false,
            'read_at' => now(),
            'sent_at' => now(),
            'received_at' => now(),
        ]);
        
        // Message::factory()->count(10)->create();
    }
}
