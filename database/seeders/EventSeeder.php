<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title' => 'ultraviolence',
                'category' => 'musik',
                'ticket_price' => '1000000',
                'description' => 'ultraviolence-lana delrey',
                'image' => null,
                
            ],
            [
                'title' => 'festival-lanadelrey',
                'category' => 'festival',
                'ticket_price' => '1000000',
                'description' => 'with lana delrey',
                'image' => null,
            ],
            [
                'title' => 'seminar-lanadelrey',
                'category' => 'seminar',
                'ticket_price' => '1000000',
                'description' => 'with lana delrey',
                'image' => null,
            ],
        ]);
    }
}
