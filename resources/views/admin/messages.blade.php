@extends('layouts.layout')

@section('title')
    Wiadomości
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
                px-1 px-sm-4 py-3
                border border-2 border-success
                bg-gradient-to-left border-radius-15">

                <div class="col-12 text-center mb-2 fs-2">
                    <strong>Wiadomości</strong>
                </div>

                <div class="col-12
                            mx-auto text-center fs-6">

                            <div class="mt-3
                                        table-responsive
                                        table-responsive-sm
                                        table-responsive-md">
                                <table id="MessagesTable" class="table table-dark table-hover">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                </div>


    </div>

    <!-- Message modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <form class="row g-3">
                        <div class="col-12">
                            <label for="message-date">Data wysłania</label>
                            <input type="text" id="message-date" name="message-date" class="form-control" disabled>
                        </div>

                        <div class="col-12">
                            <label for="subject">Temat</label>
                            <select name="subject" class="form-control" disabled>
                                <option id="message-subject"></option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="sender">Od kogo</label>
                            <input type="text" id="message-sender" name="sender" class="form-control" disabled required>
                        </div>

                        <div class="col-12">
                            <label for="email">E-mail</label>
                            <input type="text" id="message-email" name="email" class="form-control" disabled required>
                        </div>

                        <div class="col-12">
                            <label for="content">Treść wiadomości</label>
                            <textarea name="content" id="message-content" class="form-control" rows="5" disabled required></textarea>
                        </div>

                        <div class="col-12" id="message-user_name-div">
                            <label for="user_name">Nazwa konta użytkownika nadawcy</label>
                            <input type="text" id="message-user_name" name="user_name" class="form-control" disabled required>
                        </div>
                    </form>

                </div>

                <div class="modal-footer d-flex justify-content-around">
                    <form method="POST" id="message-delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Usuń</button>
                    </form>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        function changeModalMessageContent(message_id, date, subject, sender, email, content, sent_as_user, user_name) {
            $('#message-date').val(date.slice(0, 10));

            if (subject == 'contact') {
                $('#message-subject').text('Kontakt');
            } else if (subject == 'error-website') {
                $('#message-subject').text('Błąd na stronie');
            } else if (subject == 'error-game') {
                $('#message-subject').text('Błąd w grze');
            } else if (subject == 'idea-website') {
                $('#message-subject').text('Pomysł dotyczący strony');
            } else if (subject == 'idea-game') {
                $('#message-subject').text('Pomysł dotyczący gry');
            } else {
                $('#message-subject').text('Inny');
            }

            $('#message-sender').val(sender);
            $('#message-email').val(email);
            $('#message-content').text(content);

            if (sent_as_user == 1) {
                $('#message-user_name-div').show();
                $('#message-user_name').val(user_name);
            } else {
                $('#message-user_name-div').hide();
            }

            urlDeleteMessageToReplace = "{{ route('admin.messages.destroy', '__ID__') }}";
            urlDeleteMessage = urlDeleteMessageToReplace.replace('__ID__', message_id);
            $('#message-delete-form').attr('action', urlDeleteMessage);
        }

        $(document).ready(function() {
            // Datatables
            var MessagesTable = $('#MessagesTable').DataTable({
                oLanguage: {
                    sUrl: "{{ asset('assets/plugins/DataTables/pl.json') }}"
                },
                order: [[ 0, 'asc' ]],
                serverSide: false,
                ajax: {
                    url: "{{ route('admin.messages.get-messages') }}",
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
                        class: 'align-middle'
                    },
                    {
                        title: 'Temat',
                        data: '',
                        render: function (data, type, row, meta) {
                            var subject = '';
                            if (row.subject == 'contact') {
                                subject = 'Kontakt';
                            } else if (row.subject == 'error-website') {
                                subject = 'Błąd na stronie';
                            } else if (row.subject == 'error-game') {
                                subject = 'Błąd w grze';
                            } else if (row.subject == 'idea-website') {
                                subject = 'Pomysł dotyczący strony';
                            } else if (row.subject == 'idea-game') {
                                subject = 'Pomysł dotyczący gry';
                            } else {
                                subject = 'Inny';
                            }
                            return subject;
                        },
                        class: 'align-middle',
                        orderable: false
                    },
                    {
                        title: 'Od kogo',
                        data: 'sender',
                        class: 'align-middle',
                        orderable: false
                    },
                    {
                        title: 'E-mail',
                        data: 'email',
                        class: 'align-middle',
                        orderable: false
                    },
                    {
                        title: 'Wysłany jako zalogowany',
                        data: '',
                        render: function (data, type, row, meta) {
                            if (row.sent_as_user) {
                                return '<i class="bi bi-check-lg text-success"></i>';
                            } else {
                                return '<i class="bi bi-exclamation-circle text-danger"></i>';
                            }
                        },
                        class: 'align-middle',
                        orderable: false
                    },
                    {
                        title: 'Nazwa zalogowanego',
                        data: '',
                        render: function (data, type, row, meta) {
                            if (row.user_name != null) {
                                return row.user_name;
                            } else {
                                return '<i class="bi bi-question-circle"></i>';
                            }
                        },
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
                    },
                    {
                        title: 'Akcje',
                        data: '',
                        render: function (data, type, row, meta) {
                            urlDeleteMessageToReplace = "{{ route('admin.messages.destroy', '__ID__') }}";
                            urlDeleteMessage = urlDeleteMessageToReplace.replace('__ID__', row.id);

                            return html = `
                                        <button onclick="changeModalMessageContent(
                                                '`+row.id+`',
                                                '`+row.created_at+`',
                                                '`+row.subject+`',
                                                '`+row.sender+`',
                                                '`+row.email+`',
                                                '`+row.content+`',
                                                '`+row.sent_as_user+`',
                                                '`+row.user_name+`'
                                            )"
                                                type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#messageModal">
                                            <i class="bi bi-envelope-open"></i>
                                        </button>

                                        <form method="POST" action="`+urlDeleteMessage+`">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mt-1">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    `;
                        },
                        class: 'align-middle',
                        orderable: false
                    }
                ],
            });
        });

    </script>

@endsection
