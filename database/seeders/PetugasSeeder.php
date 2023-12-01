<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("petugas")->insert([
            [
                'username' => 'abdul',
                'nama_petugas' => 'Abdullah',
                'password' => Hash::make('abdul'),
                'level' => 'admin',
                'created_at' => Carbon::now(),
            ],
            [
                'username' => 'ahmad',
                'nama_petugas' => 'Ahmad Jaelani',
                'password' => Hash::make('ahmad'),
                'level' => 'petugas',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
