@extends('layouts.layout')

@section('title')
    Ranking
@endsection

@push('js.header')
    <!-- DataTables JS -->
    <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
    <!-- END DataTables JS -->

    <!-- BlockUI JS -->
    <script src="{{ asset('assets/plugins/jQueryBlockUI/jquery.blockUI.js') }}"></script>
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
                px-2 px-sm-4 py-3
                border border-2 border-success
                bg-gradient-to-left border-radius-15">

                <div class="col-12 text-center mb-2 fs-2">
                    <strong>Ranking</strong>
                </div>

                <div class="btn-group w-100 d-none d-sm-flex" style="background-color: rgb(232, 226, 226);" role="group" aria-label="Ranking button group">

                    <input type="radio" class="btn-check" name="rankingRadio" id="pointsRank" autocomplete="off" checked>
                    <label class="btn btn-outline-dark" for="pointsRank">
                        Ilość <strong class="text-primary">Punktów</strong>
                    </label>

                    <input type="radio" class="btn-check" name="rankingRadio" id="coinsRank" autocomplete="off">
                    <label class="btn btn-outline-dark" for="coinsRank">
                        Ilość <strong class="text-warning">Monet</strong>
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

                    <input type="radio" class="btn-check" name="rankingRadio" id="speedRank" autocomplete="off">
                    <label class="btn btn-outline-dark" for="speedRank">
                        Rekord na <strong class="text-purple">Speed</strong>
                    </label>

                </div>

                <div class="btn-group w-100 d-flex d-sm-none border-bottom border-2 border-light" style="background-color: rgb(232, 226, 226);" role="group" aria-label="Ranking button group">

                    <button type="button" class="btn btn-dark" id="pointsSelected">
                        Ilość <strong class="text-primary">Punktów</strong>
                    </button>

                    <button type="button" class="btn btn-dark" id="coinsSelected">
                        Ilość <strong class="text-warning">Monet</strong>
                    </button>

                    <button type="button" class="btn btn-dark" id="easySelected">
                        Rekord na <strong class="text-success">Easy</strong>
                    </button>

                </div>

                <div class="btn-group w-100 d-flex d-sm-none" style="background-color: rgb(232, 226, 226);" role="group" aria-label="Ranking button group">

                    <button type="button" class="btn btn-dark" id="mediumSelected">
                        Rekord na <strong class="text-info">Medium</strong>
                    </button>

                    <button type="button" class="btn btn-dark" id="hardSelected">
                        Rekord na <strong class="text-danger">Hard</strong>
                    </button>

                    <button type="button" class="btn btn-dark" id="speedSelected">
                        Rekord na <strong class="text-purple">Speed</strong>
                    </button>

                </div>





                <div class="col-12
                            mx-auto text-center fs-6">

                            <div class="mt-3 table-responsive-sm">
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
                    url: "{{ route('ranking.get-points') }}",
                    type: "GET",
                    datatype: "json",
                    cache: true,
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
                                        <img alt="Awatar użytkownika"
                                             style="width: 25px; height: 25px; border-radius: 50%;"
                                             class="border border-1 border-secondary" src="`+row.avatar+`"></a>`;
                            } else if (meta.row == 1) {
                                return `<a class="link-silver" href="`+URL+`"><strong>`+row.name+`</strong>
                                        <img alt="Awatar użytkownika"
                                             style="width: 25px; height: 25px; border-radius: 50%;"
                                             class="border border-1 border-secondary" src="`+row.avatar+`"></a>`;
                            } else if (meta.row == 2) {
                                return `<a class="link-bronze" href="`+URL+`"><strong>`+row.name+`</strong>
                                        <img alt="Awatar użytkownika"
                                             style="width: 25px; height: 25px; border-radius: 50%;"
                                             class="border border-1 border-secondary" src="`+row.avatar+`"></a>`;
                            } else {
                                return `<a class="link-white" href="`+URL+`">`+row.name+`
                                <img alt="Awatar użytkownika"
                                     style="width: 25px; height: 25px; border-radius: 50%;"
                                     class="border border-1 border-secondary" src="`+row.avatar+`"></a>`;
                            }
                        },
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        class: 'align-middle',
                        orderable: false,
                        title: 'Ilość punktów',
                        data: function (row, type, val, meta) {
                            var data;
                            console.log(row);
                            if ($('#pointsRank').prop('checked')) {
                                data = row.points;
                            } else if ($('#coinsRank').prop('checked')) {
                                data = row.coins;
                            } else if ($('#easyRank').prop('checked')) {
                                data = row.easy_record;
                            } else if ($('#mediumRank').prop('checked')) {
                                data = row.medium_record;
                            } else if ($('#hardRank').prop('checked')) {
                                data = row.hard_record;
                            } else if ($('#speedRank').prop('checked')) {
                                data = row.speed_record;
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
                        },
                    },
                    @if (Auth::check() && Auth::user()->isAdmin())
                        {
                            title: '<span class="text-danger">ADMIN</span>',
                            class: 'align-middle',
                            orderable: false,
                            data: function (row, type, val, meta) {
                                text = ``;
                                if (row.permission != 2) {
                                    urlDeleteUserToReplace = "{{ route('admin.delete-account', '__ID__') }}";
                                    urlDeleteUser = urlDeleteUserToReplace.replace('__ID__', row.id);

                                    urlBanIpToReplace = "{{ route('admin.ban-last-ip', '__ID__') }}";
                                    urlBanIp = urlBanIpToReplace.replace('__ID__', row.uid);

                                    urlBanAccountToReplace = "{{ route('admin.ban-account', '__ID__') }}";
                                    urlBanAccount = urlBanAccountToReplace.replace('__ID__', row.id);

                                    urlBanIpAndAccountToReplace = "{{ route('admin.ban-ip-account', '__ID__') }}";
                                    urlBanIpAndAccount = urlBanIpAndAccountToReplace.replace('__ID__', row.id);

                                    text += `

                                            <form method="POST" action="`+urlBanIp+`">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-md btn-warning">Zbanuj IP</button>
                                            </form>

                                            <form method="POST" action="`+urlBanAccount+`" class="mt-1">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-md btn-danger">Zbanuj konto</button>
                                            </form>

                                            <form method="POST" action="`+urlBanIpAndAccount+`" class="mt-1">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-md btn-warning">Zbanuj konto oraz IP</button>
                                            </form>

                                            <form method="POST" action="`+urlDeleteUser+`" class="mt-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-md btn-danger">Usuń konto</button>
                                            </form>
                                        `;
                                }


                                urlResetTokenToReplace = "{{ route('admin.reset-api-token', '__ID__') }}";
                                urlResetToken = urlResetTokenToReplace.replace('__ID__', row.id);
                                text += `
                                            <form action="`+urlResetToken+`" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary mb-1 mt-1">Zresetuj token</button>
                                            </form>
                                        `;
                                return text;


                            },
                        },
                    @endif
                ]
            });


            $('#pointsRank').on('click', function() {
                blockUI();
                setTimeout(function()  {
                    $(rankingTable.column(2).header()).text('Ilość Punktów');
                    rankingTable.ajax.url("{{ route('ranking.get-points') }}").load();
                }, 400);
            });
            $('#coinsRank').on('click', function() {
                blockUI();
                setTimeout(function()  {
                    $(rankingTable.column(2).header()).text('Ilość Monet');
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
            $('#speedRank').on('click', function() {
                blockUI();
                setTimeout(function()  {
                    $(rankingTable.column(2).header()).text('Rekord na Speed');
                    rankingTable.ajax.url("{{ route('ranking.get-speed') }}").load();
                }, 400);
            });


            // clicks on small devices
            $('#pointsSelected').on('click', function() {
                $('#pointsRank').prop('checked');
                $('#pointsRank').click();
            });

            $('#coinsSelected').on('click', function() {
                $('#coinsRank').prop('checked');
                $('#coinsRank').click();
            });

            $('#easySelected').on('click', function() {
                $('#easyRank').prop('checked');
                $('#easyRank').click();
            });

            $('#mediumSelected').on('click', function() {
                $('#mediumRank').prop('checked');
                $('#mediumRank').click();
            });

            $('#hardSelected').on('click', function() {
                $('#hardRank').prop('checked');
                $('#hardRank').click();
            });

            $('#speedSelected').on('click', function() {
                $('#speedRank').prop('checked');
                $('#speedRank').click();
            });

        });




    </script>

@endsection
