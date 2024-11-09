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

        .bg-accordion-button {
            background-color: rgb(242, 180, 66) !important;
        }
        .bg-accordion-button:hover {
            background-color: rgb(189, 148, 73) !important;
        }

        .bg-accordion-body {
            background-color: rgb(244, 234, 194) !important;
            font-size: 1.2rem;
            font-weight: 500;
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
                                            <img alt="Awatar użytkownika" class="img-thumbnail avatar" src="{{ asset($user->avatar_path) }}">
                                        </a>
                                        @else
                                            @if (Auth::check() && Auth::user()->isAdmin())
                                                <a href="{{ route('admin.users.show-name-by-id', $user->id) }}">
                                                    <img alt="Awatar użytkownika" class="img-thumbnail avatar" src="{{ asset($user->avatar_path) }}">
                                                </a>
                                            @else
                                                <img alt="Awatar użytkownika" class="img-thumbnail avatar" src="{{ asset($user->avatar_path) }}">
                                            @endif
                                        @endif
                                    @endauth

                                    @guest
                                        <img alt="Awatar użytkownika" class="img-thumbnail avatar" src="{{ asset($user->avatar_path) }}">
                                    @endguest

                            </div>

                            <div class="col-12
                                    mx-auto text-center">

                                    <span class="nick-size text-center">
                                        <strong>
                                            @if (Auth::check() && Auth::user()->isAdmin() && Auth::user()->id != $user->id)
                                                <a href="{{ route('admin.users.show', $user->name) }}" class="link-none">
                                                    {{ $user->name }}
                                                </a>
                                            @else
                                                {{ $user->name }}
                                            @endif
                                        </strong>
                                    </span>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-md-6
                                mt-3
                                ps-4 ps-md-4
                                pe-4 pe-md-5
                                text-center">
                                    {{-- User is banned  --}}
                                    @if ($user->isBanned())

                                        <div class="text-danger">
                                            <strong>UŻYTKOWNIK ZBANOWANY</strong>
                                        </div>

                                    {{-- User is not banned --}}
                                    @else
                                        {{-- The profile belongs to the logged user --}}
                                        @if(Auth::check() && Auth::user()->id == $user->id)
                                            <div class="accordion mb-2" id="accordionProfileOptions">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            <strong>Ustawienia widoczności profilu dla innych użytkowników</strong>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionProfileOptions">
                                                        <div class="accordion-body bg-accordion-body">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-5 col-md-12 col-xl-5
                                                                            pb-2 pb-sm-0 pb-md-2 pb-xl-0
                                                                            center-vertically">
                                                                    Informacje z gry
                                                                </div>

                                                                <div class="col-12 col-sm-7 col-md-12 col-xl-7">
                                                                    <div class="btn-group d-sm-flex" style="background-color: rgb(232, 226, 226);" role="group" aria-label="Basic radio toggle button group">
                                                                        <input type="radio" class="btn-check" name="profile_status_visibility" id="profileStatusPublicRadio" autocomplete="off" @if($user->profile_visibility_status == 'public')checked @endif>
                                                                        <label class="btn btn-outline-dark" for="profileStatusPublicRadio">Widoczne</label>

                                                                        <input type="radio" class="btn-check" name="profile_status_visibility" id="profileStatusPrivateRadio" autocomplete="off" @if($user->profile_visibility_status == 'private')checked @endif>
                                                                        <label class="btn btn-outline-dark" for="profileStatusPrivateRadio">Ukryte</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- User's profile visibility status is set to public --}}
                                        @if ($user->profile_visibility_status == 'public' || (Auth::check() && Auth::user()->id == $user->id))

                                            {{-- User played game --}}
                                            @if (isset($user->userGameData->points) && $user->userGameData->points > 0)
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

                                            {{-- User hasn't played game yet --}}
                                            @else
                                                Użytkownik jeszcze nie zdążył zagrać w Snake
                                            @endif

                                        {{-- User's profile visibility status is set to private --}}
                                        @else
                                            Użytkownik {{ $user->name }} woli pozostawić informacje o swojej grze dla siebie.
                                        @endif



                                    @endif



                    </div>

                </div>


    </div>


    <script>
        $(document).ready(function() {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');

            $('#profileStatusPublicRadio').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("profile.options.change-profile-visibility-status") }}',
                    data: {
                        _token: csrf_token,
                        status: 'public'
                    }
                });
            });

            $('#profileStatusPrivateRadio').on('click', function(event) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("profile.options.change-profile-visibility-status") }}',
                    data: {
                        _token: csrf_token,
                        status: 'private'
                    }
                });
            });

        });
    </script>

@endsection
