<!DOCTYPE html>
<html lang="pl">
<head>
    <title>@yield('title')</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Strona internetowa, gdzie można pobrać grę na komputer Snake">
    <meta name="keywords" content="Snake">
    <meta name="author" content="">

    <!-- favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

    <!-- Custom CSS classes -->
    <link href="{{ asset('css/custom/classes.css') }}" type="text/css" rel="stylesheet">

    <!-- Custom layout CSS -->
    <link href="{{ asset('css/custom/layout.css') }}" type="text/css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('bootstrap/bootstrap.css') }}" type="text/css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

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

        @if (Auth::user())
            @include('components.nav-user')
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
    <script src="{{ asset('bootstrap/bootstrap.min.js') }}"></script>
</body>

</html>
