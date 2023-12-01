@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('crud-data-siswa') }}" class="btn btn-info btn-xs btn-border btn-round">Back</a>
                            <div class="card-title mt-2">Detail data siswa {{ $siswa->nama }}</div>
                        </div>
                        <div class="card-body table-responsive">
                            {{-- @error('update_gagal')
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
                            <form action="{{ route('update-data-siswa') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NISN</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="hidden" class="form-control" name="oldnisn"
                                                value="{{ $siswa->nisn }}" placeholder="NISN">
                                            <input type="text" class="form-control" name="nisn"
                                                value="{{ $siswa->nisn }}" placeholder="NISN">
                                            @error('nisn')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NIS</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="text" class="form-control" name="nis"
                                                value="{{ $siswa->nis }}" placeholder="NIS">
                                            @error('nis')
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
                                            <select class="form-control input-square" name="kelas">
                                                <option value="" disabled>Pilih kelas</option>
                                                @foreach ($kelass as $kelas)
                                                    <option value="{{ $kelas->id_kelas }}"
                                                        {{ isset($siswa->kelas->id_kelas) ? ($kelas->id_kelas == $siswa->kelas->id_kelas ? 'selected' : '') : '' }}>
                                                        {{ $kelas->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                            @error('kelas')
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
                                            <input type="text" class="form-control" name="nama"
                                                value="{{ $siswa->nama }}" placeholder="Nama lengkap">
                                            @error('nama')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">ALAMAT</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <textarea class="form-control" name="alamat" rows="5">{{ $siswa->alamat }}</textarea>
                                            @error('alamat')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NO TELPON</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="text" class="form-control" name="telpon"
                                                value="{{ $siswa->no_telp }}" placeholder="Nomor Telpon">
                                            @error('telpon')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">SPP Aktif</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <select class="form-control input-square" name="spp">
                                                <option value="" disabled>Pilih data SPP Aktif</option>
                                                @foreach ($spps as $item)
                                                    <option value="{{ $item->id_spp }}"
                                                        {{ isset($siswa->spp->id_spp) ? ($item->id_spp == $siswa->spp->id_spp ? 'selected' : '') : '' }}>
                                                        {{ $item->tahun }} ( Rp {{ number_format($item->nominal) }} )
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('spp')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h6 class="text-danger">Kosongkan password & confirm password, jika tidak ingin mengubah
                                    password!</h6>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">PASSWORD</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="password" class="form-control" name="password"
                                                value="{{ old('password') }}" placeholder="Password">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">PASSWORD CONFIRMATION</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                value="{{ old('password_confirmation') }}"
                                                placeholder="Password Confirmation">
                                            @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action px-0">
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
