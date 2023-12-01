@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Data Master Spp</div>
                        </div>
                        <div class="card-body table-responsive">
                            <a href="{{ route('create-data-spp') }}">
                                <button class="btn btn-primary mb-4">Tambah Data</button>
                            </a>

                            @if (session('message'))
                                <div class="alert col-12 col-md-6 alert-success pl-2">
                                    @if (session('status') === 'ok')
                                        <i class="la la-check"></i>
                                    @endif
                                    {{ session('message') }}
                                </div>
                            @endif

                            <table id="example" class="table table-striped mt-3" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>TAHUN</th>
                                        <th>NOMINAL</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($spps)
                                        @foreach ($spps as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item['tahun'] }}</td>
                                                <td>{{ $item['nominal'] }}</td>
                                                <td>
                                                    <a href="{{ route('edit-spp', ['id' => $item['id_spp']]) }}"
                                                        class="mr-2 text-decoration-none text-info">
                                                        <h5 class="d-inline-block text-"><i class="la la la-eye"></i></h5>
                                                    </a>
                                                    <a href="{{ route('edit-spp', ['id' => $item['id_spp']]) }}"
                                                        class="mr-1 text-decoration-none text-warning">
                                                        <h5 class="d-inline-block"><i class="la la la-edit"></i></h5>
                                                    </a>
                                                    <form action="{{ route('harddelete-data-spp', $item['id_spp']) }}"
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
                                            <td colspan="4" class="text-center">Belum ada data</td>
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
