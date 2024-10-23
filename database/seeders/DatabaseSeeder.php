<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Добавляем несколько строк с интересами
        DB::table('interests')->insert([
            [
                'interest_name' => 'music',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'sports',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'travel',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'movies',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'reading',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'fitness',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'cooking',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'photography',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'art',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'gaming',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'yoga',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'interest_name' => 'dancing',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
