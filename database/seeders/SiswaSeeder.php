<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('siswa')->insert([
            [
                'nisn' => '001123',
                'nis' => '001124',
                'nama' => 'Yulkautar',
                'password' => Hash::make('001123'),
                'id_kelas' => 4,
                'alamat' => 'Cihideunghilir',
                'no_telp' => '0812345678',
                'id_spp' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'nisn' => '001124',
                'nis' => '001125',
                'nama' => 'Tia Niandari',
                'password' => Hash::make('001124'),
                'id_kelas' => 4,
                'alamat' => 'Jatimulya',
                'no_telp' => '0812345678',
                'id_spp' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'nisn' => '001125',
                'nis' => '001126',
                'nama' => 'Agung Nugraha',
                'password' => Hash::make('001125'),
                'id_kelas' => 3,
                'alamat' => 'Pabuaran',
                'no_telp' => '0812345678',
                'id_spp' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'nisn' => '001126',
                'nis' => '001127',
                'nama' => 'Tatsa Safira',
                'password' => Hash::make('001126'),
                'id_kelas' => 3,
                'alamat' => 'Jatimulya',
                'no_telp' => '0812345678',
                'id_spp' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'nisn' => '001127',
                'nis' => '001128',
                'nama' => 'Umayah',
                'password' => Hash::make('001127'),
                'id_kelas' => 2,
                'alamat' => 'Cikeusik',
                'no_telp' => '0812345678',
                'id_spp' => 1,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
