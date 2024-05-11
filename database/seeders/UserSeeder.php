<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $UserData = [
            ['admin', 'admin@gmail.com', Hash::make('admin123')]
        ];

        foreach ($UserData as $data) {
            DB::table('users')->insert([
                'name' => $data[0],
                'email' => $data[1],
                'password' => $data[2],
            ]);
        }
    }
}
