<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Spp;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class CrudSppController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function viewDataSpp()
    {
        $userData =  Auth::guard('petugas')->user();
        $spps = Spp::get()->toArray();
        return view('pages.crud.spp.view', ['petugas' => $userData, 'spps' => $spps]);
    }

    public function editDataSpp(string $id)
    {
        try {
            $userData =  Auth::guard('petugas')->user();
            // Retrieve the user data by ID using findOrFail
            $sppData = Spp::findOrFail($id);
            return view('pages.crud.spp.edit', ['petugas' => $userData, 'sppData' => $sppData]);
        } catch (\Exception $e) {
            // Handle the case where the siswa is not found
            return abort(404);
        }
    }

    public function updateDataSpp(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'tahun' => 'required',
            'nominal' => 'required',
        ]);

        try {
            $petugas = Spp::findOrFail($request->input('id'));
            $updateData = $petugas->update([
                'tahun' => $request->input('tahun'),
                'nominal' => $request->input('nominal'),
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

    public function hardDeleteDataSpp(string $id)
    {
        $spp = Spp::find($id);

        if ($spp) {
            $spp->delete(); // Soft delete the record
            Alert::success('Success', 'Spp berhasil dihapus.');
            // return redirect()->route('crud-data-spp')->with('success', 'Spp berhasil dihapus.');
            return redirect()->route('crud-data-spp');
        } else {
            Alert::error('Error', 'Spp not found');
            // return redirect()->route('crud-data-kelas')->with('error', 'Spp not found.');
            return redirect()->route('crud-data-spp');
        }
    }

    public function createDataSpp()
    {
        try {
            $userData =  Auth::guard('petugas')->user();
            return view('pages.crud.spp.create', ['petugas' => $userData]);
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();

            return abort(404);
        }
    }

    public function insertDataSpp(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'nominal' => 'required',
        ]);
        try {
            $insertData = Spp::create([
                'tahun' => $request->input('tahun'),
                'nominal' => $request->input('nominal'),
            ]);
            //add if password exist
            // print_r($insertData);
            if ($insertData) {
                Alert::success('Success', 'Data berhasil disimpan!');
                // return redirect()->back()->with([
                //     'message' => 'Data berhasil disimpan!',
                //     'status' => 'ok',
                // ]);
                return redirect()->route('crud-data-spp');
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
