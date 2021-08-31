@extends('layouts.layout')

@section('title')
    Ranking
@endsection

@push('js.header')
    <!-- DataTables JS -->
    <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
    <!-- END DataTables JS -->

    <!-- BlockUI JS -->
    <script src="{{ asset('assets/plugins/jQuery BlockUI/jquery.blockUI.js') }}"></script>
    <!-- END BlockUI JS -->
@endpush

@push('css')
    <!-- DataTables CSS -->
    <link href="{{ asset('assets/plugins/DataTables/datatables.min.css') }}" rel="stylesheet" text="text/css">
    <!-- END DataTables CSS -->
@endpush


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
                    <strong>Ranking</strong>
                </div>

                <div class="btn-group w-100" style="background-color: rgb(232, 226, 226);" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="rankingRadio" id="coinsRank" autocomplete="off" checked>
                    <label class="btn btn-outline-dark" for="coinsRank">
                        Ilość <strong class="text-warning">Coins</strong>
                    </label>

                    <input type="radio" class="btn-check" name="rankingRadio" id="easyRank" autocomplete="off">
                    <label class="btn btn-outline-dark" for="easyRank">
                        Rekord na <strong class="text-success">Easy</strong>
                    </label>

                    <input type="radio" class="btn-check" name="rankingRadio" id="mediumRank" autocomplete="off">
                    <label class="btn btn-outline-dark" for="mediumRank">
                        Rekord na <strong class="text-info">Medium</strong>
                    </label>

                    <input type="radio" class="btn-check" name="rankingRadio" id="hardRank" autocomplete="off">
                    <label class="btn btn-outline-dark" for="hardRank">
                        Rekord na <strong class="text-danger">Hard</strong>
                    </label>
                </div>

                <div class="col-12
                            mx-auto text-center fs-6">

                            <div class="mt-3">
                                <table id="RankingsTable" class="table table-dark table-hover">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                </div>

    </div>

    <script>


        $(document).ready(function() {

            function blockUI() {
                // Default blockUI code
                $.blockUI({
                    css: {
                        padding: '8px',
                        backgroundColor: 'rgb(198, 234, 108)',
                        border: 'solid black 2px',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                    },
                    message: `<div class="spinner-border text-success" role="status"></div>
                              <div>Trwa wczytywanie...</div>`,
                });
                setTimeout(function () {
                    // Timer to unblock
                    $.unblockUI();
                }, 400);
            }

            // Datatables
            var rankingTable = $('#RankingsTable').DataTable({
                oLanguage: {
                    sUrl: "{{ asset('assets/plugins/DataTables/pl.json') }}"
                },
                order: [[ 0, 'asc' ]],
                lengthChange: false,
                searching: false,
                info: false,
                serverSide: false,
                ajax: {
                    url: "{{ route('ranking.get-coins') }}",
                    type: "GET",
                    datatype: "json",
                    contentType: "application/json",
                },
                columns: [
                    {
                        title: 'TOP',
                        data: '',
                        render: function (data, type, row, meta) {
                            let number = meta.row + meta.settings._iDisplayStart + 1;
                            if (meta.row == 0) {
                                return `<strong class="color-golden">`+number+`</strong>`;
                            } else if (meta.row == 1) {
                                return `<strong class="color-silver">`+number+`</strong>`;
                            } else if (meta.row == 2) {
                                return `<strong class="color-bronze">`+number+`</strong>`;
                            } else {
                                return `<span class="color-white">`+number+`</span>`;
                            }
                        },
                        class: 'align-middle',
                    },
                    {
                        title: 'Użytkownik',
                        data: function (row, type, val, meta) {
                            urlToReplace = "{{ route('profile', '__NICKNAME__') }}";
                            URL = urlToReplace.replace('__NICKNAME__', row.name);
                            if (meta.row == 0) {
                                return `<a class="link-golden" href="`+URL+`"><strong>`+row.name+`</strong>
                                        <img style="width: 25px; height: 25px; border-radius: 50%;"
                                             class="border border-1 border-secondary" src="`+row.avatar+`"></a>`;
                            } else if (meta.row == 1) {
                                return `<a class="link-silver" href="`+URL+`"><strong>`+row.name+`</strong>
                                        <img style="width: 25px; height: 25px; border-radius: 50%;"
                                             class="border border-1 border-secondary" src="`+row.avatar+`"></a>`;
                            } else if (meta.row == 2) {
                                return `<a class="link-bronze" href="`+URL+`"><strong>`+row.name+`</strong>
                                        <img style="width: 25px; height: 25px; border-radius: 50%;"
                                             class="border border-1 border-secondary" src="`+row.avatar+`"></a>`;
                            } else {
                                return `<a class="link-white" href="`+URL+`">`+row.name+`
                                <img style="width: 25px; height: 25px; border-radius: 50%;"
                                class="border border-1 border-secondary" src="`+row.avatar+`"></a>`;
                            }
                        },
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        class: 'align-middle',
                        orderable: false,
                        title: 'Ilość coins',
                        data: function (row, type, val, meta) {
                            var data;
                            if ($('#coinsRank').prop('checked')) {
                                data = row.coins;
                            } else if ($('#easyRank').prop('checked')) {
                                data = row.records_easy;
                            } else if ($('#mediumRank').prop('checked')) {
                                data = row.records_medium;
                            } else if ($('#hardRank').prop('checked')) {
                                data = row.records_hard;
                            }

                            if (meta.row == 0) {
                                return `<strong class="color-golden">`+data+`</strong>`;
                            } else if (meta.row == 1) {
                                return `<strong class="color-silver">`+data+`</strong>`;
                            } else if (meta.row == 2) {
                                return `<strong class="color-bronze">`+data+`</strong>`;
                            } else {
                                return `<span class="color-white">`+data+`</span>`;
                            }
                            // if ($('#coinsRank').prop('checked')) {
                            //     return row.users_game_data.coins;
                            // } else if ($('#easyRank').prop('checked')) {
                            //     return row.users_game_data.records_easy;
                            // } else if ($('#mediumRank').prop('checked')) {
                            //     return row.users_game_data.records_medium;
                            // } else if ($('#hardRank').prop('checked')) {
                            //     return row.users_game_data.records_hard;
                            // }
                        },
                    },
                    @if (isset(Auth::user()->permision) && Auth::user()->permision == 2)
                        {
                            title: '<span class="text-danger">ADMIN</span>',
                            class: 'align-middle',
                            orderable: false,
                            data: function (row, type, val, meta) {
                                console.log(row);
                                if (row.permision != 2) {
                                    urlDeleteUserToReplace = "{{ route('admin.delete-user', '__ID__') }}";
                                    urlDeleteUser = urlDeleteUserToReplace.replace('__ID__', row.user_id);

                                    urlBanIpToReplace = "{{ route('admin.ban-ip', '__ID__') }}";
                                    urlBanIp = urlBanIpToReplace.replace('__ID__', row.user_id);
                                    return `
                                        <form method="POST" action="`+urlBanIp+`">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-md btn-danger">Zbanuj IP</button>
                                        </form>

                                        <form method="POST" action="`+urlDeleteUser+`" class="mt-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-md btn-primary">Usuń konto</button>
                                        </form>
                                        `;
                                } else {
                                    return '-';
                                }

                            },
                        },
                    @endif
                ]
            });


            $('#coinsRank').on('click', function() {
                blockUI();
                setTimeout(function()  {
                    $(rankingTable.column(2).header()).text('Ilość Coins');
                    rankingTable.ajax.url("{{ route('ranking.get-coins') }}").load();
                }, 400);
            });
            $('#easyRank').on('click', function() {
                blockUI();
                setTimeout(function()  {
                    $(rankingTable.column(2).header()).text('Rekord na Easy');
                    rankingTable.ajax.url("{{ route('ranking.get-easy') }}").load();
                }, 400);
            });
            $('#mediumRank').on('click', function() {
                blockUI();
                setTimeout(function()  {
                    $(rankingTable.column(2).header()).text('Rekord na Medium');
                    rankingTable.ajax.url("{{ route('ranking.get-medium') }}").load();
                }, 400);
            });
            $('#hardRank').on('click', function() {
                blockUI();
                setTimeout(function()  {
                    $(rankingTable.column(2).header()).text('Rekord na Hard');
                    rankingTable.ajax.url("{{ route('ranking.get-hard') }}").load();
                }, 400);
            });

        });




    </script>

@endsection
