@extends('layouts.layout')

@section('title')
    Użytkownicy
@endsection

@push('js.header')
    <!-- DataTables JS -->
    <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
    <!-- END DataTables JS -->
@endpush

@push('css')
    <!-- DataTables CSS -->
    <link href="{{ asset('assets/plugins/DataTables/datatables.min.css') }}" rel="stylesheet" text="text/css">
    <!-- END DataTables CSS -->
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
                    <strong>Użytkownicy</strong>
                </div>

                <div class="btn-group w-100" style="background-color: rgb(232, 226, 226);" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="usersRadio" id="allUsers" autocomplete="off" checked>
                    <label class="btn btn-outline-dark" for="allUsers">
                        <strong class="text-danger">Wszyscy</strong>
                    </label>

                    <input type="radio" class="btn-check" name="usersRadio" id="bannedUsers" autocomplete="off">
                    <label class="btn btn-outline-dark" for="bannedUsers">
                        <strong class="text-danger">Tylko zbanowani</strong>
                    </label>

                    <input type="radio" class="btn-check" name="usersRadio" id="notbannedUsers" autocomplete="off">
                    <label class="btn btn-outline-dark" for="notbannedUsers">
                        <strong class="text-danger">Tylko niezbanowani</strong>
                    </label>
                </div>

                <div class="col-12
                            mx-auto text-center fs-6">

                            <div class="mt-3
                                        table-responsive-sm
                                        table-responsive-md">
                                <table id="UsersTable" class="table table-dark table-hover">
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
            // Datatables
            var usersTable = $('#UsersTable').DataTable({
                oLanguage: {
                    sUrl: "{{ asset('assets/plugins/DataTables/pl.json') }}"
                },
                order: [[ 0, 'asc' ]],
                serverSide: false,
                ajax: {
                    url: "{{ route('admin.users.get-all-users') }}",
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
                        title: 'Nazwa',
                        data: 'name',
                        render: function (data, type, row, meta) {
                            urlProfileToReplace = "{{ route('profile', '__NAME__') }}";
                            urlProfile = urlProfileToReplace.replace('__NAME__', row.name);
                            if (row.permission == 0) {
                                return `<a class="link-white" href="`+urlProfile+`">`+row.name+`</a>`;
                            } else if (row.permission == 2) {
                                return `<strong class="text-danger"><a class="link-red" href="`+urlProfile+`">`+row.name+`</a></strong>`;
                            }
                        },
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        title: 'IP',
                        data: 'last_login_ip',
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        title: 'Ostatnie logowanie',
                        data: 'last_login_time',
                        class: 'align-middle',
                    },
                    {
                        title: 'Ban konta',
                        data: 'user_banned',
                        render: function (data, type, row, meta) {
                            if (data == 0) {
                                return '<i class="bi bi-check-lg text-success"></i>';
                            } else if (data == 1) {
                                return '<i class="bi bi-exclamation-circle text-danger"></i>';
                            } else {
                                return '<i class="bi bi-question-circle"></i>';
                            }
                        },
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        title: 'Ban IP',
                        data: '',
                        render: function (data, type, row, meta) {
                            if (row.visitor_unique != null) {
                                if (row.visitor_unique.ip_banned == 0) {
                                    return '<i class="bi bi-check-lg text-success"></i>';
                                } else {
                                    return '<i class="bi bi-exclamation-circle text-danger"></i>';
                                }
                            } else {
                                return '<i class="bi bi-question-circle"></i>';
                            }

                        },
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        title: 'Akcje',
                        data: '',
                        orderable: false,
                        render: function (data, type, row, meta) {
                            text = ``;

                            // USER
                            if (row.permission == 0) {
                                // if user's account IS BANNED
                                if (row.user_banned) {
                                urlUnbanAccountToReplace = "{{ route('admin.unban-account', '__ID__') }}";
                                urlUnbanAccount = urlUnbanAccountToReplace.replace('__ID__', row.id);

                                text += `
                                            <form action="`+urlUnbanAccount+`" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success mb-1">Odbanuj konto</button>
                                            </form>
                                        `;
                                } else {
                                    // if user's account ISN'T BANNED
                                    urlBanAccountToReplace = "{{ route('admin.ban-account', '__ID__') }}";
                                    urlBanAccount = urlBanAccountToReplace.replace('__ID__', row.id);

                                    text += `
                                                <form action="`+urlBanAccount+`" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger mb-1">Zbanuj konto</button>
                                                </form>
                                            `;
                                }
                                // if user's last ip IS BANNED
                                if (row.visitor_unique != null && row.visitor_unique.ip_banned) {
                                    urlUnbanIpToReplace = "{{ route('admin.unban-last-ip', '__ID__') }}";
                                    urlUnbanIp = urlUnbanIpToReplace.replace('__ID__', row.id);

                                    text += `
                                                <form action="`+urlUnbanIp+`" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success mb-1">Odbanuj IP</button>
                                                </form>
                                            `;
                                } else {
                                    // if user's last ip ISN'T BANNED
                                    urlBanIpToReplace = "{{ route('admin.ban-last-ip', '__ID__') }}";
                                    urlBanIp = urlBanIpToReplace.replace('__ID__', row.id);

                                    text += `
                                                <form action="`+urlBanIp+`" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-warning mb-1">Zbanuj IP</button>
                                                </form>
                                            `;
                                }

                                // if user's last ip and account IS BANNED
                                if (row.visitor_unique != null && row.visitor_unique.ip_banned && row.user_banned) {
                                    urlUnbanIpAndAccountToReplace = "{{ route('admin.unban-ip-account', '__ID__') }}";
                                    urlUnbanIpAndAccount = urlUnbanIpAndAccountToReplace.replace('__ID__', row.id);

                                    text += `
                                                <form action="`+urlUnbanIpAndAccount+`" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success mb-1">Odbanuj IP oraz Konto</button>
                                                </form>
                                            `;
                                } else {
                                    // if user's last ip OR account ISN'T BANNED
                                    urlBanIpAndAccountToReplace = "{{ route('admin.ban-ip-account', '__ID__') }}";
                                    urlBanIpAndAccount = urlBanIpAndAccountToReplace.replace('__ID__', row.id);

                                    text += `
                                                <form action="`+urlBanIpAndAccount+`" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger mb-1">Zbanuj IP oraz Konto</button>
                                                </form>
                                            `;
                                }

                                urlDeleteAccountToReplace = "{{ route('admin.delete-account', '__ID__') }}";
                                urlDeleteAccount = urlDeleteAccountToReplace.replace('__ID__', row.id);

                                text += `
                                            <form action="`+urlDeleteAccount+`" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning mb-1">Usuń konto</button>
                                            </form>
                                        `;
                            } else if (row.permission == 2) {
                                // ADMIN
                                text += ''
                            }

                            urlResetTokenToReplace = "{{ route('admin.reset-api-token', '__ID__') }}";
                            urlResetToken = urlResetTokenToReplace.replace('__ID__', row.id);
                            text += `
                                        <form action="`+urlResetToken+`" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary mb-1">Zresetuj token</button>
                                        </form>
                                    `;

                            return text;
                        },
                    },
                ]
            });

            $('#allUsers').on('click', function() {
                usersTable.ajax.url("{{ route('admin.users.get-all-users') }}").load();
            });
            $('#bannedUsers').on('click', function() {
                usersTable.ajax.url("{{ route('admin.users.get-banned-users') }}").load();
            });
            $('#notbannedUsers').on('click', function() {
                usersTable.ajax.url("{{ route('admin.users.get-notbanned-users') }}").load();
            });
        });





    </script>

@endsection
