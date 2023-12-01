<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class CrudKelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function viewDataKelas()
    {
        $userData =  Auth::guard('petugas')->user();
        $kelass = Kelas::get()->toArray();
        return view('pages.crud.kelas.view', ['petugas' => $userData, 'kelass' => $kelass]);
    }

    public function editDataKelas(string $id)
    {
        try {
            $userData =  Auth::guard('petugas')->user();
            // Retrieve the user data by ID using findOrFail
            $kelasData = Kelas::findOrFail($id);
            return view('pages.crud.kelas.edit', ['petugas' => $userData, 'kelasData' => $kelasData]);
        } catch (\Exception $e) {
            // Handle the case where the siswa is not found
            return abort(404);
        }
    }

    public function updateDataKelas(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'nama_kelas' => 'required|max:10',
            'kompetensi_keahlian' => 'required',
        ]);

        try {
            $kelas = Kelas::findOrFail($request->input('id'));
            $updateData = $kelas->update([
                'nama_kelas' => $request->input('nama_kelas'),
                'kompetensi_keahlian' => $request->input('kompetensi_keahlian'),
            ]);
            if ($updateData > 0) {
                Alert::success('Success', 'Data berhasil diperbaharui!');
                // return redirect()->back()->with([
                //     'message' => 'Data berhasil diperbaharui!',
                //     'status' => 'ok',
                // ]);
                return redirect()->back();
            } else {
                Alert::error('Update gagal', 'Data gagal diperbaharui, cek kembali data yang anda masukan!');
                // return redirect()->back()
                //     ->withInput()
                //     ->withErrors(['update_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Alert::error('Update gagal', 'Data gagal diperbaharui, cek kembali data yang anda masukan!');
            // echo "error kje";
            //  echo $e->getMessage()
            // return redirect()->back()->withErrors(['update_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
            return redirect()->back();
        }
    }

    public function hardDeleteDataKelas(string $id)
    {
        $kelas = Kelas::find($id);

        if ($kelas) {
            $kelas->delete(); // Soft delete the record
            Alert::success('Success', 'Kelas berhasil dihapus.');
            // return redirect()->route('crud-data-kelas')->with('success', 'Kelas berhasil dihapus.');
            return redirect()->route('crud-data-kelas');
        } else {
            Alert::error('Error', 'Kelas not found.');
            // return redirect()->route('crud-data-kelas')->with('error', 'Kelas not found.');
            return redirect()->route('crud-data-kelas');
        }
    }

    public function createDataKelas()
    {
        try {
            $userData =  Auth::guard('petugas')->user();
            return view('pages.crud.kelas.create', ['petugas' => $userData]);
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();

            return abort(404);
        }
    }

    public function insertDataKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|max:10',
            'kompetensi_keahlian' => 'required',
        ]);
        try {
            $insertData = Kelas::create([
                'nama_kelas' => $request->input('nama_kelas'),
                'kompetensi_keahlian' => $request->input('kompetensi_keahlian'),
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
                Alert::error('Create gagal', 'Data gagal diperbaharui, cek kembali data yang anda masukan!');
                // return redirect()->back()
                //     ->withInput()
                //     ->withErrors(['create_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();
            Alert::error('Create gagal', 'Data gagal diperbaharui, cek kembali data yang anda masukan!');
            // return redirect()->back()->withErrors(['create_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!, pastikan tidak ada duplikasi data!']);
            return redirect()->back();
        }
    }
}
