<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$GSstXCIdpTiJ.SMmbWRRXOJr910XXxIsbwNZp.FsJzPwhft82Os2q',
            ]
        ]);
    }
}
