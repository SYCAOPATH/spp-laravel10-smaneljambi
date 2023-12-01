<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class CrudPetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function viewDataPetugas()
    {
        $checkUserLoginData =  Auth::guard('petugas')->user();
        $petugass = Petugas::get()->toArray();
        return view('pages.crud.petugas.view', ['petugas' => $checkUserLoginData, 'petugass' => $petugass]);
    }

    public function editDataPetugas(string $id)
    {
        try {
            $checkUserLoginData =  Auth::guard('petugas')->user();
            // Retrieve the user data by ID using findOrFail
            $petugasData = Petugas::findOrFail($id);
            return view('pages.crud.petugas.edit', ['petugas' => $checkUserLoginData, 'petugasData' => $petugasData]);
        } catch (\Exception $e) {
            // Handle the case where the siswa is not found
            return abort(404);
        }
    }

    public function updateDataPetugas(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'username' => 'required|max:25',
            'password' => 'confirmed',
            'nama_petugas' => 'required',
            'level' => 'required|in:admin,petugas',
        ]);

        try {
            $petugas = Petugas::findOrFail($request->input('id'));
            $updateData = $petugas->update([
                'username' => $request->input('username'),
                'nama_petugas' => $request->input('nama_petugas'),
                'level' => $request->input('level'),
            ]);
            //add if password exist
            if ($request->input('password') !== null) {
                $updateData = $petugas->update([
                    'password' => Hash::make($request->input('password')),
                ]);
            }
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

    public function hardDeleteDataPetugas(string $id)
    {
        $petugas = Petugas::find($id);

        if ($petugas) {
            $petugas->delete(); // Soft delete the record
            Alert::success('Success', 'Petugas berhasil dihapus!');
            // return redirect()->route('crud-data-petugas')->with('success', 'Petugas berhasil dihapus.');
            return redirect()->route('crud-data-petugas');
        } else {
            Alert::error('Error', 'Petugas not found.');
            // return redirect()->route('crud-data-petugas')->with('error', 'Petugas not found.');
            return redirect()->route('crud-data-petugas');
        }
    }

    public function createDataPetugas()
    {
        try {
            $checkUserLoginData =  Auth::guard('petugas')->user();
            return view('pages.crud.petugas.create', ['petugas' => $checkUserLoginData]);
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();

            return abort(404);
        }
    }

    public function insertDataPetugas(Request $request)
    {
        $request->validate([
            'username' => 'required|max:25',
            'password' => 'confirmed',
            'nama_petugas' => 'required',
            'level' => 'required|in:admin,petugas',
        ]);
        try {
            $insertData = Petugas::create([
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                'nama_petugas' => $request->input('nama_petugas'),
                'level' => $request->input('level'),
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
