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
@endpush

@push('js.header')
    <!-- Snake JS -->
    <script src="{{ asset('js/snake_mini_game/game.js') }}" defer type="module"></script>
@endpush


@section('content')

    @include('components.snake-mini-game')

@endsection
