@extends('layouts.layout')

@section('title')
    Hostingi gry
@endsection

@section('content')

    <style>
        table {
            border-collapse: collapse;
        }

        tr {
            border-bottom: 0.1vmin solid black !important;
        }
    </style>

    <!-- Add game hosting modal -->
    <div class="modal fade" id="addGameHostingModal" tabindex="-1" aria-labelledby="addGameHostingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center fs-4 mb-2">
                        Modyfikacja hostingu
                    </div>

                    <form id="add-hosting-form" method="POST" action="{{ route('admin.game-hostings.store') }}">
                        @csrf
                        <label for="name">Nazwa</label>
                        <input type="text" name="name" class="form-control">
                        <label for="link" class="mt-2">Link</label>
                        <input type="text" name="link"class="form-control">
                    </form>
                </div>

                <div class="modal-footer d-flex justify-content-around">
                    <button id="add-hosting-button" type="button" class="btn btn-primary border border-2 border-dark">Potwierdź</button>
                    <button type="button" class="btn btn-secondary border border-2 border-dark" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modify game hosting modal -->
    <div class="modal fade" id="modifyGameHostingModal" tabindex="-1" aria-labelledby="modifyGameHostingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center fs-4 mb-2">
                        Modyfikacja hostingu
                    </div>

                    <form id="add-hosting-form" method="POST" action="{{ route('admin.game-hostings.store') }}">
                        @csrf
                        <label for="name">Nazwa</label>
                        <input id="name-input" type="text" name="name" class="form-control">
                        <label for="link" class="mt-2">Link</label>
                        <input id="link-input" type="text" name="link"class="form-control">
                    </form>
                </div>

                <div class="modal-footer d-flex justify-content-around">
                    <button id="add-hosting-button" type="button" class="btn btn-primary border border-2 border-dark">Potwierdź</button>
                    <button type="button" class="btn btn-secondary border border-2 border-dark" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-10
                mx-auto
                mx-5
                mt-2 mt-sm-4
                mb-3 fs-3
                px-4 py-3
                border border-2 border-success
                bg-gradient-to-left border-radius-15">

                @if ($errors->any())
                    <div class="col-12 col-sm-10 mx-auto
                                text-center mb-3 p-2 pb-3
                                mt-2 fs-6
                                border border-2 border-danger
                                border-radius-15 bg-error">
                        @foreach ($errors->all() as $error)
                            <div class="invalid-feedback d-block">
                                <strong>• {{ $error }}</strong>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="col-12 col-sm-10 mx-auto
                                text-center mb-3 p-2 pb-3
                                mt-2 fs-6
                                border border-2 border-success
                                border-radius-15 bg-complete">
                                <div class="valid-feedback d-block">
                                    <strong>• {{ session('success') }}</strong>
                                </div>
                    </div>
                @endif

                <div class="col-12 text-center mb-2 fs-2">
                    <strong>Hostingi gry</strong>
                </div>

                <div class="col-12 text-center mb-2">
                    <button class="btn btn-primary border border-2 border-dark" data-bs-toggle="modal" data-bs-target="#addGameHostingModal">Dodaj</button>
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
                                    <form method="POST" action="{{ route('admin.game-hostings.destroy', $game_hosting->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger border border-2 border-dark me-2">Usuń</button>
                                    </form>

                                    <button onclick="updateModifyHostingModal('{{ $game_hosting->name }}', '{{ $game_hosting->link }}');" class="btn btn-primary border border-2 border-dark" data-bs-toggle="modal" data-bs-target="#modifyGameHostingModal">Zmodyfikuj</button>
                                </td>
                            </tr>

                        @endforeach

                    </table>

                @else

                    <div class="text-center">Brak dodanych hostingów</div>

                @endif

    </div>


    <script>
        function updateModifyHostingModal(name, link) {
            $('#name-input').attr('value', name);
            $('#link-input').attr('value', link);
        }

        $(document).ready(function() {

            $('#add-hosting-button').on('click', function() {
                $('#add-hosting-form').submit();
            });

        });
    </script>

@endsection
