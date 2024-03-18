<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $data = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2a$12$ZQf29Yxs4YlNfjiQIcP8L..wh1XX5214C8LYMsYwIJGD5PAlNLtiS', // password
            'remember_token' => Str::random(10),
        ];
        DB::table('users')->insert($data);
    }
}
