<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $karyawan =  Auth::guard('karyawan')->user();
        return view('profil.edit', ['karyawan' => $karyawan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawan =  Auth::guard('karyawan')->user();
        return view('profil.create', ['karyawan' => $karyawan]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate(
            [
                'nik' => 'required',
                'nama_lengkap' => 'required',
                'jabatan' => 'required',
                'telepon' => 'required',
                'password' => 'required',
            ]
        );
        DB::table('karyawan')->insert($valid);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $karyawan =  Auth::guard('karyawan')->user();
        return view('profil.edit', ['karyawan' => $karyawan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $nik =  Auth::guard('karyawan')->user()->nik;
        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'telepon' => $request->telepon
        ];
       

        DB::table('karyawan')->where('nik',$nik)->update($data);
        return redirect('/profil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        Karyawan::destroy($karyawan->nik);
        return redirect('/ptofil')->with('success', 'Data berhasil dihapus');
    }
}
