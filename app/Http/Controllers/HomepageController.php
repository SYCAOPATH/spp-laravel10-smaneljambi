<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomepageController extends Controller
{
    private function getUserLogin()
    {
        if (Auth::guard('petugas')->check()) {
            return Auth::guard('petugas')->user();
        } else {
            return Auth::guard('siswa')->user();
        }
    }

    public function index()
    {
        $userData = $this->getUserLogin();

        if (Auth::guard('petugas')->check()) {
            $level = $userData->level;
            if ($level === 'admin') {
                // Get data
                $currentYear = date('Y');
                $totalSiswa = Siswa::count();
                $totalPetugas = Petugas::count();
                $totalKelas = Kelas::count();
                $totalPembayaran = Pembayaran::where('tahun_dibayar', $currentYear)->count();

                // Set data to auth
                $userData->totalSiswa = $totalSiswa;
                $userData->totalPetugas = $totalPetugas;
                $userData->totalKelas = $totalKelas;
                $userData->totalPembayaran = $totalPembayaran;

            }
            // Send data to homepage
            return view('pages.homepage', ['petugas' => $userData]);
        } else {
            // Set Kelas siswa
            $kelasSiswa = $userData->kelas;
            $userData->kelas = $kelasSiswa;

            // Nama bulan kalender indonesia
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
                'Novermber',
                'Desember'
            ];

            // Get data transaksi
            $nisn = $userData->nisn;
            $currentYear = date('Y');
            $histori = Pembayaran::with(['siswa', 'siswa.spp'])->where('nisn', $nisn)->get();
            $nominalSpp = Spp::where('tahun', $currentYear)->value('nominal');

            return view('pages.homepage', [
                'siswa' => $userData,
                'bulan' => $bulan,
                'historiSPP' => $histori,
                'nominalSPP' => $nominalSpp
            ]);
        }
    }

    public function historiBayar()
    {
        $userData = $this->getUserLogin();
        if (Auth::guard('siswa')->check()) {
            $nisnSiswa = $userData->nisn;
            $historiSPP = Pembayaran::with(['siswa', 'spp', 'petugas'])->where('nisn', $nisnSiswa)->get()->toArray();
            // print_r($historiSPP);
            return view('pages.historiBayar', ['siswa' => $userData, 'historiSPP' => $historiSPP]);
        } else {
            $historiSPP = Pembayaran::with(['siswa', 'spp', 'petugas'])->get()->toArray();
            return view('pages.historiBayar', ['petugas' => $userData, 'historiSPP' => $historiSPP]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function userSetting()
    {
        $userData = $this->getUserLogin();
        if (Auth::guard('siswa')->check()) {
            $kelasSiswa = $userData->kelas;
            $userData->kelas = $kelasSiswa;
            return view('pages.setting.siswa', ['siswa' => $userData]);
        } else {
            return view('pages.setting.petugas', ['petugas' => $userData]);
        }
    }

    public function userUpdateSetting(Request $request)
    {
        $userData = $this->getUserLogin();
        if (Auth::guard('siswa')->check()) {
            $nisnSiswa = $userData->nisn;
            $request->validate([
                'nama' => 'required',
                'alamat' => 'required',
                'telpon' => 'required|max:13',
            ]);

            try {
                $updateData = Siswa::where('nisn', $nisnSiswa)
                    ->update([
                        'nama' => $request->input('nama'),
                        'alamat' => $request->input('alamat'),
                        'no_telp' => $request->input('telpon'),
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
                    //         ->withInput()
                    //         ->withErrors(['update_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
                    return redirect()->back()->withInput();
                }
            } catch (\Exception $e) { // I don't remember what exception it is specifically
                Alert::error('Update gagal', 'Data gagal diperbaharui, cek kembali data yang anda masukan!');
                // return redirect()->back()->withErrors(['update_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
                return redirect()->back();
            }
        }
    }

    public function petugasUpdateSetting(Request $request)
    {
        $userData = $this->getUserLogin();
        if (Auth::guard('petugas')->check()) {
            $levelCurrent = $userData->level;

            if ($levelCurrent != 'admin' && ($request->input('level') !== null)) {
                Alert::error('Error', 'Data tidak valid!');
                // return redirect()->back()
                //     ->withInput()
                //     ->withErrors(['error' => 'Data tidak valid!']);
                return redirect()->back()->withInput();
            }

            $request->validate([
                'username_old' => 'required',
                'username' => 'required',
                'nama_petugas' => 'required',
                'level' => 'in:admin,petugas',
            ]);

            try {
                $rawPetugas = Petugas::where('username', $request->input('username_old'));
                $updateData = $rawPetugas->update([
                    'username' => $request->input('username'),
                    'nama_petugas' => $request->input('nama_petugas')
                ]);
                //add if level exist
                if ($request->input('level') !== null) {
                    $rawPetugas->update([
                        'level' => $request->input('level'),
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
            } catch (\Exception $e) { // I don't remember what exception it is specifically
                Alert::error('Update gagal', $e->getMessage());
                // return redirect()->back()->withErrors(['update_gagal' => $e->getMessage()]);
                return redirect()->back();
            }
        }
    }
}
