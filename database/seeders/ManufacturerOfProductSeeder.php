<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ManufacturerOfProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('manufacturer_of_products')->insert([
            [
                'business_location_id' => '1',
                'category' => 'noodles',
                'name' => 'HaoHao [YP1]',
                'unit_price' => '5000',
                'order_period' => '2',
                'created_by' => '2',
            ],
            [
                'business_location_id' => '2',
                'category' => 'noodles',
                'name' => 'Omachi [YP2]',
                'unit_price' => '10000',
                'order_period' => '3',
                'created_by' => '6',
            ],
        ]);
    }
}
