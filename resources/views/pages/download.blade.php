@extends('layouts.layout')

@section('title')
    Pobierz grę
@endsection


@section('content')

    <div class="col-12
                mx-auto
                mx-5 mt-2 mb-3 fs-3 pt-2 pb-3
                border border-2 border-success
                bg-gradient-to-left border-radius-15">

        <div class="col-12 text-center">
            Pobierz grę
        </div>

        <div class="row text-center">

            @forelse ($hostings as $hosting)

                <div class="col-9 col-md-5
                            mt-3
                            pt-2
                            pb-3
                            mx-auto
                            bg-light
                            border border-2 border-success
                            border-radius-15">

                            <div class="col-12 pb-1">
                                {{ $hosting->hosting_name }}
                            </div>

                            <div class="col-12">
                                <a href="{{ $hosting->hosting_link }}" target="_blank" class="btn btn-success">Pobierz</a>
                            </div>
                </div>

                @if ((count($hostings) % 2 == 1) && ($loop->last))

                    <div class="col-md-5 mt-3 pt-2 pb-3 mx-auto"></div>

                @endif

            @empty

                Chwilowo nie ma żadnego dostępnego źródła, które umożliwiałoby
                pobranie gry.

            @endforelse

        </div>


    </div>

@endsection
