@extends('layouts.layout')

@section('title')
    Pobierz grę
@endsection

@push('css')
    <!-- Download page CSS -->
    <link href="{{ asset('css/pages/download.css') }}" type="text/css" rel="stylesheet">
@endpush


@section('content')

    <div class="col-12 col-sm-10
                mx-auto
                mx-5
                mt-2 mt-sm-4
                mb-3 fs-3 pt-2 pb-3
                border border-2 border-success
                bg-gradient-to-left border-radius-15">

        @if (count($game_hostings))
            <div class="col-12 text-center">
                Pobierz grę
            </div>
        @endif


        <div class="row text-center">

            @forelse ($game_hostings as $game_hosting)

                <div class="col-11 col-md-5
                            mt-3
                            pt-2
                            pb-3
                            mx-auto
                            bg-light
                            border border-2 border-success
                            border-radius-15">

                            <div class="col-12 pb-1">
                                {{ $game_hosting->name }}
                            </div>

                            <div class="col-12">
                                <a href="{{ $game_hosting->link }}" target="_blank" class="btn btn-success border border-2 border-dark download-button">Pobierz</a>
                            </div>
                </div>

                @if ((count($game_hostings) % 2 == 1) && ($loop->last))

                    <div class="col-md-5 mt-3 pt-2 pb-3 mx-auto"></div>

                @endif

            @empty

                <div class="col-8 mx-auto">
                    Chwilowo nie ma żadnego dostępnego źródła, które umożliwiałoby
                    pobranie gry.
                </div>

            @endforelse

        </div>

    </div>

    <script>
        $(document).ready(function() {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');

            $('.download-button').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url:'{{ route("game-hostings.increase-downloads") }}',
                    data: {
                        _token: csrf_token
                    }
                });
            });
        });
    </script>

@endsection
