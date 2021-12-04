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
                    <h5 class="modal-title" id="messageModalLabel">
                        <div id="message-sender"></div>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id="message-content"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        function changeModalMessage(sender, content) {
            $('#message-sender').text('Wiadomość od: '+sender);
            $('#message-content').text(content);
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
                        title: 'Akcje',
                        data: '',
                        render: function (data, type, row, meta) {
                            return `
                                        <button onclick="changeModalMessage('`+row.sender+`','`+row.content+`')"
                                                type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#messageModal">
                                            <i class="bi bi-envelope-open"></i>
                                        </button>
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
