<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $profil = Auth::guard('karyawan')->user();
        $nik = Auth::guard('karyawan')->user()->nik;
        $today =  date("Y-m-d");
        $infoMasuk = DB::table('presensi')->where('tgl_presensi', $today)->where('nik', $nik)->select('jam_in')->first();
        $infoKeluar = DB::table('presensi')->where('tgl_presensi', $today)->where('nik', $nik)->select('jam_out')->first();

        $tahunini = date("Y");
        $bulanini = date("m");
        $Hariini = date("d");

        $historybulanini = DB::table('presensi')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi) = "' . $bulanini . '" ')
            ->whereRaw('YEAR(tgl_presensi) = "' . $tahunini . '"')
            ->orderBy('tgl_presensi')->get();

        $rekapBulan = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlTerlambat')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')->first();

        $leaderboard = DB::table('presensi')
                        ->join('karyawan','presensi.nik','=', 'karyawan.nik')
                        ->where('tgl_presensi', $today)
                        ->get();
       


        $daftarBulan = ['', 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
        $namaBulan = $daftarBulan[$bulanini * 1];
        return view('dashboard.dashboard', compact('profil', 'infoMasuk', 'infoKeluar', 'historybulanini', 'namaBulan', 'rekapBulan', 'leaderboard'));
    }
}
