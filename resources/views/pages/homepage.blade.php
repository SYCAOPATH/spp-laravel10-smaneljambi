@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Selamat datang {{ Auth::guard('siswa')->check() ? $siswa->nama : $petugas->nama_petugas }}
            </h4>
            @if (Auth::guard('petugas')->check())
                @php
                    
                    $currentYear = date('Y');
                    
                @endphp
                @if ($petugas->level === 'admin')
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-stats card-warning">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="la la-users"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 d-flex align-items-center">
                                            <div class="numbers">
                                                <p class="card-category">Data Siswa</p>
                                                <h4 class="card-title">{{ $petugas->totalSiswa }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats card-success">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="la la-user-secret"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 d-flex align-items-center">
                                            <div class="numbers">
                                                <p class="card-category">Data Petugas</p>
                                                <h4 class="card-title">{{ $petugas->totalPetugas }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats card-danger">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="la la-building"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 d-flex align-items-center">
                                            <div class="numbers">
                                                <p class="card-category">Data Kelas</p>
                                                <h4 class="card-title">{{ $petugas->totalKelas }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats card-primary">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="la la-money"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 d-flex align-items-center">
                                            <div class="numbers">
                                                <p class="card-category">Transaksi {{ $currentYear }}</p>
                                                <h4 class="card-title">{{ $petugas->totalPembayaran }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="row row-card-no-pd">

                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">SPP Tahun 2023</div>
                            </div>
                            @php
                                $currentMonth = date('n'); // Get the current month as a number (1-12)
                                $currentYear = date('Y');
                                $totalUnpaid = 0;
                            @endphp
                            {{-- @foreach ($bulan as $bulanItem)
                                <p>
                                    {{ $bulanItem }}
                                    @if (in_array($bulanItem, $historiSPP->pluck('bulan_dibayar')->toArray()))
                                        lunas
                                    @elseif ($currentMonth < array_search($bulanItem, $bulan) + 1)
                                        -
                                    @else
                                        menunggak
                                    @endif
                                </p>
                            @endforeach --}}
                            <div class="card-body">
                                <table class="table table-head-bg-info">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Bulan</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bulan as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item }}</td>
                                                <td>
                                                    @if (in_array($item, $historiSPP->pluck('bulan_dibayar')->toArray()))
                                                        <span class="badge badge-success">Lunas</span>
                                                    @elseif ($currentMonth < array_search($item, $bulan) + 1)
                                                        -
                                                    @else
                                                        @php
                                                            $totalUnpaid += $nominalSPP;
                                                        @endphp
                                                        <span class="badge badge-danger">Belum Membayar</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <p>Biaya SPP Perbulan: Rp {{ number_format($nominalSPP) }}</p>
                                <p>Total Pembayaran Belum Dibayar: Rp {{ number_format($totalUnpaid) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                @php
                                    $unpaidMonths = [];
                                    
                                    // Create an array of unpaid months
                                    foreach ($bulan as $bulanItem) {
                                        $bulanIndex = array_search($bulanItem, $bulan) + 1;
                                        $isUnpaid = !in_array($bulanItem, $historiSPP->pluck('bulan')->toArray()) && $bulanIndex <= $currentMonth;
                                        if ($isUnpaid) {
                                            $unpaidMonths[] = $bulanItem;
                                        }
                                    }
                                @endphp
                                @if (count($unpaidMonths) > 0)
                                    <p class="fw-bold mt-1">Tagihan SPP Anda Bulan ini (sampai
                                        {{ $bulan[$currentMonth - 1] }}
                                        {{ $currentYear }})</p>
                                    <h4><b>Rp {{ number_format($totalUnpaid) }}</b></h4>
                                    <h6 class="mt-3 border border-info text-center p-2 rounded">Pembayaran dilakukan ke
                                        Petugas!
                                    </h6>
                                @else
                                    <h1 class="display-2 text-center"><i class="la la-check-circle text-success "></i>
                                    </h1>
                                    <h4 class="text-center">SPP sampai bulan {{ $bulan[$currentMonth - 1] }}
                                        {{ $currentYear }}
                                        anda sudah
                                        lunas!</h4>
                                @endif


                            </div>
                            {{-- @foreach ($historiSPP as $index => $item)
                                {{ $item->bulan_dibayar }}
                            @endforeach --}}
                            <div class="card-footer">
                                <ul class="nav">
                                    <li class="nav-item"><a class="btn btn-default btn-link"
                                            href="{{ route('histori-bayar') }}"><i class="la la-history"></i> History</a>
                                    </li>
                                    <li class="nav-item ml-auto"><a class="btn btn-default btn-link"
                                            href="{{ route('homepage') }}"><i class="la la-refresh"></i> Refresh</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title mb-4">Data diri anda</div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NISN</span>
                                    </div>
                                    <p class="card-category">{{ $siswa->nisn }}</p>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NIS</span>
                                    </div>
                                    <p class="card-category">{{ $siswa->nis }}</p>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NAMA</span>

                                    </div>
                                    <p class="card-category">{{ $siswa->nama }}</p>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">ALAMAT</span>

                                    </div>
                                    <p class="card-category">{{ $siswa->alamat }}</p>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NO TELPON</span>

                                    </div>
                                    <p class="card-category">{{ $siswa->no_telp }}</p>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">KELAS</span>

                                    </div>
                                    <p class="card-category">{{ isset($siswa->kelas->nama_kelas) ? $siswa->kelas->nama_kelas : '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif


        </div>
    </div>
@stop
