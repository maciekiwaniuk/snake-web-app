<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom/layout.css') }}" type="text/css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('bootstrap/bootstrap.min.css') }}" type="text/css" rel="stylesheet">

    <title>@yield('title')</title>
</head>
<body>

    <div class="container-md">

        <!-- NAV -->
        @include('components.nav')
        <!-- END NAV -->

        <!-- CONTENT -->
        @yield('content')
        <!-- END CONTENT -->

    </div>

</body>

    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('bootstrap/bootstrap.min.js') }}"></script>

</html>
