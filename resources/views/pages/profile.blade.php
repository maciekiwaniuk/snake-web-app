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

                    <div class="col-6
                             text-center">


                        <div class="p-sm-4">
                            <div class="col-6 col-sm-12
                                    mt-2
                                    mx-auto
                                    text-center">

                                    @auth
                                        @if (Auth::user()->id == $user->id)
                                        <a href="{{ route('options.show', 'awatar') }}">
                                            <img class="img-thumbnail" src="{{ asset($user->avatar) }}">
                                        </a>
                                        @else
                                            <img class="img-thumbnail" src="{{ asset($user->avatar) }}">
                                        @endif
                                    @endauth

                                    @guest
                                        <img class="img-thumbnail" src="{{ asset($user->avatar) }}">
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

                    <div class="col-6 mt-3
                                    text-center">
                                    @if (isset($user->user_game_data_id) && isset($user_game_data))
                                        Coins: {{ $user_game_data->coins }} <br>
                                        Rekord na easy: {{ $user_game_data->records_easy }} <br>
                                        Rekord na medium: {{ $user_game_data->records_medium }} <br>
                                        Rekord na hard: {{ $user_game_data->records_hard }}
                                    @else

                                        Użytkownik nie dodał jeszcze postepu z gry
                                    @endif

                    </div>

                </div>


    </div>

@endsection
