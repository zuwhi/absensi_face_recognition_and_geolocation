<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class logincek extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Jabatan::insert([
        //     'nama_jabatan' => 'operator'
        // ]);
        Karyawan::insert([
            'nik' => 2,
            'nama_lengkap' => '2',
            'jabatan_id' => 3,
            'telepon' => 'aa',
            'password' => Hash::make('2'),
        ]);
        // Karyawan::insert([
        //     'nik' => 2,
        //     'nama_lengkap' => '2',
        //     'jabatan' => 'aa',
        //     'telepon' => 'aa',
        //     'password' => Hash::make('2'),
        // ]);
        // $nik =  Auth::guard('karyawan')->user()->nik;
        // $data = [
        //     'nama_lengkap' => 'jokowi',
        //     'telepon' => '087878787',
        //     'password' => Hash::make('1')
        // ];


        // DB::table('karyawan')->where('nik', '1')->update($data);
    }
}
