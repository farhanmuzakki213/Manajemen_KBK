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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Membuat peran
        $superAdminRole = Role::create(['name' => 'superAdmin']);
        $adminRole = Role::create(['name' => 'admin']);
        $pimpinanJurusanRole = Role::create(['name' => 'pimpinanJurusan']);
        $pimpinanProdiRole = Role::create(['name' => 'pimpinanProdi']);
        $dosenPengampuRole = Role::create(['name' => 'dosenMatkul']);
        $pengurusKBKRole = Role::create(['name' => 'pengurusKbk']);
        $dosenKBKRole = Role::create(['name' => 'dosenKbk']);

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
            // Cek apakah pengguna sudah ada berdasarkan email
            $existingUser = User::where('email', $dosen->email)->first();

            // Jika pengguna sudah ada, tambahkan peran sesuai dengan tabelnya
            if ($existingUser) {
                if (in_array($dosen->id_dosen, $kajurDosenIds->toArray())) {
                    $existingUser->assignRole($pimpinanJurusanRole);
                }

                if (in_array($dosen->id_dosen, $kaprodiDosenIds->toArray())) {
                    $existingUser->assignRole($pimpinanProdiRole);
                }

                if (in_array($dosen->id_dosen, $dosenKbkDosenIds->toArray())) {
                    $existingUser->assignRole($dosenKBKRole);
                }

                if (in_array($dosen->id_dosen, $pengurusKbkDosenIds->toArray())) {
                    $existingUser->assignRole($pengurusKBKRole);
                }

                if (in_array($dosen->id_dosen, $dosenPengampuDosenIds->toArray())) {
                    $existingUser->assignRole($dosenPengampuRole);
                }
            } else {
                // Jika pengguna belum ada, buat pengguna baru dan tambahkan peran
                $user = User::create([
                    'name' => $dosen->nama_dosen,
                    'email' => $dosen->email,
                    'password' => $dosen->password,
                ]);

                if (in_array($dosen->id_dosen, $kajurDosenIds->toArray())) {
                    $user->assignRole($pimpinanJurusanRole);
                }

                if (in_array($dosen->id_dosen, $kaprodiDosenIds->toArray())) {
                    $user->assignRole($pimpinanProdiRole);
                }

                if (in_array($dosen->id_dosen, $dosenKbkDosenIds->toArray())) {
                    $user->assignRole($dosenKBKRole);
                }

                if (in_array($dosen->id_dosen, $pengurusKbkDosenIds->toArray())) {
                    $user->assignRole($pengurusKBKRole);
                }

                if (in_array($dosen->id_dosen, $dosenPengampuDosenIds->toArray())) {
                    $user->assignRole($dosenPengampuRole);
                }
            }
        }

        $DataPermission = [
            ['admin-view RepProposalTA', 'web'],
            ['admin-sinkronData RepProposalTA', 'web'],
            ['admin-dashboard', 'web'],
            ['admin-view Dosen', 'web'],
            ['admin-create Dosen', 'web'],
            ['admin-update Dosen', 'web'],
            ['admin-sinkronData Dosen', 'web'],
            ['admin-delete Dosen', 'web'],
            ['admin-view DosenKbk', 'web'],
            ['admin-create DosenKbk', 'web'],
            ['admin-update DosenKbk', 'web'],
            ['admin-delete DosenKbk', 'web'],
            ['admin-import DosenKbk', 'web'],
            ['admin-export DosenKbk', 'web'],
            ['admin-view DosenMatkul', 'web'],
            ['admin-create DosenMatkul', 'web'],
            ['admin-update DosenMatkul', 'web'],
            ['admin-delete DosenMatkul', 'web'],
            ['admin-sinkronData DosenMatkul', 'web'],
            ['admin-export DosenMatkul', 'web'],
            ['admin-view JenisKbk', 'web'],
            ['admin-create JenisKbk', 'web'],
            ['admin-update JenisKbk', 'web'],
            ['admin-delete JenisKbk', 'web'],
            ['admin-export JenisKbk', 'web'],
            ['admin-import JenisKbk', 'web'],
            ['admin-view Jurusan', 'web'],
            ['admin-sinkronData Jurusan', 'web'],
            ['admin-view Kurikulum', 'web'],
            ['admin-sinkronData Kurikulum', 'web'],
            ['admin-view Mahasiswa', 'web'],
            ['admin-sinkronData Mahasiswa', 'web'],
            ['admin-view Matkul', 'web'],
            ['admin-create Matkul', 'web'],
            ['admin-update Matkul', 'web'],
            ['admin-delete Matkul', 'web'],
            ['admin-sinkronData Matkul', 'web'],
            ['admin-export Matkul', 'web'],
            ['admin-import Matkul', 'web'],
            ['admin-view MatkulKbk', 'web'],
            ['admin-create MatkulKbk', 'web'],
            ['admin-update MatkulKbk', 'web'],
            ['admin-delete MatkulKbk', 'web'],
            ['admin-export MatkulKbk', 'web'],
            ['admin-import MatkulKbk', 'web'],
            ['admin-view PengurusKbk', 'web'],
            ['admin-create PengurusKbk', 'web'],
            ['admin-update PengurusKbk', 'web'],
            ['admin-delete PengurusKbk', 'web'],
            ['admin-export PengurusKbk', 'web'],
            ['admin-import PengurusKbk', 'web'],
            ['admin-view PimpinanJurusan', 'web'],
            ['admin-sinkronData PimpinanJurusan', 'web'],
            ['admin-view PimpinanProdi', 'web'],
            ['admin-sinkronData PimpinanProdi', 'web'],
            ['admin-view Prodi', 'web'],
            ['admin-sinkronData Prodi', 'web'],
            ['admin-view ThnAkademik', 'web'],
            ['admin-sinkronData ThnAkademik', 'web'],
            ['dosenKbk-dashboard', 'web'],
            ['dosenKbk-view ReviewProposalTA', 'web'],
            ['dosenKbk-create ReviewProposalTA', 'web'],
            ['dosenKbk-update ReviewProposalTA', 'web'],
            ['dosenKbk-delete ReviewProposalTA', 'web'],
            ['dosenMatkul-dashboard', 'web'],
            ['dosenMatkul-view DosenMatkul', 'web'],
            ['dosenMatkul-create RepRps', 'web'],
            ['dosenMatkul-update RepRps', 'web'],
            ['dosenMatkul-delete RepRps', 'web'],
            ['dosenMatkul-create RepUas', 'web'],
            ['dosenMatkul-update RepUas', 'web'],
            ['dosenMatkul-delete RepUas', 'web'],
            ['pengurusKbk-dashboard', 'web'],
            ['pengurusKbk-view GrafikRps', 'web'],
            ['pengurusKbk-view GrafikUas', 'web'],
            ['pengurusKbk-view PenugasanReview', 'web'],
            ['pengurusKbk-view PenugasanHasilReview', 'web'],
            ['pengurusKbk-create PenugasanReview', 'web'],
            ['pengurusKbk-update PenugasanReview', 'web'],
            ['pengurusKbk-delete PenugasanReview', 'web'],
            ['pengurusKbk-view VerRps', 'web'],
            ['pengurusKbk-create VerRps', 'web'],
            ['pengurusKbk-update VerRps', 'web'],
            ['pengurusKbk-delete VerRps', 'web'],
            ['pengurusKbk-view VerUas', 'web'],
            ['pengurusKbk-create VerUas', 'web'],
            ['pengurusKbk-update VerUas', 'web'],
            ['pengurusKbk-delete VerUas', 'web'],
            ['pengurusKbk-view BeritaAcaraRps', 'web'],
            ['pengurusKbk-download BeritaAcaraRps', 'web'],
            ['pengurusKbk-create BeritaAcaraRps', 'web'],
            ['pengurusKbk-update BeritaAcaraRps', 'web'],
            ['pengurusKbk-delete BeritaAcaraRps', 'web'],
            ['pengurusKbk-view BeritaAcaraUas', 'web'],
            ['pengurusKbk-download BeritaAcaraUas', 'web'],
            ['pengurusKbk-create BeritaAcaraUas', 'web'],
            ['pengurusKbk-update BeritaAcaraUas', 'web'],
            ['pengurusKbk-delete BeritaAcaraUas', 'web'],
            ['pimpinanJurusan-view BeritaAcaraRpsKajur', 'web'],
            ['pimpinanJurusan-update BeritaAcaraRpsKajur', 'web'],
            ['pimpinanJurusan-view BeritaAcaraUasKajur', 'web'],
            ['pimpinanJurusan-update BeritaAcaraUasKajur', 'web'],
            ['pimpinanJurusan-dashboard', 'web'],
            ['pimpinanJurusan-view RepProposalTAJurusan', 'web'],
            ['pimpinanJurusan-view grafikRps', 'web'],
            ['pimpinanJurusan-view grafikUas', 'web'],
            ['pimpinanJurusan-view grafikProposal', 'web'],
            ['pimpinanJurusan-view RepRPSJurusan', 'web'],
            ['pimpinanJurusan-view RepSoalUASJurusan', 'web'],
            ['pimpinanProdi-view BeritaAcaraRpsProdi', 'web'],
            ['pimpinanProdi-update BeritaAcaraRpsProdi', 'web'],
            ['pimpinanProdi-view BeritaAcaraUasProdi', 'web'],
            ['pimpinanProdi-update BeritaAcaraUasProdi', 'web'],
            ['pimpinanProdi-view ProposalTaFinal', 'web'],
            ['pimpinanProdi-update ProposalTaFinal', 'web'],
            ['pimpinanProdi-export ProposalTaFinal', 'web'],
            ['pimpinanProdi-dashboard', 'web'],
            ['pimpinanProdi-view grafikRps', 'web'],
            ['pimpinanProdi-view grafikUas', 'web'],
            ['pimpinanProdi-view RepRpsProdi', 'web'],
            ['pimpinanProdi-view RepUasProdi', 'web'],
        ];
        foreach ($DataPermission as $data) {
            DB::table('permissions')->insert([
                'name' => $data[0],
                'guard_name' => $data[1],
            ]);
        }
        $permissions = DB::table('permissions')->get();

        foreach ($permissions as $permission) {
            $permissionName = $permission->name;

            $roleName = strtok($permissionName, '-');
            $role = DB::table('roles')->where('name', $roleName)->first();
            if ($role) {
                DB::table('role_has_permissions')->insert([
                    'permission_id' => $permission->id,
                    'role_id' => $role->id,
                ]);
            }
        }
    }
}
