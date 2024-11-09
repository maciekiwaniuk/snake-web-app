@extends('layouts.layout')

@section('title')
    Ogólne statystyki
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

    <div class="col-12 col-sm-10
            mx-auto
            mx-5
            mt-2 mt-sm-4
            mb-3 fs-3
            px-4 py-3
            border border-2 border-success
            bg-gradient-to-left border-radius-15">

            <div class="col-12 text-center mb-3 fs-2">
                <strong>Statystyki</strong>
            </div>


            <table class="col-12 text-dark fs-3">

                <tr>
                    <td class="d-flex justify-content-between">
                        <div>Zarejestrowani użytkownicy</div> <div class="text-end center-vertically">{{ $users_amount }}</div>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex justify-content-between">
                        <div>Ostatnia rejestracja</div> <div class="text-end center-vertically">{{ $last_register }}</div>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex justify-content-between">
                        <div>Ostatnie logowanie</div> <div class="text-end center-vertically">{{ $last_login_time }}</div>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex justify-content-between">
                        <div>Unikalne IP</div> <div class="text-end center-vertically">{{ $ips_amount }}</div>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex justify-content-between">
                        <div>Logi aplikacji</div> <div class="text-end center-vertically">{{ $application_logs_amount }}</div>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex justify-content-between">
                        <div>Logi serwera</div> <div class="text-end center-vertically">{{ $server_logs_amount }}</div>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex justify-content-between">
                        <div>Wyświetlenia podstron</div> <div class="text-end center-vertically">{{ $total_visits_amount }}</div>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex justify-content-between">
                        <div>Wyświetlenia strony głównej</div> <div class="text-end center-vertically">{{ $welcome_page_visits_amount }}</div>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex justify-content-between">
                        <div>Pobrania gry</div> <div class="text-end center-vertically">{{ $total_game_downloads_amount }}</div>
                    </td>
                </tr>

            </table>



    </div>

@endsection
