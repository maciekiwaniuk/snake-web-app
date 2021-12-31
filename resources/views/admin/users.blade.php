@extends('layouts.layout')

@section('title')
    Użytkownicy
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

        .front-modal {
            z-index: 9999;
        }

        #user-name, .user-name-text{
            font-weight: 700;
        }
    </style>

    <div class="col-12
                mx-auto
                mx-5
                mt-2 mt-sm-4
                mb-3 fs-3
                px-3 py-3
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

    <!-- User action confirmation modal -->
    <div class="modal fade front-modal" id="userActionConfirmationModal" tabindex="-1" aria-labelledby="userActionConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <div id="confirmation-content">

                        <div id="ip-ban-status-content">
                            <div class="d-inline" id="ip-ban-status-text"></div>
                            <div class="d-inline user-name-text"></div>
                        </div>

                        <div id="account-ban-status-content">
                            <div class="d-inline" id="account-ban-status-text"></div>
                            <div class="d-inline user-name-text"></div>
                        </div>

                        <div id="account-ip-ban-status-content">
                            <div class="d-inline" id="account-ip-ban-status-text"></div>
                            <div class="d-inline user-name-text"></div>
                        </div>

                        <div id="account-delete-content">
                            <div class="d-inline" id="account-delete-text"></div>
                            <div class="d-inline user-name-text"></div>
                        </div>

                        <div id="token-reset-content">
                            <div class="d-inline" id="token-reset-text"></div>
                            <div class="d-inline user-name-text"></div>
                        </div>

                        <div id="avatar-delete-content">
                            <div class="d-inline" id="avatar-delete-text"></div>
                            <div class="d-inline user-name-text"></div>
                        </div>

                        <div id="user-data-modify-content">
                            <div class="d-inline" id="user-data-modify-text"></div>
                            <div class="d-inline user-name-text"></div>

                            <div class="text-start mt-3">
                                <label>Nowa nazwa</label> <br>
                                <input type="text" id="user-name-input" disabled class="form-control w-75 d-inline">
                                <input type="checkbox" id="name-enable-checkbox" class="d-inline ms-5 checkbox-big">

                                <label class="mt-2">Nowy e-mail</label> <br>
                                <input type="text" id="user-email-input" disabled class="form-control w-75 d-inline">
                                <input type="checkbox" id="email-enable-checkbox" class="d-inline ms-5 checkbox-big">

                                <label class="mt-2">Nowe hasło</label> <br>
                                <input type="text" id="user-password-input" disabled class="form-control w-75 d-inline">
                                <input type="checkbox" id="password-enable-checkbox" class="d-inline ms-5 checkbox-big">
                            </div>

                        </div>

                    </div>
                </div>


                <div class="modal-footer d-flex justify-content-around">
                    <form method="POST" id="ip-ban-status-confirmation-form">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning border border-2 border-dark">Potwierdź</button>
                    </form>

                    <form method="POST" id="account-ban-status-confirmation-form">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger border border-2 border-dark">Potwierdź</button>
                    </form>

                    <form method="POST" id="account-ip-ban-status-confirmation-form">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning border border-2 border-dark">Potwierdź</button>
                    </form>

                    <form method="POST" id="account-delete-confirmation-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger border border-2 border-dark">Potwierdź</button>
                    </form>

                    <form method="POST" id="token-reset-confirmation-form">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary border border-2 border-dark">Potwierdź</button>
                    </form>

                    <form method="POST" id="avatar-delete-confirmation-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-success border border-2 border-dark">Potwierdź</button>
                    </form>

                    <form method="POST" id="user-data-modify-confirmation-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" id="user-name-hidden">
                        <input type="hidden" name="email" id="user-email-hidden">
                        <input type="hidden" name="password" id="user-password-hidden">

                        <button id="modify-data-submit" class="btn btn-primary border border-2 border-dark">Potwierdź</button>
                    </form>

                    <button type="button" class="btn btn-secondary border border-2 border-dark" data-bs-dismiss="modal">Anuluj</button>
                </div>
            </div>
        </div>
    </div>

    <!-- User action modal -->
    <div class="modal fade" id="userActionModal" tabindex="-1" aria-labelledby="userActionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="user-action-info" class="text-center fs-4 mb-2">
                        Użytkownik <div class="d-inline" id="user-name"></div>
                    </div>

                    <div id="user-action-content" class="text-center">
                        <button type="button" onclick="openStatusBanIpModal();" id="ip-ban-status-btn" data-bs-toggle="modal" data-bs-target="#userActionConfirmationModal">
                        </button> <br>

                        <button type="button" onclick="openStatusBanAccountModal();" id="account-ban-status-btn" data-bs-toggle="modal" data-bs-target="#userActionConfirmationModal">
                        </button> <br>

                        <button type="button" onclick="openStatusBanAccountAndIpModal();" id="account-ip-ban-status-btn" data-bs-toggle="modal" data-bs-target="#userActionConfirmationModal">
                        </button> <br>

                        <button type="button" onclick="openAccountDeleteModal();" class="btn btn-danger mt-1 border border-2 border-dark" data-bs-toggle="modal" data-bs-target="#userActionConfirmationModal">
                            Usuń konto
                        </button> <br>

                        <button type="button" onclick="openTokenResetModal();" class="btn btn-primary mt-1 border border-2 border-dark" data-bs-toggle="modal" data-bs-target="#userActionConfirmationModal">
                            Zresetuj token
                        </button> <br>

                        <button type="button" onclick="openAvatarDeleteModal();" class="btn btn-success mt-1 border border-2 border-dark" data-bs-toggle="modal" data-bs-target="#userActionConfirmationModal">
                            Usuń awatar
                        </button> <br>

                        <button type="button" onclick="openModifyUserData();" class="btn btn-primary mt-1 border border-2 border-dark" data-bs-toggle="modal" data-bs-target="#userActionConfirmationModal">
                            Zmodyfikuj dane
                        </button>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-around">
                    <button type="button" class="btn btn-secondary border border-2 border-dark" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        function hideModalContents() {
            $('#account-ban-status-content').hide();
            $('#ip-ban-status-content').hide();
            $('#account-ip-ban-status-content').hide();
            $('#account-delete-content').hide();
            $('#token-reset-content').hide();
            $('#avatar-delete-content').hide();
            $('#user-data-modify-content').hide();
        }

        function hideModalForms() {
            $('#ip-ban-status-confirmation-form').hide();
            $('#account-ban-status-confirmation-form').hide();
            $('#account-ip-ban-status-confirmation-form').hide();
            $('#account-delete-confirmation-form').hide();
            $('#token-reset-confirmation-form').hide();
            $('#avatar-delete-confirmation-form').hide();
            $('#user-data-modify-confirmation-form').hide();
        }

        function openStatusBanIpModal() {
            hideModalForms();
            hideModalContents();
            $('#ip-ban-status-content').show();
            $('#ip-ban-status-confirmation-form').show();
        }

        function openStatusBanAccountModal() {
            hideModalForms();
            hideModalContents();
            $('#account-ban-status-content').show();
            $('#account-ban-status-confirmation-form').show();
        }

        function openStatusBanAccountAndIpModal() {
            hideModalForms();
            hideModalContents();
            $('#account-ip-ban-status-content').show();
            $('#account-ip-ban-status-confirmation-form').show();
        }

        function openAccountDeleteModal() {
            hideModalForms();
            hideModalContents();
            $('#account-delete-content').show();
            $('#account-delete-confirmation-form').show();
        }

        function openTokenResetModal() {
            hideModalForms();
            hideModalContents();
            $('#token-reset-content').show();
            $('#token-reset-confirmation-form').show();
        }

        function openAvatarDeleteModal() {
            hideModalForms();
            hideModalContents();
            $('#avatar-delete-content').show();
            $('#avatar-delete-confirmation-form').show();
        }

        function openModifyUserData() {
            hideModalForms();
            hideModalContents();
            $('#user-data-modify-content').show();
            $('#user-data-modify-confirmation-form').show();
        }

        function changeModalsContent(user_id, name, email, permission, user_banned, ip_id, ip, ip_banned) {
            $('#user-name').text(name);
            $('.user-name-text').text(name);

            // IP ban status
            if (ip_banned == 1) {
                $('#ip-ban-status-text').text('Potwierdź odbanowanie IP użytkownika');
                $('#ip-ban-status-btn').text('Odbanuj IP');
                $('#ip-ban-status-btn').attr('class', 'btn btn-success border border-2 border-dark');

                urlUnbanIpToReplace = "{{ route('admin.unban-last-ip', '__ID__') }}";
                urlUnbanIp = urlUnbanIpToReplace.replace('__ID__', user_id);
                $('#ip-ban-status-confirmation-form').attr('action', urlUnbanIp);
            } else {
                $('#ip-ban-status-text').text('Potwierdź zbanowanie IP użytkownika');
                $('#ip-ban-status-btn').text('Zbanuj IP');
                $('#ip-ban-status-btn').attr('class', 'btn btn-warning border border-2 border-dark');

                urlBanIpToReplace = "{{ route('admin.ban-last-ip', '__ID__') }}";
                urlBanIp = urlBanIpToReplace.replace('__ID__', user_id);
                $('#ip-ban-status-confirmation-form').attr('action', urlBanIp);
            }

            // Account ban status
            if (user_banned == 1) {
                $('#account-ban-status-text').text('Potwierdź odbanowanie konta użytkownika');
                $('#account-ban-status-btn').text('Odbanuj konto');
                $('#account-ban-status-btn').attr('class', 'btn btn-success mt-1 border border-2 border-dark')

                urlUnbanAccountToReplace = "{{ route('admin.unban-account', '__ID__') }}";
                urlUnbanAccount = urlUnbanAccountToReplace.replace('__ID__', user_id);
                $('#account-ban-status-confirmation-form').attr('action', urlUnbanAccount);
            } else {
                $('#account-ban-status-text').text('Potwierdź zbanowanie konta użytkownika');
                $('#account-ban-status-btn').text('Zbanuj konto');
                $('#account-ban-status-btn').attr('class', 'btn btn-danger mt-1 border border-2 border-dark')

                urlBanAccountToReplace = "{{ route('admin.ban-account', '__ID__') }}";
                urlBanAccount = urlBanAccountToReplace.replace('__ID__', user_id);
                $('#account-ban-status-confirmation-form').attr('action', urlBanAccount);
            }

            // Account and IP ban status
            if (user_banned == 0 || ip_banned == 0) {
                $('#account-ip-ban-status-text').text('Potwierdź zbanowanie konta oraz IP użytkownika');
                $('#account-ip-ban-status-btn').text('Zbanuj konto oraz IP');
                $('#account-ip-ban-status-btn').attr('class', 'btn btn-warning mt-1 border border-2 border-dark');

                urlBanIpAndAccountToReplace = "{{ route('admin.ban-ip-account', '__ID__') }}";
                urlBanIpAndAccount = urlBanIpAndAccountToReplace.replace('__ID__', user_id);
                $('#account-ip-ban-status-confirmation-form').attr('action', urlBanIpAndAccount);
            } else {
                $('#account-ip-ban-status-text').text('Potwierdź odbanowanie konta oraz IP użytkownika');
                $('#account-ip-ban-status-btn').text('Odbanuj konto oraz IP');
                $('#account-ip-ban-status-btn').attr('class', 'btn btn-success mt-1 border border-2 border-dark');

                urlUnbanIpAndAccountToReplace = "{{ route('admin.unban-ip-account', '__ID__') }}";
                urlUnbanIpAndAccount = urlUnbanIpAndAccountToReplace.replace('__ID__', user_id);
                $('#account-ip-ban-status-confirmation-form').attr('action', urlUnbanIpAndAccount);
            }

            // Delete account
            urlDeleteAccountToReplace = "{{ route('admin.delete-account', '__ID__') }}";
            urlDeleteAccount = urlDeleteAccountToReplace.replace('__ID__', user_id);
            $('#account-delete-confirmation-form').attr('action', urlDeleteAccount);
            $('#account-delete-text').text('Potwierdź usunięcie konta użytkownika');

            // Reset token
            urlResetTokenToReplace = "{{ route('admin.reset-api-token', '__ID__') }}";
            urlResetToken = urlResetTokenToReplace.replace('__ID__', user_id);
            $('#token-reset-confirmation-form').attr('action', urlResetToken);
            $('#token-reset-text').text('Potwierdź zresetowanie tokenu użytkownika');

            // Delete avatar
            urlDeleteAvatarToReplace = "{{ route('admin.delete-avatar', '__ID__') }}";
            urlDeleteAvatar = urlDeleteAvatarToReplace.replace('__ID__', user_id);
            $('#avatar-delete-confirmation-form').attr('action', urlDeleteAvatar);
            $('#avatar-delete-text').text('Potwierdź usunięcie awatara dla użytkownika');

            // Modify user data
            urlModifyUserDataToReplace = "{{ route('admin.modify-data', '__ID__') }}";
            urlModifyUserData = urlModifyUserDataToReplace.replace('__ID__', user_id);
            $('#user-data-modify-confirmation-form').attr('action', urlModifyUserData);
            $('#user-data-modify-text').text('Modyfikacja danych dla użytkownika');
        }

        $(document).ready(function() {
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

                @if (isset($search_bar_value))
                    search: {
                        search: '{{ $search_bar_value }}'
                    },
                @endif

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
                            if (row.permission == 2) {
                                return '<i class="bi bi-shield-lock text-danger"></i>';
                            }

                            if (row.visitor_unique != null) {
                                return `
                                        <button onclick="changeModalsContent(
                                                '`+row.id+`',
                                                '`+row.name+`',
                                                '`+row.email+`',
                                                '`+row.permission+`',
                                                '`+row.user_banned+`',
                                                '`+row.visitor_unique.id+`',
                                                '`+row.visitor_unique.ip+`',
                                                '`+row.visitor_unique.ip_banned+`'
                                            );"
                                                type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#userActionModal">
                                            <i class="bi bi-gear"></i>
                                        </button>
                                    `;
                            } else {
                                // visitor unique relation might be null for a few persons only when database is filled using db:seed
                                return '<i class="bi bi-question-circle"></i>';
                            }

                        }
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

            $('#name-enable-checkbox').on('click', function() {
                if ($('#user-name-input').prop('disabled')) {
                    $('#user-name-input').prop('disabled', false);
                } else {
                    $('#user-name-input').prop('disabled', true);
                }
            });

            $('#email-enable-checkbox').on('click', function() {
                if ($('#user-email-input').prop('disabled')) {
                    $('#user-email-input').prop('disabled', false);
                } else {
                    $('#user-email-input').prop('disabled', true);
                }
            });

            $('#password-enable-checkbox').on('click', function() {
                if ($('#user-password-input').prop('disabled')) {
                    $('#user-password-input').prop('disabled', false);
                } else {
                    $('#user-password-input').prop('disabled', true);
                }
            });

            $('#modify-data-submit').on('click', function() {
                if ($('#name-enable-checkbox').prop('checked')) {
                    $('#user-name-hidden').val($('#user-name-input').val());
                }
                if ($('#email-enable-checkbox').prop('checked')) {
                    $('#user-email-hidden').val($('#user-email-input').val());
                }
                if ($('#password-enable-checkbox').prop('checked')) {
                    $('#user-password-hidden').val($('#user-password-input').val());
                }


                if ($('#name-enable-checkbox').prop('checked') || $('#email-enable-checkbox').prop('checked') || $('#password-enable-checkbox').prop('checked')) {
                    $('#user-data-modify-confirmation-form').submit()
                }

            });
        });





    </script>

@endsection
