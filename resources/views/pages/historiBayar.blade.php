@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Histori Pembayaran SPP Anda</div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="example" class="table table-striped mt-3" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        @if (Auth::guard('petugas')->check())
                                            <th>NISN</th>
                                            <th>Siswa</th>
                                        @endif
                                        <th>Nominal</th>
                                        <th>Bulan Dibayar</th>
                                        <th>Tahun Dibayar</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Petugas</th>
                                    </tr>
                                </thead>
                               <tbody>
    @foreach ($historiSPP as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            @if (Auth::guard('petugas')->check())
                <td>{{ $item['nisn'] }}</td>
                <td>{{ isset($item['siswa']['nama']) ? $item['siswa']['nama'] : 'Student Information Not Available' }}</td>
            @endif
            <td>{{ isset($item['spp']['nominal']) ? 'Rp '.number_format($item['spp']['nominal']) : '' }}</td>
            <td>{{ $item['bulan_dibayar'] }}</td>
            <td>{{ $item['tahun_dibayar'] }}</td>
            <td>{{ $item['tgl_bayar'] }}</td>
            <td>Rp {{ number_format($item['jumlah_bayar']) }}</td>
            <td>{{ isset($item['petugas']['nama_petugas']) ? $item['petugas']['nama_petugas'] : '' }}</td>
        </tr>
    @endforeach
</tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        @if (Auth::guard('petugas')->check())
                                            <th>NISN</th>
                                            <th>Siswa</th>
                                        @endif
                                        <th>Nominal</th>
                                        <th>Bulan Dibayar</th>
                                        <th>Tahun Dibayar</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Petugas</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop