<!DOCTYPE html>
<html lang="pl">
<head>
    <title>@yield('title')</title>

    <!-- Basic -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#b5e51d">

    <!-- Google -->
    <meta name="description" content="Strona internetowa, która umożliwia zagranie w grę jaką jest Snake, gdzie możesz rywalizować z innymi użytkownikami, zdobywać skiny, bić rekordy i wiele innych!">
    <meta name="keywords" content="Snake, snake-gra.pl, snake, snake-gra, Gra na komputer, Snake na komputer">
    <meta name="author" content="Maciej Iwaniuk">
    <meta name=”robots” content="index,follow">

    <!-- Android support -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="{{ env('APP_NAME') }}">
    <link rel="icon" sizes="512x512" href="{{ asset('assets/icons/512x512.png') }}">

    <!-- iOS support -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#b5e51d">
    <meta name="apple-mobile-web-app-title" content="{{ env('APP_NAME') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/icons/apple-touch-icon.png') }}">

    <!-- Windows -->
    <meta name="msapplication-TileColor" content="#b5e51d">
    <meta name="msapplication-TileImage" content="{{ asset('assets/icons/512x512.png') }}">

    <!-- Social media -->
    <meta property="og:title" content="{{ env('APP_NAME') }}">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('assets/icons/192x192.png') }}">
    <meta property="og:description" content="Strona internetowa, która umożliwia zagranie w grę jaką jest Snake, gdzie możesz rywalizować z innymi użytkownikami, zdobywać skiny, bić rekordy i wiele innych!">
    <meta property="og:locale" content="pl_PL">
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">

    <!-- manifest link -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

    <!-- Custom CSS classes -->
    <link href="{{ asset('css/custom/classes.css') }}" type="text/css" rel="stylesheet">

    <!-- Custom layout CSS -->
    <link href="{{ asset('css/custom/layout.css') }}" type="text/css" rel="stylesheet">

    <!-- Send message component CSS -->
    <link href="{{ asset('css/components/send-message.css') }}" type="text/css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('assets/plugins/Bootstrap/bootstrap.css') }}" type="text/css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="{{ asset('assets/plugins/BootstrapIcons/bootstrap-icons.css') }}" type="text/css" rel="stylesheet">

    <!-- toastr CSS -->
    <link href="{{ asset('assets/plugins/toastr/toastr.css') }}" type="text/css" rel="stylesheet">

    <!-- cookie bar CSS -->
    <link href="{{ asset('assets/plugins/cookieBar/jquery.cookieBar.css') }}" type="text/css" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jQuery/jquery-3.6.0.min.js') }}"></script>

    <!-- toastr JS -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <!-- cookie bar JS -->
    <script src="{{ asset('assets/plugins/cookieBar/jquery.cookieBar.js') }}"></script>

    <!-- js-cookie JS -->
    <script src="{{ asset('assets/plugins/js-cookie/js.cookie.min.js') }}"></script>

    @if (env('CAPTCHA_VALIDATION_ENABLED'))
        <!-- reCAPTCHA v2 JS -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    @stack('assets')

    @stack('css')

    @stack('js.header')

</head>
<body>

    <script>
        // check if serviceWorker is avaliable in the browser
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register("{{ asset('sw.js') }}");
        }

        $(function() {
            $.cookieBar({
                style: 'bottom'
            });
        });

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $(document).ready(function() {
            var messageDivCookie = Cookies.get('message-div-state');
            var cookiesState = Cookies.get('cookies-state');
            if (messageDivCookie == null) {
                $('#main-message-div').attr('class', 'message-div d-none d-xxl-block');

                if (cookiesState == null) {
                    $('#main-message-div').attr('style', 'margin-bottom: 1.7rem !important;');
                }
            } else {
                $('#after-message-div-close').attr('class', 'closed-message-div d-none d-xl-block');

                if (cookiesState == null) {
                    $('#after-message-div-close').attr('style', 'margin-bottom: 2.3rem !important;');
                }
            }

            $('#close-send-message-icon').on('click', function() {
                $('.message-div').attr('style', 'display: none !important;');
                $('#after-message-div-close').attr('class', 'closed-message-div d-none d-xl-block');
                Cookies.set('message-div-state', true, { expires: 365 });

                if (cookiesState == null) {
                    $('#after-message-div-close').attr('style', 'margin-bottom: 2rem !important;');
                }
            });

            $('.cookie-bar__btn').on('click', function() {
                if (messageDivCookie == null) {
                    $('#main-message-div').attr('style', '');
                    $('#after-message-div-close').attr('style', 'margin-bottom: 0.1rem !important;');
                }
                $('#main-message-div').attr('style', 'display: none !important;');
            });

            $('#send-message-button').on('click', function() {
                var subject = $('#subject').val();
                var sender = $('#sender').val();
                var email = $('#email').val();
                var content = $('#content').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("message.store-AJAX") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        subject: subject,
                        sender: sender,
                        email: email,
                        content: content
                    },
                    success: function(response){
                        if (response.result.error) {
                            @if (env('CAPTCHA_VALIDATION_ENABLED'))
                                grecaptcha.reset();
                            @endif
                            toastr.error(response.result.message);
                        } else {
                            toastr.success(response.result.message);
                            $('#close-message-form-button').click();
                            $('#content').val('');
                            $('#subject').val('contact');

                            @if (env('CAPTCHA_VALIDATION_ENABLED'))
                                grecaptcha.reset();
                            @endif
                        }
                    }
                });
            })

        });

    </script>

    <div class="container-md mb-5" style="min-height: 100vh">

        <!-- NAV -->
        @if (!Auth::check())
            @include('components.nav-guest')
        @endif

        @if (Auth::check() && Auth::user()->isUser())
            @include('components.nav-user')
        @endif

        @if (Auth::check() && Auth::user()->isAdmin())
            @include('components.nav-admin')
        @endif
        <!-- END NAV -->

        <!-- CONTENT -->
        @yield('content')
        <!-- END CONTENT -->

    </div>

    <!-- SEND MESSAGE ICON -->
    @include('components.send-message')
    <!-- END SEND MESSAGE ICON -->

    <!-- FOOTER -->
    @include('components.footer')
    <!-- END FOOTER -->

    @stack('js.body')

    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('assets/plugins/Bootstrap/bootstrap.min.js') }}"></script>

</body>

</html>
