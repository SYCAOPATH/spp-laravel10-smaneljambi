<!DOCTYPE html>
<html>
<head>
    <title>Laporan</title>
    <style>
        table {
            width: 100%;
        }
        table, th, td {
            border: 0.5px solid;
        }

        th, td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Laporan Pembayaran SPP</h1>
    <table id="example" class="table table-striped mt-3" style="width:100%" style="border-collapse: collapse;">
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
                        <td>{{ $item['siswa']['nama'] }}</td>
                    @endif
                    <td>Rp {{ isset($item['spp']['nominal']) ? number_format($item['spp']['nominal']) : '' }}</td>
                    <td>{{ $item['bulan_dibayar'] }}</td>
                    <td>{{ $item['tahun_dibayar'] }}</td>
                    <td>{{ $item['tgl_bayar'] }}</td>
                    <td>Rp {{ number_format($item['jumlah_bayar']) }}</td>
                    <td>{{ isset($item['petugas']['nama_petugas']) ? $item['petugas']['nama_petugas'] : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
