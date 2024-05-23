<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([UserSeeder::class,]);
        $this->call([JurusanSeeder::class,]);
        $this->call([ThnakdSeeder::class,]);
        $this->call([ProdiSeeder::class,]);
        $this->call([HakAksesSeeder::class,]);
        $this->call([DosenSeeder::class,]);
        $this->call([BeritaSeeder::class,]);
        $this->call([JabatanPimpinanSeeder::class,]);
        $this->call([KelasSeeder::class,]);
        $this->call([KurikulumSeeder::class,]);
        $this->call([MatkulSeeder::class,]);
        $this->call([DosenMatkulSeeder::class,]);
        $this->call([PimpinanJurusanSeeder::class,]);
        $this->call([PimpinanProdiSeeder::class,]);
        $this->call([JenisKBKSeeder::class,]);
        $this->call([JabatanKBKSeeder::class,]);
        $this->call([PengurusKBKSeeder::class,]);
        $this->call([MahasiswaSeeder::class,]);
        $this->call([RepRPSSeeder::class,]);
        $this->call([RepUASSeeder::class,]);
        $this->call([VerRPSSeeder::class,]);
        $this->call([VerUASSeeder::class,]);
        $this->call([ProposalTASeeder::class,]);
        $this->call([ReviewProposalTASeeder::class,]);
        $this->call([MatkulKBKSeeder::class,]);
    }
}
