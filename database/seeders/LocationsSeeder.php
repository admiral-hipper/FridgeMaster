<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            'Wilmington (North Carolina)',
            'Portland (Oregon)',
            'Toronto',
            'Warsaw',
            'Valenlcia',
            'Shanghai'
        ];
        foreach ($locations as $location) {
            DB::table('locations')->insert(['slug' => Str::slug($location), 'location' => $location]);
        }
    }
}
