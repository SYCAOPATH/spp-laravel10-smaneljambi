@extends('layouts.dashboard')

@section('content')
  <div class="container-fluid">
    <div class="row row-card-no-pd">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              Data Siswa
            </div>
          </div>
          <div class="card-body table-responsive">
            <a href="{{ route('create-data-siswa') }}" class="btn btn-primary mb-4">Tambah Siswa</a>

            <table id="example" class="table table-striped mt-3" style="width: 100%;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>NISN</th>
                  <th>NIS</th>
                  <th>NAMA</th>
                  <th>KELAS</th>
                  <th>AKSI</th>
                </tr>
              </thead>
              <tbody>
                @if ($siswas)
                  @foreach ($siswas as $index => $item)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $item['nisn'] }}</td>
                      <td>{{ $item['nis'] }}</td>
                      <td>{{ $item['nama'] }}</td>
                      <td>{{ $item['kelas']['nama_kelas'] ? $item['kelas']['nama_kelas'] : '' }}</td>
                      <td>
                        <a href="{{ route('edit-siswa', ['id' => $item['nisn']]) }}" class="mr-2 text-decoration-none text-info">
                          <h5 class="d-inline-block"><i class="la la-eye"></i></h5>
                        </a>
                        <a href="{{ route('edit-siswa', ['id' => $item['nisn']]) }}" class="mr-2 text-decoration-none text-warning">
                          <h5 class="d-inline-block"><i class="la la-edit"></i></h5>
                        </a>
                        <form action="{{ route('softdelete-data-siswa', $item['nisn']) }}" method="POST" class="d-inline-block">
                          @csrf

                          @method('DELETE')

                          <button type="submit" class="text-danger d-inline-block" style="border: none; background: transparent; cursor: pointer;">
                            <h5 class="d-inline-block">
                              <i class="la la-trash"></i>
                            </h5>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop