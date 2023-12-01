@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row row-card-no-pd">
                {{-- {{var_dump($historiSPP->pluck('bulan_dibayar')->toArray())}} --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mt-2">Entri Data Transaksi</div>
                            <span>{{$siswa['id_spp']}}</span>
                        </div>
                        <div class="card-body table-responsive">
                            {{-- @error('notfounddata')
                                <div class="alert col-12 col-md-6 alert-danger pl-2" role="alert">
                                    <i class="la la-close"></i> {{ $message }}
                                </div>
                            @enderror
                            @error('error')
                                <div class="alert col-12 col-md-6 alert-danger pl-2" role="alert">
                                    <i class="la la-close"></i> {{ $message }}
                                </div>
                            @enderror
                            @if (session('message'))
                                <div class="alert col-12 col-md-6 alert-success pl-2">
                                    @if (session('status') === 'ok')
                                        <i class="la la-check"></i>
                                    @endif
                                    {{ session('message') }}
                                </div>
                            @endif --}}
                            <form action="{{ route('create-single-data-transaksi') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NISN</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="hidden" class="form-control" name="nisn"
                                                value="{{ $siswa['nisn'] }}" placeholder="NISN">
                                                <input type="hidden" class="form-control" name="id_spp"
                                                value="{{ $siswa['id_spp'] }}">
                                            <h6>{{ $siswa['nisn'] }}</h6>
                                            @error('nisn')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NAMA</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <h6>{{ $siswa['nama'] }}</h6>
                                            @error('nisn')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">KELAS</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <h6>{{ isset($siswa['kelas']['nama_kelas']) ? $siswa['kelas']['nama_kelas'] : '' }}</h6>
                                            @error('nisn')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $currentMonth = date('n'); // Get the current month as a number (1-12)
                                @endphp
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">BULAN DIBAYAR</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <select class="form-control input-square" name="bulan_dibayar">
                                                <option value="">--Pilih bulan--</option>
                                                @foreach ($bulan as $index => $item)
                                                    @if (
                                                        !in_array($item, $historiSPP->pluck('bulan_dibayar')->toArray()) &&
                                                            $currentMonth >= array_search($item, $bulan) + 1)
                                                        <option value="{{ $item }}">{{ $item }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('bulan_dibayar')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">TAHUN DIBAYAR</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="text" class="form-control" name="tahun_dibayar"
                                                value="{{ $currentYear }}" placeholder="Tahun">
                                            @error('tahun_dibayar')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">JUMLAH YANG HARUS DIBAYAR (perbulan)</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="text" class="form-control" name="jumlah_bayar"
                                                value="{{ $nominalSPP }}" placeholder="jumlah bayar">
                                            @error('jumlah_bayar')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action px-0">
                                    <button class="btn btn-primary">Proses Pembayaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
@stop
