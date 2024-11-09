@extends('layouts.layout')

@section('title')
    Mini gra
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


@section('content')

    <div class="row">
        <div class="mx-auto text-center
                    mt-2
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

@endsection
