<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan = Karyawan::all();
        $jabatan = Jabatan::all();

        return view('admin.karyawan.index', compact('karyawan', 'jabatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawan = Karyawan::all();
        $jabatan = Jabatan::all();
        return view('admin.karyawan.create', compact('karyawan', 'jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //   dd($request->jabatan_id);
        $data = [
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan_id' => $request->jabatan_id,
            'telepon' => $request->telepon,
            'password' => Hash::make($request->password)
        ];

        // sebelum menambah data tambahkan fitur mengirim wa otomatis

        $tambah = Karyawan::create($data);
        if ($tambah) {
            return redirect('/admin/karyawan')->with('success', 'Data berhasil ditambahkan');
        } else {
            return 'gagal';
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {

        return view('admin.karyawan.detail', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {

        $nik = $request->nik;

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan_id' => $request->jabatan_id,
            'telepon' => $request->telepon
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $edit = DB::table('karyawan')->where('nik', $nik)->update($data);
        } else {
            $edit = DB::table('karyawan')->where('nik', $nik)->update($data);
        }
        if ($edit) {
            return redirect('/admin/karyawan')->with('success', 'Data berhasil di edit');
        } else {
            return 'false';
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        Karyawan::destroy($karyawan->nik);
        return redirect('/admin/karyawan')->with('success', 'Data berhasil di hapus');
    }
}
