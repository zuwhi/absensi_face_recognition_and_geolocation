<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Karyawan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PresensiController extends Controller
{
    public function prosesVerif(Request $request)
    {
        $nik = $request->nik;
        $image = $request->image;
        $folderPath = "wajah/" . $nik . "/";
        $image_part = explode(";base64", $image);
        $image_base64 = base64_decode($image_part[1]);
        $cek = DB::table('karyawan')->where('nik', $nik)->pluck('verif_1')->first();

        if ($cek == 'NULL') {
            $fileName = "1.jpg";
            $data_verif = [
                'verif_1' => $fileName
            ];
        } else {
            $fileName = "2.jpg";
            $data_verif = [
                'verif_2' => $fileName
            ];
        }
        $file = $folderPath . $fileName;



        $update = DB::table('karyawan')->where('nik', $nik)->update($data_verif);

        if ($update) {
            Storage::disk('public')->put($file, $image_base64);
            $pesan = '1';
        } else {
            $pesan = '0';
        }

        $response = [
            'pesan' => $pesan,
        ];
        return response()->json($response);
    }
    public function verifwajah(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;

        $cek = DB::table('karyawan')->where('nik', $nik)->pluck('verif_1')->first();

        ($cek == 'NULL') ? $verif = 0 : $verif = 1;
        return view('profil.verifikasi', compact('nik', 'verif'));
    }
    public function getRiwayat(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $riwayat = DB::table('presensi')
            ->whereRaw("MONTH(tgl_presensi)='" . $bulan . "'")
            ->whereRaw("YEAR(tgl_presensi)='" . $tahun . "'")
            ->where('nik', $nik)->get();


        return view('presensi.detail', compact('riwayat'));
    }
    public function riwayat(Request $request)
    {
        $karyawan =  Auth::guard('karyawan')->user();
        $daftarBulan = ['', 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
        return view('presensi.riwayat', compact('karyawan', 'daftarBulan'));
    }


    public function profilEdit(Request $request)
    {
        $karyawan =  Auth::guard('karyawan')->user();
        return view('profil.edit', compact('karyawan', 'request'));
    }

    public function profilUpdate(Request $request)
    {
        $nik =  Auth::guard('karyawan')->user()->nik;
        $fotoKaryawan = DB::table('karyawan')->where('nik', $nik)->first();
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $fotoKaryawan->foto;
        }


        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $request->nama_lengkap,
                'telepon' => $request->telepon,
                'foto' => $foto
            ];
        } else {
            $data = [
                'nama_lengkap' => $request->nama_lengkap,
                'telepon' => $request->telepon,
                'password' => Hash::make($request->password),
                'foto' => $foto
            ];
        }

        $edit = DB::table('karyawan')->where('nik', $nik)->update($data);



        if ($edit) {
            if ($request->hasFile('foto')) {
                $folderPath = 'profil/karyawan/' . $foto;
                // $request->file('foto')->storeAs($folderPath, $foto);


                Storage::disk('public')->put($folderPath, file_get_contents($request->file('foto')));
            }
            return Redirect::back()->with(['success' => 'Profilmu berhasil di edit']);
        } else {
            return Redirect::back()->with(['error' => 'Maaf terjadi kesalahan, gagal edit profil']);
        }
    }


    public function absen()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $today =  date("Y-m-d");
        $cek = DB::table('presensi')->where('tgl_presensi', $today)->where('nik', $nik)->count();
        $cekPulang = DB::table('presensi')->where('tgl_presensi', $today)->where('nik', $nik)->pluck('jam_out')->first();
        if (empty($cekPulang)) {
            $cekPulang = 0;
        } else {
            $cekPulang = 1;
        };



        return view('presensi.absen', compact('cek', 'cekPulang', 'nik'));
    }

    public function prosesAbsen(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $today =  date("Y-m-d");
        $cekMasuk = DB::table('presensi')->where('tgl_presensi', $today)->where('nik', $nik)->count();
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $lat_user = $lokasiuser[0];
        $long_user = $lokasiuser[1];
        $lat_kantor = -6.61600216950022;
        $long_kantor = 110.69242794969078;

        $jarak = $this->distance($lat_kantor, $long_kantor, $lat_user, $long_user);
        $radius = round($jarak["meters"]);

        if ($radius > 100000) {
            $pesan = 'invalid_jarak';
            $response = [
                'pesan' => $pesan
            ];
        } else {
            if ($cekMasuk > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'location_out' => $lokasi
                ];
                DB::table('presensi')->where('tgl_presensi', $today)->where('nik', $nik)->update($data_pulang);
                $pesan = 'pulang';
                $response = [
                    'pesan' => $pesan
                ];
            } else {
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $today,
                    'jam_in' => $jam,
                    'location_in' => $lokasi
                ];
                $save = DB::table('presensi')->insert($data);
                if ($save) {
                    $pesan = 'masuk';
                    $response = [
                        'pesan' => $pesan
                    ];
                }
            }
        }




        return response()->json($response);
    }

    public function create()
    {
        $today =  date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $today)->where('nik', $nik)->count();
        $cekOut = DB::table('presensi')->where('tgl_presensi', $today)->where('nik', $nik)->pluck('jam_out')->first();
        if (empty($cekOut)) {
            $cekOut = 0;
        } else {
            $cekOut = 1;
        };
        return view('presensi.create', compact('cek', 'cekOut'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $lat_user = $lokasiuser[0];
        $long_user = $lokasiuser[1];

        $lat_kantor = -6.61600216950022;
        $long_kantor = 110.69242794969078;

        $jarak = $this->distance($lat_kantor, $long_kantor, $lat_user, $long_user);
        $radius = round($jarak["meters"]);

        $image = $request->image;
        $folderPath = "uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . "-" . Str::random(5) . "-" . date("H-i-s");
        $image_part = explode(";base64", $image);
        $image_base64 = base64_decode($image_part[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();
        if ($radius > 100) {
            $response = [
                'message' => 'invalid_jarak',

            ];
        } else {


            if ($cek > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'location_out' => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                if ($update) {
                    Storage::disk('public')->put($file, $image_base64);
                    $response = [
                        'message' => 'pulang',
                        'data' => [
                            'image' => $file,
                            'tempat' => $lokasi
                        ]
                    ];
                };
            } else {

                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'location_in' => $lokasi
                ];
                $save = DB::table('presensi')->insert($data);
                if ($save) {

                    Storage::disk('public')->put($file, $image_base64);
                    $response = [
                        'message' => 'masuk',
                        'data' => [
                            'image' => $file,
                            'tempat' => $lokasi
                        ]
                    ];
                }
            }
        }

        //Menghitung Jarak




        // Storage::disk('public')->put($file, $image_base64);

        return response()->json($response);




















        // $request->validate([
        //     'image' => 'image'
        // ]);

        // $image = $request->image;
        // $newImage = time() . Str::random(30) . '.png';
        // $image->move(public_path('uploads/absensi'), $newImage);

        // $response = [
        //     'message' => 'success',

        //     'data' => [
        //         'image' => asset('uploads/absensi/' . $newImage)
        //     ]
        // ];

        // return response()->json($response);
    }
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}
