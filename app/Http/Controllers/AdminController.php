<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function viewDataSiswa()
    {
        $userData = Auth::guard('petugas')->user();

        $siswas = Siswa::with(['spp', 'kelas'])->get()->toArray();
        return view('pages.crud.siswa.view', ['petugas' => $userData, 'siswas' => $siswas]);
    }

    public function editDataSiswa(string $id)
    {
        try {
            $userData = Auth::guard('petugas')->user();

            $siswa = Siswa::with(['spp', 'kelas'])->findOrFail($id);
            $kelass = Kelas::get();
            $spps = Spp::get();

            return view('pages.crud.siswa.edit', [
                'petugas' => $userData,
                'siswa' => $siswa,
                'kelass' => $kelass,
                'spps' => $spps
            ]);
        } catch (\Exception $e) {
            // Handle the case where the siswa is not found
            // return abort(404);
            Alert::info('Not Found', 'Data siswa dengan NISN: ' . $id . ' tidak ditemukan!');
            return redirect()->route('crud-data-siswa');
        }
    }

    public function updateDataSiswa(Request $request)
    {
        $request->validate([
            'oldnisn' => 'required|max:10',
            'nisn' => 'required|max:10',
            'nis' => 'required|max:10',
            'kelas' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required|max:13',
            'spp' => 'required',
            'password' => 'confirmed',
        ]);
        try {
            $siswa = Siswa::findOrFail($request->input('oldnisn'));
            $updateData = $siswa->update([
                'nisn' => $request->input('nisn'),
                'nis' => $request->input('nis'),
                'id_kelas' => $request->input('kelas'),
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'no_telp' => $request->input('telpon'),
                'id_spp' => $request->input('spp'),
            ]);
            //add if password exist
            if ($request->input('password') !== null) {
                $updateData = $siswa->update([
                    'password' => Hash::make($request->input('password')),
                ]);
            }
            if ($updateData > 0) {
                if ($request->input('oldnisn') != $request->input('nisn')) {
                    $url = "/data-siswa/{$request->input('nisn')}";
                    Alert::success('Success', 'Data berhasil diperbaharui!');
                    // return redirect($url)->with([
                    //     'message' => 'Data berhasil diperbaharui!',
                    //     'status' => 'ok',
                    // ]);
                    return redirect($url);
                } else {
                    Alert::success('Success', 'Data berhasil diperbaharui!');
                    // return redirect()->back()->with([
                    //     'message' => 'Data berhasil diperbaharui!',
                    //     'status' => 'ok',
                    // ]);
                    return redirect()->back();
                }
            } else {
                Alert::error('Update gagal', 'Data gagal diperbaharui, cek kembali data yang anda masukan!');
                // return redirect()->back()
                //     ->withInput()
                //     ->withErrors(['update_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();
            Alert::error('Update gagal', 'Data gagal diperbaharui, cek kembali data yang anda masukan!');
            // return redirect()->back()->withErrors(['update_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
            return redirect()->back();
        }
    }

    public function softDeleteDataSiswa(string $id)
    {
        $siswa = Siswa::find($id);

        if ($siswa) {
            $siswa->delete(); // Soft delete the record
            Alert::success('Success', 'Siswa berhasil dihapus.');
            // return redirect()->route('crud-data-siswa')->with('success', 'Siswa berhasil dihapus.');
            return redirect()->route('crud-data-siswa');
        } else {
            Alert::error('Error', 'Siswa not found.');
            // return redirect()->route('crud-data-siswa')->with('error', 'Siswa not found.');
            return redirect()->route('crud-data-siswa');
        }
    }

    public function createDataSiswa()
    {
        try {
            $userData =  Auth::guard('petugas')->user();

            $kelass = Kelas::get();
            $spps = Spp::get();
            return view('pages.crud.siswa.create', ['petugas' => $userData, 'kelass' => $kelass, 'spps' => $spps]);
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function insertDataSiswa(Request $request)
    {
        $request->validate([
            'nisn' => 'required|max:10',
            'nis' => 'required|max:10',
            'kelas' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required|max:13',
            'spp' => 'required',
            'password' => 'required|confirmed',
        ]);
        try {
            $insertData = Siswa::create([
                'nisn' => $request->input('nisn'),
                'nis' => $request->input('nis'),
                'id_kelas' => $request->input('kelas'),
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'no_telp' => $request->input('telpon'),
                'id_spp' => $request->input('spp'),
                'password' => Hash::make($request->input('password')),
            ]);
            //add if password exist
            // print_r($insertData);
            if ($insertData) {
                Alert::success('Success', 'Data berhasil disimpan!');
                // return redirect()->back()->with([
                //     'message' => 'Data berhasil disimpan!',
                //     'status' => 'ok',
                // ]);
                return redirect()->back();
            } else {
                Alert::error('Create gagal', 'Data gagal disimpan, cek kembali data yang anda masukan!');
                // return redirect()->back()
                //     ->withInput()
                //     ->withErrors(['create_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();
            return redirect()->back()->withErrors(['create_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!, pastikan tidak ada duplikasi data!']);
        }
    }

    public function generateLaporan()
    {
        $userData =  Auth::guard('petugas')->user();
        $historiSPP = Pembayaran::with(['siswa', 'spp', 'petugas'])->get()->toArray();
        // return view('pages.historiBayar',['petugas' => $userData, 'historiSPP' => $historiSPP]);

        // $pdf = PDF::loadView('pages.historiBayar',['petugas' => $userData, 'historiSPP' => $historiSPP]);
        $pdf = PDF::loadView('pdf.example', ['petugas' => $userData, 'historiSPP' => $historiSPP]);
        $pdf->setPaper('a4', 'landscape');
        // $pdf->download('Laporan.pdf');
        
        return $pdf->download('Laporan.pdf');
        // if ($pdf->download('Laporan.pdf')) {
        //     Alert::success('Success', 'Laporan berhasil digenerate');
        // } else {
        //     Alert::success('Error', 'Laporan gagal digenerate');
        //     return redirect()->route('histori-bayar');
        // }
    }
}
