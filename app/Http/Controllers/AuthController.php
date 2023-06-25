<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        $credentials = $request->only('nik', 'password');
        if (Auth::guard('karyawan')->attempt($credentials)) {
            return redirect()->intended('/dashboard');
        } else {
            return redirect('/')->with(['warning' => 'nik atau password salah']);
        };
    }
    public function proseslogout()
    {
        echo "cek";
        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
            return redirect('/');
        }
    }
    public function index(){
        echo 'njir';
    }
}
