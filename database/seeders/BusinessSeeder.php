<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_locations')->insert([
            [
                'name' => 'YamaPlus1',
                'business_code' => 'TY-001',
                'address' => 'JP',
                'phone_number' => '0123456789',
                'created_by' => '1',
            ],
            [
                'name' => 'YamaPlus2',
                'business_code' => 'TY-002',
                'address' => 'JP',
                'phone_number' => '0987654321',
                'created_by' => '1',
            ],
        ]);
    }
}
