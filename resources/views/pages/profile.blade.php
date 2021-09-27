@extends('layouts.layout')


@section('title')
    Profil {{ $user->name }}
@endsection


@section('content')

    <div class="col-12
                mx-auto
                mx-5 mt-2 mb-3 fs-3 pt-2 pb-3
                border border-2 border-success
                bg-gradient-to-left border-radius-15">


                <div class="row">

                    <div class="col-12 col-md-6
                             text-center">


                        <div class="p-sm-4">
                            <div class="col-6 col-sm-12
                                        mt-2
                                        mx-auto
                                        text-center">

                                    @auth
                                        @if (Auth::user()->id == $user->id)
                                        <a href="{{ route('options.show', 'awatar') }}">
                                            <img class="img-thumbnail" style="height: 300px !important; width: 300px !important;" src="{{ asset($user->avatar) }}">
                                        </a>
                                        @else
                                            <img class="img-thumbnail" style="height: 300px !important; width: 300px !important;" src="{{ asset($user->avatar) }}">
                                        @endif
                                    @endauth

                                    @guest
                                        <img class="img-thumbnail" style="height: 300px !important; width: 300px !important;" src="{{ asset($user->avatar) }}">
                                    @endguest

                            </div>

                            <div class="col-12
                                    mx-auto text-center">

                                    <span class="nick-size  text-center">
                                        <strong>{{ $user->name }}</strong>
                                    </span>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-md-6
                                mt-3
                                text-center">
                                    @if (isset($user_game_data))
                                        Punkty: {{ $user_game_data->points }} <br>
                                        Coins: {{ $user_game_data->coins }} <br>
                                        <?php $playtime_minutes = round($user_game_data->play_time_seconds / 60); ?>
                                        Czas gry:
                                        <?php
                                        if ($playtime_minutes == 1) {
                                            echo $playtime_minutes.' minuta';
                                        } else if (substr($playtime_minutes, -1) == 2 ||
                                                   substr($playtime_minutes, -1) == 3 ||
                                                   substr($playtime_minutes, -1) == 4) {
                                            echo $playtimes_minutes.' minuty';
                                        } else {
                                            echo $playtime_minutes.' minut';
                                        }
                                        ?>
                                        <br>
                                        Rekord na easy: {{ $user_game_data->easy_record }} <br>
                                        Rekord na medium: {{ $user_game_data->medium_record }} <br>
                                        Rekord na hard: {{ $user_game_data->hard_record }}
                                    @else

                                        Użytkownik jeszcze nie zdążył zagrać w Snake
                                    @endif

                    </div>

                </div>


    </div>

@endsection
