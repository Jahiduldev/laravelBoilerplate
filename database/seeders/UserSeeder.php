<?php

namespace Database\Seeders;

use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'user_type' => UserTypeEnum::ADMIN->value,
                'status' => UserStatusEnum::ACTIVE->value,
            ],
            // vendor
            [
                'name' => 'Habib Vendor',
                'email' => 'vendor@gmail.com',
                'password' => Hash::make('vendor'),
                'user_type' => UserTypeEnum::VENDOR->value,
                'status' => UserStatusEnum::ACTIVE->value,
            ],
            // user or customer
            [
                'name' => 'Customer',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('customer'),
                'user_type' => UserTypeEnum::CUSTOMER->value,
                'status' => UserStatusEnum::ACTIVE->value,
            ],
        ]);
    }
}
