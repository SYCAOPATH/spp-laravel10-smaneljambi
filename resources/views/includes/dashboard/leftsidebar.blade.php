<div class="sidebar">
  <div class="scrollbar-inner sidebar-wrapper">
    <div class="user">
      <div class="photo">
        <img src="{{ asset('assets/img/profile.jpg') }}">
      </div>
      <div class="info">
        <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
          <span>
            {{ Auth::guard('petugas')->check() ? $petugas->nama_petugas : $siswa->nama }}
            <span class="user-level">{{ Auth::guard('petugas')->check() ? $petugas->level === 'admin' ? 'Administrator' : 'Petugas' : 'Siswa' }}</span>
            <span class="caret"></span>
          </span>
        </a>
        <div class="clearfix"></div>

        <div class="collapse in" id="collapseExample" aria-expanded="true" style="">
          <ul class="nav">
            <li>
              <a href="{{ route('user-setting') }}">
                <span class="link-collapse">Account Settings</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <ul class="nav">
      <li class="nav-item {{ Route::currentRouteName() === 'homepage' ? 'active' : ''}}">
        <a href="{{ route('homepage') }}">
          <i class="la la-dashboard"></i>
          <p>Dashboard</p>
        </a>
      </li>
      @if (Auth::guard('petugas')->check())
        @if ($petugas->level === 'admin')
          <li class="nav-item {{ Route::currentRouteName() === 'crud-data-siswa' ? 'active' : ''}}">
            <a href="{{ route('crud-data-siswa') }}">
              <i class="la la-users"></i>
              <p>Data Siswa</p>
            </a>
          </li>
          <li class="nav-item {{ Route::currentRouteName() === 'crud-data-petugas' ? 'active' : ''}}">
            <a href="{{ route('crud-data-petugas') }}">
              <i class="la la-user-secret"></i>
              <p>Data Petugas</p>
            </a>
          </li>
          <li class="nav-item {{ Route::currentRouteName() === 'crud-data-kelas' ? 'active' : ''}}">
            <a href="{{ route('crud-data-kelas') }}">
              <i class="la la-building"></i>
              <p>Data Kelas</p>
            </a>
          </li>
          <li class="nav-item {{ Route::currentRouteName() === 'crud-data-spp' ? 'active' : ''}}">
            <a href="{{ route('crud-data-spp') }}">
              <i class="la la-list"></i>
              <p>Data SPP</p>
            </a>
          </li>
        @endif
          <li class="nav-item {{ Route::currentRouteName() === 'create-data-transaksi' ? 'active' : ''}}">
            <a href="{{ route('create-data-transaksi') }}">
              <i class="la la-money"></i>
              <p>Transaksi</p>
            </a>
          </li>
      @endif
      <li class="nav-item {{ Route::currentRouteName() === 'histori-bayar' ? 'active' : ''}}">
        <a href="{{ route('histori-bayar') }}">
          <i class="la la-history"></i>
          <p>History Pembayaran</p>
        </a>
      </li>
    </ul>
  </div>
</div>