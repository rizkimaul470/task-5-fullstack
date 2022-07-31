<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Articles;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Articles::factory(10)->create();
    }
}
