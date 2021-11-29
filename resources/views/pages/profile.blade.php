@extends('layouts.layout')


@section('title')
    Profil {{ $user->name }}
@endsection

@push('css')
    <!-- Profile page CSS -->
    <link href="{{ asset('css/pages/profile.css') }}" type="text/css" rel="stylesheet">
@endpush


@section('content')

    <style>
        @media (min-width: 576px){
            .avatar {
                height: 300px !important;
                width: 300px !important;
            }
        }
    </style>

    <div class="col-12
                mx-auto
                mt-1 mt-sm-2 mt-md-3 mt-lg-4
                mb-3 fs-3 pt-2 pb-3
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
                                            <img alt="Awatar użytkownika" class="img-thumbnail avatar" src="{{ asset($user->avatar) }}">
                                        </a>
                                        @else
                                            <img alt="Awatar użytkownika" class="img-thumbnail avatar" src="{{ asset($user->avatar) }}">
                                        @endif
                                    @endauth

                                    @guest
                                        <img alt="Awatar użytkownika" class="img-thumbnail avatar" src="{{ asset($user->avatar) }}">
                                    @endguest

                            </div>

                            <div class="col-12
                                    mx-auto text-center">

                                    <span class="nick-size  text-center">
                                        <strong>
                                            {{ $user->name }}
                                        </strong>
                                    </span>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-md-6
                                mt-3
                                text-center">
                                    @if ($user->isBanned())

                                        <div class="text-danger">
                                            <strong>UŻYTKOWNIK ZBANOWANY</strong>
                                        </div>

                                    @else

                                        @if ($user->userGameData->points > 0)
                                            Punkty: {{ $user->userGameData->points }} <br>
                                            Monety: {{ $user->userGameData->coins }} <br>
                                            @php
                                                $playtime_minutes = round($user->userGameData->play_time_seconds / 60);
                                            @endphp
                                            Czas gry:
                                            @php
                                                if ($playtime_minutes == 1) {
                                                    echo $playtime_minutes.' minuta';
                                                } else if (substr($playtime_minutes, -1) == 2 ||
                                                        substr($playtime_minutes, -1) == 3 ||
                                                        substr($playtime_minutes, -1) == 4 &&
                                                        $playtime_minutes > 21) {
                                                    echo $playtime_minutes.' minuty';
                                                } else {
                                                    echo $playtime_minutes.' minut';
                                                }
                                            @endphp
                                            <br>
                                            Zjedzone owoce: {{ $user->userGameData->ate_fruits_amount }} <br>
                                            Rekord na Easy: {{ $user->userGameData->easy_record }} <br>
                                            Rekord na Medium: {{ $user->userGameData->medium_record }} <br>
                                            Rekord na Hard: {{$user->userGameData->hard_record }} <br>
                                            Rekord na Speed: {{ $user->userGameData->speed_record }}
                                        @else

                                            Użytkownik jeszcze nie zdążył zagrać w Snake
                                        @endif

                                    @endif



                    </div>

                </div>


    </div>

@endsection
