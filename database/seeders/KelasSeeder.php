<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
                'nama_kelas' => 'XII IPA 1',
                'kompetensi_keahlian' => 'IPA',
                'created_at' => Carbon::now(),
            ],
            [
                'nama_kelas' => 'XII IPA 2',
                'kompetensi_keahlian' => 'IPA',
                'created_at' => Carbon::now(),
            ],
            [
                'nama_kelas' => 'XII IPS 1',
                'kompetensi_keahlian' => 'IPS',
                'created_at' => Carbon::now(),
            ],
            [
                'nama_kelas' => 'XII IPS 2',
                'kompetensi_keahlian' => 'IPS',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
