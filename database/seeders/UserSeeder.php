<?php

namespace Database\Seeders;

use App\Enums\EUserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'SuperAdmin',
                'user_code' => '01001',
                'email' => 'super_admin@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::SUPER_ADMIN,
                'is_admin' => '1',
                'business_location_id' => null,
            ],
            [
                'name' => 'admin_yamaplus 1',
                'user_code' => '01002',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::ADMIN,
                'is_admin' => '0',
                'business_location_id' => '1',
            ],
            [
                'name' => 'ProductManager_yamaplus 1',
                'user_code' => '01003',
                'email' => 'productManager_yamaplus@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::PRODUCT_MANAGER,
                'is_admin' => '0',
                'business_location_id' => '1',
            ],
            [
                'name' => 'Accountant_yamaplus 1',
                'user_code' => '01004',
                'email' => 'accountant_yamaplus@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::ACCOUNTANT,
                'is_admin' => '0',
                'business_location_id' => '1',
            ],
            [
                'name' => 'Seller_yamaplus 1',
                'user_code' => '01005',
                'email' => 'seller_yamaplus@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::SELLER,
                'is_admin' => '0',
                'business_location_id' => '1',
            ],
            [
                'name' => 'SellerDepartment_yamaplus 1',
                'user_code' => '01006',
                'email' => 'sellerdepartment_yamaplus@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::SELL_DEPARTMENT,
                'is_admin' => '0',
                'business_location_id' => '1',
            ],
            [
                'name' => 'admin_yamaplus2',
                'user_code' => '02001',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::ADMIN,
                'is_admin' => '0',
                'business_location_id' => '2',
            ],
            [
                'name' => 'ProductManager_yamaplus2',
                'user_code' => '02002',
                'email' => 'productManager_yamaplus2@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::PRODUCT_MANAGER,
                'is_admin' => '0',
                'business_location_id' => '2',
            ],
            [
                'name' => 'Accountant_yamaplus 2',
                'user_code' => '02003',
                'email' => 'accountant_yamaplus2@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::ACCOUNTANT,
                'is_admin' => '0',
                'business_location_id' => '2',
            ],
            [
                'name' => 'Seller_yamaplus2',
                'user_code' => '020014',
                'email' => 'seller_yamaplus2@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::SELLER,
                'is_admin' => '0',
                'business_location_id' => '2',
            ],
            [
                'name' => 'SellerDepartment_yamaplus2',
                'user_code' => '02005',
                'email' => 'sellerdepartment_yamaplus2@gmail.com',
                'password' => Hash::make('fiveVai@123'),
                'role' => EUserRole::SELL_DEPARTMENT,
                'is_admin' => '0',
                'business_location_id' => '2',
            ],
        ]);
    }
}
