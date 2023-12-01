@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mt-2">Entri Data Transaksi</div>
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
                            <form action="{{ route('cek-data-siswa') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NISN</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="text" class="form-control" name="nisn"
                                                value="{{ old('nisn') }}" placeholder="NISN">
                                            @error('nisn')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action px-0">
                                    <button class="btn btn-primary">Cek data Siswa</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
@stop
