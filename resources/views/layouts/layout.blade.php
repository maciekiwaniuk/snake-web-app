<!DOCTYPE html>
<html lang="pl">
<head>
    <title>@yield('title')</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Strona internetowa, gdzie można pobrać grę na komputer Snake">
    <meta name="keywords" content="Snake">
    <meta name="author" content="Maciej Iwaniuk">

    <!-- favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

    <!-- Custom CSS classes -->
    <link href="{{ asset('css/custom/classes.css') }}" type="text/css" rel="stylesheet">

    <!-- Custom layout CSS -->
    <link href="{{ asset('css/custom/layout.css') }}" type="text/css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('assets/plugins/Bootstrap/bootstrap.css') }}" type="text/css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="{{ asset('assets/plugins/BootstrapIcons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- toastr CSS -->
    <link href="{{ asset('assets/plugins/toastr/toastr.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jQuery/jquery-3.6.0.min.js') }}"></script>

    <!-- toastr JS -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    @stack('assets')

    @stack('css')

    @stack('js.header')

</head>
<body>

    <div class="container-md mb-5" style="min-height: 100vh">

        <!-- NAV -->
        @if (!Auth::user())
            @include('components.nav-guest')
        @endif

        @if (Auth::check() && Auth::user()->permision == 0)
            @include('components.nav-user')
        @endif

        @if (Auth::check() && Auth::user()->permision == 2)
            @include('components.nav-admin')
        @endif
        <!-- END NAV -->

        <!-- CONTENT -->
        @yield('content')
        <!-- END CONTENT -->

    </div>

    <!-- FOOTER -->
    @include('components.footer')
    <!-- END FOOTER -->

    @stack('js.body')

    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('assets/plugins/Bootstrap/bootstrap.min.js') }}"></script>

</body>

</html>
