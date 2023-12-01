@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Data Master Petugas</div>
                        </div>
                        <div class="card-body table-responsive">
                            <a href="{{ route('create-data-petugas') }}">
                                <button class="btn btn-primary mb-4">Tambah Data</button>
                            </a>

                            {{-- @if (session('message'))
                                <div class="alert col-12 col-md-6 alert-success pl-2">
                                    @if (session('status') === 'ok')
                                        <i class="la la-check"></i>
                                    @endif
                                    {{ session('message') }}
                                </div>
                            @endif --}}

                            <table id="example" class="table table-striped mt-3" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>USERNAME</th>
                                        <th>NAMA PETUGAS</th>
                                        <th>LEVEL</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($petugass)
                                        @foreach ($petugass as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item['username'] }}</td>
                                                <td>{{ $item['nama_petugas'] }}</td>
                                                <td>{{ $item['level'] }}</td>
                                                <td>
                                                    <a href="{{ route('edit-petugas', ['id' => $item['id_petugas']]) }}"
                                                        class="mr-2 text-decoration-none text-info">
                                                        <h5 class="d-inline-block text-"><i class="la la la-eye"></i></h5>
                                                    </a>
                                                    <a href="{{ route('edit-petugas', ['id' => $item['id_petugas']]) }}"
                                                        class="mr-1 text-decoration-none text-warning">
                                                        <h5 class="d-inline-block"><i class="la la la-edit"></i></h5>
                                                    </a>
                                                    <form
                                                        action="{{ route('harddelete-data-petugas', $item['id_petugas']) }}"
                                                        method="POST" style="display: inline-block"
                                                        onsubmit="return confirm('Apa kamu yakin mau menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-danger"
                                                            style="border: none; display: inline-block;background: transparent;cursor: pointer;">
                                                            <h5 class="d-inline-block"><i class="la la la-trash"></i></h5>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
@stop
