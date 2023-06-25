<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class logincek extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Karyawan::insert([
            'nik' => '4',
            'nama_lengkap' => 'empat',
            'jabatan' => 'aa',
            'telepon' => 'aa',
            'password' => Hash::make('4'),
        ]);
    }
}
