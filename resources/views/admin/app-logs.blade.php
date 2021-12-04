@extends('layouts.layout')

@section('title')
    Logi aplikacji
@endsection

@push('js.header')
    <!-- DataTables JS -->
    <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
@endpush

@push('css')
    <!-- DataTables CSS -->
    <link href="{{ asset('assets/plugins/DataTables/datatables.min.css') }}" rel="stylesheet" text="text/css">
@endpush


@section('content')

    <style>
        .dataTables_filter {
            padding-bottom: 1vh;
            padding-top: 0.5vh;
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

                <div class="col-12 text-center mb-2 fs-2">
                    <strong>Logi aplikacji</strong>
                </div>

                <div class="col-12
                            mx-auto text-center fs-6">

                            <div class="mt-3
                                        table-responsive-xl">
                                <table id="LogsTable" class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th class=""></th>
                                            <th class="filterhead"></th>
                                            <th class="filterhead"></th>
                                            <th class=""></th>
                                            <th class=""></th>
                                            <th class=""></th>
                                        </tr>
                                        <tr>
                                            <th>Numer</th>
                                            <th>Typ</th>
                                            <th>Nazwa użytkownika</th>
                                            <th>Zawartość loga</th>
                                            <th>IP</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                </div>

    </div>


    <script>

        $(document).ready(function() {
            // Datatables
            var logsTable = $('#LogsTable').DataTable({
                oLanguage: {
                    sUrl: "{{ asset('assets/plugins/DataTables/pl.json') }}"
                },
                order: [[ 0, 'asc' ]],
                serverSide: false,
                ajax: {
                    url: "{{ route('admin.app-logs.get-app-logs') }}",
                    type: "GET",
                    datatype: "json",
                    contentType: "application/json",
                },
                columns: [
                    {
                        title: 'Numer',
                        data: '',
                        render: function (data, type, row, meta) {
                            let number = meta.row + meta.settings._iDisplayStart + 1;
                            return `<span class="color-white">`+number+`</span>`;
                        },
                        class: 'align-middle',
                    },
                    {
                        title: 'Nazwa użytkownika',
                        data: 'user.name',
                        class: 'align-middle',
                        orderable: false
                    },
                    {
                        title: 'Typ',
                        data: 'type',
                        render: function (data, type, row, meta) {
                            let action = row.type;

                            // user site actions
                            if (action == 'account_delete') {
                                return "Usunięcie konta";
                            } else if (action == 'avatar_change') {
                                return "Zmiana awatara";
                            } else if (action == 'avatar_delete') {
                                return "Usunięcie awatara";
                            } else if (action == 'game_total_logout') {
                                return "Wylogowanie z gry przez stronę";
                            } else if (action == 'site_login') {
                                return "Zalogowanie na stronę";
                            } else if (action == 'site_logout') {
                                return "Wylogowanie ze strony";
                            } else if (action == 'site_register') {
                                return "Zarejestrowanie konta";
                            } else if (action == 'change_password') {
                                return "Zmiana hasła";
                            } else if (action == 'change_email') {
                                return "Zmiana e-mail";
                            }

                            //game actions
                            else if (action == 'game_open') {
                                return "Wejście do gry";
                            } else if (action == 'game_leave') {
                                return "Wyjście z gry";
                            } else if (action == 'game_logout') {
                                return "Wylogowanie z gry";
                            }

                            // admin
                            else if (action == 'ip_user_ban') {
                                return "Zbanowanie IP użytkownika";
                            } else if (action == 'ip_user_unban') {
                                return "Odbanowanie IP użytkownika";
                            } else if (action == 'account_ban') {
                                return "Zbanowanie konta";
                            } else if (action == 'account_unban') {
                                return "Odbanowanie konta";
                            } else if (action == 'token_reset') {
                                return "Zresetowanie api tokenu"
                            } else if (action == 'ip_ban') {
                                return "Zbanowanie IP";
                            } else if (action == 'ip_unban') {
                                return "Odbanowanie IP";
                            }
                            else {
                                return "Coś nie pasuje";
                            }
                        },
                        class: 'align-middle',
                        orderable: false
                    },
                    {
                        title: 'Zawartość loga',
                        data: 'content',
                        class: 'align-middle',
                        orderable: false
                    },
                    {
                        title: 'IP',
                        data: 'ip',
                        class: 'align-middle',
                        orderable: false
                    },
                    {
                        title: 'Data',
                        data: '',
                        render: function (data, type, row, meta) {
                            let hours = row.created_at.slice(0, 10);
                            let minutes = row.created_at.slice(11, 19);
                            return hours + " " + minutes;
                        },
                        class: 'align-middle'
                    }
                ],
                initComplete: function () {
                    var api = this.api();
                    $('.filterhead', api.table().header()).each(function (i) {
                        var column = api.column(i+1);
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(this).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column.search(val ? '^'+val+'$' : '', true, false).draw();
                            });

                        column.data().unique().sort().each(function (value) {
                            let optionName = "";

                            // user site actions
                            if (value == 'account_delete') {
                                optionName = "Usunięcie konta";
                            } else if (value == 'avatar_change') {
                                optionName = "Zmiana awatara";
                            } else if (value == 'avatar_delete') {
                                optionName = "Usunięcie awatara";
                            } else if (value == 'game_total_logout') {
                                optionName = "Wylogowanie z gry przez stronę";
                            } else if (value == 'site_login') {
                                optionName = "Zalogowanie na stronę";
                            } else if (value == 'site_logout') {
                                optionName = "Wylogowanie ze strony";
                            } else if (value == 'site_register') {
                                optionName = "Zarejestrowanie konta";
                            } else if (value == 'change_password') {
                                optionName = "Zmiana hasła";
                            } else if (value == 'change_email') {
                                optionName = "Zmiana e-mail";
                            }

                            //game actions
                            else if (value == 'game_open') {
                                optionName = "Wejście do gry";
                            } else if (value == 'game_leave') {
                                optionName = "Wyjście z gry";
                            } else if (value == 'game_logout') {
                                optionName = "Wylogowanie z gry";
                            }

                            // admin
                            else if (value == 'ip_user_ban') {
                                optionName = "Zbanowanie IP użytkownika";
                            } else if (value == 'ip_user_unban') {
                                optionName = "Odbanowanie IP użytkownika";
                            } else if (value == 'account_ban') {
                                optionName = "Zbanowanie konta";
                            } else if (value == 'account_unban') {
                                optionName = "Odbanowanie konta";
                            } else if (value == 'token_reset') {
                                optionName = "Zresetowanie api tokenu"
                            } else if (value == 'ip_ban') {
                                optionName = "Zbanowanie IP";
                            } else if (value == 'ip_unban') {
                                optionName = "Odbanowanie IP";
                            }
                            else {
                                optionName = value;
                            }
                            select.append( '<option value="'+optionName+'">'+optionName+'</option>' );
                        });
                    });
                }
            });
        });

    </script>

@endsection
