@extends('layouts.layout')

@section('title')
    Hostingi gry
@endsection

<style>
    table {
        border-collapse: collapse;
    }

    tr {
        border-bottom: 0.1vmin solid black !important;
    }
</style>

@section('content')

    <div class="col-12 col-sm-10
                mx-auto
                mx-5
                mt-2 mt-sm-4
                mb-3 fs-3
                px-4 py-3
                border border-2 border-success
                bg-gradient-to-left border-radius-15">

                <div class="col-12 text-center mb-2 fs-2">
                    <strong>Hostingi gry</strong>
                </div>

                <div class="col-12 text-center mb-2">
                    <button class="btn btn-primary border border-2 border-dark">Dodaj</button>
                </div>

                @if(count($game_hostings))

                    <table class="w-100 fs-3">

                            <tr class="row">
                                <th class="col-6 col-sm-4 center-horizontally">Nazwa</th>

                                <th class="col-4 d-none d-sm-block center-horizontally">Data dodania</th>

                                <th class="col-6 col-sm-4 text-center center-horizontally">Opcje</th>
                            </tr>

                        @foreach ($game_hostings as $game_hosting)

                            <tr class="row">
                                <td class="col-6 col-sm-4 my-2 center-horizontally">{{ $game_hosting->name }}</td>

                                <td class="col-4 d-none d-sm-block my-2 center-horizontally">{{ $game_hosting->created_at }}</td>

                                <td class="col-6 col-sm-4 my-2 text-center center-horizontally">
                                    <button class="btn btn-danger border border-2 border-dark me-2">Usuń</button>
                                    <button class="btn btn-primary border border-2 border-dark">Zmodyfikuj</button>
                                </td>
                            </tr>

                        @endforeach

                    </table>

                @else

                    <div class="text-center">Brak dodanych hostingów</div>

                @endif




    </div>

@endsection
