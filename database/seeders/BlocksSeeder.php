<?php

namespace Database\Seeders;

use App\Models\Blocks;
use Illuminate\Database\Seeder;

class BlocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Blocks::factory()->times(1000)->create();
    }
}
