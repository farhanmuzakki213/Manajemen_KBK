<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\DosenKBK;
use App\Models\DosenPengampuMatkul;
use App\Models\Pengurus_kbk;
use App\Models\PimpinanJurusan;
use App\Models\PimpinanProdi;
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

        $dosens = Dosen::all();
        $kajurDosenIds = PimpinanJurusan::pluck('dosen_id');
        $kaprodiDosenIds = PimpinanProdi::pluck('dosen_id');
        $dosenKbkDosenIds = DosenKBK::pluck('dosen_id');
        $pengurusKbkDosenIds = Pengurus_kbk::pluck('dosen_id');
        $dosenPengampuDosenIds = DosenPengampuMatkul::pluck('dosen_id');

        $kajurdosenIdsArray = [];
        $kaprodidosenIdsArray = [];
        $dosenkbkdosenIdsArray = [];
        $penguruskbkdosenIdsArray = [];
        $dosenpengampudosenIdsArray = [];
        foreach ($kajurDosenIds as $kajur) {
            $kajurdosenIdsArray[] = $kajur;
        }
        foreach ($kaprodiDosenIds as $kaprodi) {
            $kaprodidosenIdsArray[] = $kaprodi;
        }
        foreach ($dosenKbkDosenIds as $dosenkbk) {
            $dosenkbkdosenIdsArray[] = $dosenkbk;
        }
        foreach ($pengurusKbkDosenIds as $penguruskbk) {
            $penguruskbkdosenIdsArray[] = $penguruskbk;
        }
        foreach ($dosenPengampuDosenIds as $dosenpengampu) {
            $dosenpengampudosenIdsArray[] = $dosenpengampu;
        }


        foreach ($dosens as $dosen) {
            // Cek role berdasarkan dosen_id
            if (in_array($dosen->id_dosen, $kajurDosenIds->toArray())) {
                $user = User::create([
                    'name' => $dosen->nama_dosen,
                    'email' => $dosen->email,
                    'password' => $dosen->password,
                ]);
                $user->assignRole($pimpinanJurusanRole);
            }

            if (in_array($dosen->id_dosen, $kaprodiDosenIds->toArray())) {
                $user = User::create([
                    'name' => $dosen->nama_dosen,
                    'email' => $dosen->email,
                    'password' => $dosen->password,
                ]);
                $user->assignRole($pimpinanProdiRole);
            }

            if (in_array($dosen->id_dosen, $dosenKbkDosenIds->toArray())) {
                $user = User::create([
                    'name' => $dosen->nama_dosen,
                    'email' => $dosen->email,
                    'password' => $dosen->password,
                ]);
                $user->assignRole($dosenKBKRole);
            }

            if (in_array($dosen->id_dosen, $pengurusKbkDosenIds->toArray())) {
                $user = User::create([
                    'name' => $dosen->nama_dosen,
                    'email' => $dosen->email,
                    'password' => $dosen->password,
                ]);
                $user->assignRole($pengurusKBKRole);
            }

            if (in_array($dosen->id_dosen, $dosenPengampuDosenIds->toArray())) {
                $user = User::create([
                    'name' => $dosen->nama_dosen,
                    'email' => $dosen->email,
                    'password' => $dosen->password,
                ]);
                $user->assignRole($dosenPengampuRole);
            }
            
        }
    }
}
