<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
</head>

<body class="antialiased">
  @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
  <div class="wrapper">
    @include('includes.dashboard.topbar')
    @include('includes.dashboard.leftsidebar')
    <div class="main-panel">
      <div class="content">
        @yield('content')
      </div>
      @include('includes.dashboard.footbar')
    </div>
  </div>
</body>
@include('includes.footer')

</html>
