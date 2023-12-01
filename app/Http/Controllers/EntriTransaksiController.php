<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Petugas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Spp;
use RealRashid\SweetAlert\Facades\Alert;

class EntriTransaksiController extends Controller
{
    public function createTransaksi()
    {
        try {
            $userData =  Auth::guard('petugas')->user();
            return view('pages.crud.transaksi.create',['petugas' => $userData]);
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function cekDataSiswa(Request $request)
    {
        $request->validate([
            'nisn'=>'required|max:10',
        ]);

        try {
            $siswa = Siswa::with(['spp', 'kelas'])->findOrFail($request->input('nisn'));
            $siswaJson = $siswa->toArray();
            // print_r($siswaJson);
            $userData =  Auth::guard('petugas')->user();
            $bulan = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ];
            $nisnSiswa = $siswa->nisn;
            $currentYear = date('Y');
            // $currentYear = '2024';
            // if change year
            if ($siswa->spp->tahun < $currentYear) {
                $siswa->update([
                    'id_spp' => $siswa->id_spp + 1
                ]);
            } 
            $historiSPP = Pembayaran::with(['siswa', 'siswa.spp'])->where('nisn', $nisnSiswa)->where('tahun_dibayar', $currentYear)->get();
            $nominalSPPsekarang = Spp::where('tahun', $currentYear)->value('nominal');
            return view('pages.crud.transaksi.edit',['petugas' => $userData, 'siswa' => $siswaJson, 'bulan' => $bulan, 'historiSPP' => $historiSPP, 'nominalSPP' => $nominalSPPsekarang, 'currentYear' => $currentYear]);
        } catch (\Exception $e) {
            // echo "woy";
            // print_r($e);
            // echo $e->getMessage();
            Alert::error('Not Found Data', $e->getMessage());
            // return redirect()->back()->withErrors(['notfounddata' => $e->getMessage()]);
            return redirect()->back();
        }
    }

    public function insertSingleTransaksi(Request $request)
    {
        $request->validate([
            'nisn'=>'required|max:10',
            // 'tgl_bayar'=>'required',
            'bulan_dibayar'=>'required',
            'tahun_dibayar'=>'required',
            'jumlah_bayar'=>'required',
            'id_spp'=>'required',
        ]);
        $userData =  Auth::guard('petugas')->user();

        $tgl_bayar = date('Y-m-d');
        $id_petugas = $userData->id_petugas;

        try {
            $insertData = Pembayaran::create([ 
                'nisn'=> $request->input('nisn'),
                'tgl_bayar'=>$tgl_bayar,
                'bulan_dibayar'=>$request->input('bulan_dibayar'),
                'tahun_dibayar'=>$request->input('tahun_dibayar'),
                'jumlah_bayar'=>$request->input('jumlah_bayar'),
                'id_spp'=>$request->input('id_spp'),
                'id_petugas' => $id_petugas
            ]);

            if($insertData) {
                Alert::success('Success', 'Data berhasil disimpan!');
                // return redirect()->back()->with([
                //     'message' => 'Data berhasil disimpan!',
                //     'status' => 'ok',
                // ]);
                return redirect()->route('histori-bayar');
            } else {
                Alert::error('Error', 'Data gagal disimpan, cek kembali data yang anda masukan!');
                // return redirect()->back()
                //             ->withInput()
                //             ->withErrors(['error' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
                return redirect()->back()->withInput();
            }
            
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            // return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            return redirect()->back();
        }
        
    }
}
