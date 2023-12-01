<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
         // Mendapatkan data siswa yang sedang login
        $siswa = Auth::guard('siswa')->user();
        // dd($siswa);

        // Memuat halaman dashboard siswa dan mengirim data siswa ke view
        return view('pages.login',['siswa' => $siswa]);
    }

    public function proses_login(Request $request)
    {
        request()->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Credentials for admin and petugas
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];

        //Credentials for siswa
        $credentialsSiswa = [
            'nisn' => $request->input('username'),
            'password' => $request->input('password')
        ];

        if (Auth::guard('petugas')->attempt($credentials)) {
            $request->session()->regenerate();
            Alert::success('Berhasil login', 'Selamat datang, '.Auth::guard('petugas')->user()->nama_petugas);
            return redirect()->route('homepage');
        } else  if (Auth::guard('siswa')->attempt($credentialsSiswa)) {
            $request->session()->regenerate();
            Alert::success('Berhasil login', 'Selamat datang, '.Auth::guard('siswa')->user()->nama);
            return redirect()->route('homepage');
        }

        Alert::error('Login gagal', 'Username atau password salah atau data tidak ditemukan!');
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        Alert::success('Logout berhasil','Terimakasih sudah menggunakan aplikasi ini😊');
        return redirect()->route('login');
    }
}
