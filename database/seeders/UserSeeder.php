<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'Admin',
            'role_id' => 1,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@123'),
            'status' => 'active',
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'role_id' => 2,
            'email' => 'user@gmail.com',
            'password' => bcrypt('user@123'),
            'status' => 'active',
        ]);
    }
}
