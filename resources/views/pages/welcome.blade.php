@extends('layouts.layout')

@section('title')
    Strona główna
@endsection

@push('css')
    <!-- Welcome page CSS -->
    <link href="{{ asset('css/pages/welcome.css') }}" type="text/css" rel="stylesheet">

    <!-- Snake CSS -->
    <link href="{{ asset('css/snake_mini_game/snake-mini-game.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/snake_mini_game/snake.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/snake_mini_game/food.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/snake_mini_game/score.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/snake_mini_game/options.css') }}" type="text/css" rel="stylesheet">
    <Link href="{{ asset('css/snake_mini_game/buttons.css') }}" type="text/css" rel="stylesheet">
@endpush

@push('js.header')
    <!-- Snake JS -->
    <script src="{{ asset('js/snake_mini_game/game.js') }}" defer type="module"></script>
@endpush

@push('js.body')
    <script>
        @if (\Request::getRequestUri() == '/?verified=1')
           toastr.success('E-mail został zweryfikowany.');
        @endif
    </script>
@endpush


@section('content')

    <!-- GALLERY -->
    <div class="row">
        <div class="col-11 col-sm-10 col-md-10 col-lg-8
                    mx-auto text-center
                    mt-2 mt-sm-2
                    mb-1
                    fs-3 py-2
                    border border-2 border-success border-radius
                    bg-gradient-to-left
                    border-radius-15">
                    <a href="{{ route('gallery') }}" class="link-none">
                        Galeria - zdjęcia z gry
                    </a>
        </div>
    </div>

    @include('components.welcome-gallery')
    <!-- END GALLERY -->


    <!-- MINI GAME SNAKE -->
    <div class="row">
        <div class="mx-auto text-center
                    mt-2 mt-sm-4
                    mb-1
                    fs-3 py-2
                    border border-2 border-success border-radius
                    bg-gradient-to-right
                    border-radius-15"
                    style="width: 84vmin !important;">
                    <a href="{{ route('mini-game') }}" class="link-none">
                        Snake mini-gra
                    </a>
        </div>
    </div>

    @include('components.snake-mini-game')
    <!-- END MINI GAME SNAEK -->


@endsection
