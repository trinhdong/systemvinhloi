<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            [
                'business_location_id' => '1',
                'supplier_code' => 'Ty-100-1',
                'name' => 'Supplier1 [YP1]',
                'name_kana' => 'Supplier1 [YP1]',
                'email' => 'supplier@gmail.com',
                'address' => 'JP',
                'phone_number' => '09031234567',
                'fax' => 'note',
                'created_by' => '2',
            ],
            [
                'business_location_id' => '2',
                'supplier_code' => 'Ty-200-2',
                'name' => 'Supplier2 [YP1]',
                'name_kana' => 'Supplier2 [YP1]',
                'email' => 'supplier2@gmail.com',
                'address' => 'JP',
                'phone_number' => '02327474737',
                'fax' => 'note',
                'created_by' => '6',
            ],
        ]);
    }
}
