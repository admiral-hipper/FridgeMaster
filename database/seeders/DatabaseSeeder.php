<?php

namespace Database\Seeders;

use App\Models\Blocks;
use App\Models\Customers;
use App\Models\Orders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CustomersSeeder::class,
            LocationsSeeder::class,
            BlocksSeeder::class,
            PricesSeeder::class
        ]);
        $skip = 0;
        $take = 10;
        foreach (Customers::all() as $customer) {
            $blocks = Blocks::all()->skip($skip)->take($take);
            $skip += 15;
            $order = new Orders();
            $order->access_token = Str::random(12);
            $order->start_rent = now();
            $order->bill=rand(1000,3000);
            $order->end_rent = now()->addDays(rand(4, 20));
            $order->status = 1;
            $customer->orders()->save($order);
            $order->save();
            foreach ($blocks as $block) {
                $block->orders()->attach($order);
            }
        }
    }
}
