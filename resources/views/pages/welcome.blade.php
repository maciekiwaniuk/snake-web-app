@extends('layouts.layout')

@section('title')
    Strona główna
@endsection


@push('css')
    <!-- Welcome page CSS -->
    <link href="{{ asset('css/pages/welcome.css') }}" type="text/css" rel="stylesheet">

    <!-- Snake CSS -->
    <link href="{{ asset('css/snake_mini_game/snake.css') }}" type="text/css" rel="stylesheet">
@endpush


@push('js.header')
    <!-- Snake JS -->
    <script src="{{ asset('js/snake_mini_game/game.js') }}" defer type="module"></script>
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
                    Galeria - zdjęcia z gry</div>
    </div>

    <div class="row">
        <div id="carouselIndicators" class="col-12 col-sm-10 col-md-10 col-lg-8
                                            carousel slide mx-auto" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
            </div>
            <div class="carousel-inner border border-2">
                <div class="carousel-item active">
                    <img alt="Zdjęcie z gry #1" src="{{ asset('assets/images/slider-images/image1.jpg') }}" class="d-block w-100 slide" alt="">
                </div>
                <div class="carousel-item">
                    <img alt="Zdjęcie z gry #2" src="{{ asset('assets/images/slider-images/image2.jpg') }}" class="d-block w-100 slide" alt="">
                </div>
                <div class="carousel-item">
                    <img alt="Zdjęcie z gry #3" src="{{ asset('assets/images/slider-images/image3.jpg') }}" class="d-block w-100 slide" alt="">
                </div>
                <div class="carousel-item">
                    <img alt="Zdjęcie z gry #4" src="{{ asset('assets/images/slider-images/image4.jpg') }}" class="d-block w-100 slide" alt="">
                </div>
                <div class="carousel-item">
                    <img alt="Zdjęcie z gry #5" src="{{ asset('assets/images/slider-images/image1.jpg') }}" class="d-block w-100 slide" alt="">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- END GALLERY -->


    <!-- MINI GAME SNAKE -->
    <div class="d-block d-sm-none">
        <div class="row">
            <div class="mx-auto text-center
                        mt-2 mt-sm-4
                        mb-1
                        fs-3 py-2
                        border border-2 border-success border-radius
                        bg-gradient-to-right
                        border-radius-15"
                        style="width:92vmin !important;">
                        Snake mini-gra</div>
        </div>


        <div class="snake-game-content">
            <div id="game-board" class="border border-2 border-success"></div>
        </div>
    </div>
    <!-- END MINI GAME SNAEK -->


@endsection
