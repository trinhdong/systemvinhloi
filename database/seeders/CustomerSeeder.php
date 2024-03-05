<?php

namespace Database\Seeders;

use App\Enums\ECustomerClassification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('customers')->insert([
           [
               'business_location_id' => '1',
               'customer_code' => 'TY-100-1',
               'name' => 'Customer1 [YP1]',
               'name_kana' => 'Customer1 [YP1]',
               'email' => 'customer1@gmail.com',
               'address' => 'JP',
               'phone_number' => '09031234567',
               'created_by' => '2',
           ],
           [
               'business_location_id' => '2',
               'customer_code' => 'TY-200-2',
               'name' => 'Customer2 [YP2]',
               'name_kana' => 'Customer2 [YP2]',
               'email' => 'customer2@gmail.com',
               'address' => 'JP',
               'phone_number' => '02302032392',
               'created_by' => '6',
           ],
       ]);
    }
}
