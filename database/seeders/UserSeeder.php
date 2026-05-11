<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'       => 'Owner',
                'email'      => 'owner@thrift.com',
                'password'   => Hash::make('password'),
                'role'       => 'owner',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Kasir Satu',
                'email'      => 'kasir1@thrift.com',
                'password'   => Hash::make('password'),
                'role'       => 'kasir',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Karyawan Satu',
                'email'      => 'karyawan1@thrift.com',
                'password'   => Hash::make('password'),
                'role'       => 'karyawan',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}