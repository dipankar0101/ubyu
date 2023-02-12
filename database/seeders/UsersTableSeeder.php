<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role' => '2',
            'name' => 'Sanjoy',
            'email' => 'sanjoy@gmail.com',
            'phone' => '1234567890',
            'password' => Hash::make('1234')
        ]);
    }
}
