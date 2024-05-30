<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat peran
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $pimpinanJurusanRole = Role::create(['name' => 'pimpinan-jurusan']);
        $pimpinanProdiRole = Role::create(['name' => 'pimpinan-prodi']);
        $dosenPengampuRole = Role::create(['name' => 'dosen-pengampu']);
        $pengurusKBKRole = Role::create(['name' => 'pengurus-kbk']);
        $dosenKBKRole = Role::create(['name' => 'dosen-kbk']);

        // Mengaitkan peran dengan pengguna
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $adminUser->assignRole($adminRole);

        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $superAdminUser->assignRole($superAdminRole);

        $pimpinanJurusanUser = User::create([
            'name' => 'Pimpinan Jurusan User',
            'email' => 'pimpinanjurusan@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $pimpinanJurusanUser->assignRole($pimpinanJurusanRole);

        $pimpinanProdiUser = User::create([
            'name' => 'Pimpinan Prodi User',
            'email' => 'pimpinanprodin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $pimpinanProdiUser->assignRole($pimpinanProdiRole);

        $dosenPengampuUser = User::create([
            'name' => 'Dosen Pengampu User',
            'email' => 'dosenpengampu@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $dosenPengampuUser->assignRole($dosenPengampuRole);

        $pengurusKbkUser = User::create([
            'name' => 'Pengurus KBK User',
            'email' => 'penguruskbk@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $pengurusKbkUser->assignRole($pengurusKBKRole);

        $dosenKbkUser = User::create([
            'name' => 'Dosen KBK User',
            'email' => 'dosenkbk@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $dosenKbkUser->assignRole($dosenKBKRole);
    }
}
