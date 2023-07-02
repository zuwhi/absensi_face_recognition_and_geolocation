<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = date("Y-m-d");
        $karyawan = Karyawan::all();
        $presensi = Presensi::all();
        $absenToday = DB::table('presensi')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->join('jabatan', 'karyawan.jabatan_id', '=', 'jabatan.id')
            ->where('tgl_presensi', $today)
            ->get();
       $jumlahToday = Presensi::all()->where('tgl_presensi',$today)->count();
        return view('admin.dasboard', compact('karyawan', 'presensi', 'absenToday', 'jumlahToday'));
    }
}
