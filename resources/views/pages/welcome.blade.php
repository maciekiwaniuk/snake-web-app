@extends('layouts.layout')

@section('title')
    Strona główna
@endsection


@push('css')
    <!-- Snake CSS -->
    <link href="{{ asset('css/snake_mini_game/snake.css') }}" type="text/css" rel="stylesheet">
@endpush


@push('js.header')
    <!-- Snake JS -->
    <script src="{{ asset('js/snake_mini_game/snake.js') }}" defer type="module"></script>
@endpush


@section('content')

    @include('components.slider')

    @include('components.snake-mini-game')

@endsection
