<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
</head>

<body class="antialiased">
    @include('sweetalert::alert')
    @yield('content')
</body>
@include('includes.footer')

</html>
