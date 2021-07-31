<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

    <!-- Custom CSS classes -->
    <link href="{{ asset('css/custom/classes.css') }}" type="text/css" rel="stylesheet">

    <!-- Custom layout CSS -->
    <link href="{{ asset('css/custom/layout.css') }}" type="text/css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('bootstrap/bootstrap.css') }}" type="text/css" rel="stylesheet">

    <title>@yield('title')</title>
</head>
<body>

    <div class="container-md">

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

</body>

    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('bootstrap/bootstrap.min.js') }}"></script>

</html>
