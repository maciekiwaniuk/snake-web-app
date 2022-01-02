@extends('layouts.layout')

@section('title')
    Odwiedzający
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
                    <strong>IP odwiedzających</strong>
                </div>

                <div class="btn-group w-100" style="background-color: rgb(232, 226, 226);" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="visitorsRadio" id="allVisitors" autocomplete="off" checked>
                    <label class="btn btn-outline-dark" for="allVisitors">
                        <strong class="text-danger">Wszystkie IP</strong>
                    </label>

                    <input type="radio" class="btn-check" name="visitorsRadio" id="bannedVisitors" autocomplete="off">
                    <label class="btn btn-outline-dark" for="bannedVisitors">
                        <strong class="text-danger">Tylko zbanowane</strong>
                    </label>

                    <input type="radio" class="btn-check" name="visitorsRadio" id="notbannedVisitors" autocomplete="off">
                    <label class="btn btn-outline-dark" for="notbannedVisitors">
                        <strong class="text-danger">Tylko niezbanowane</strong>
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
                                        table-responsive
                                        table-responsive-sm
                                        table-responsive-md">
                                <table id="VisitorsTable" class="table table-dark table-hover">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                </div>

    </div>

    <!-- Ban confirmation modal -->
    <div class="modal fade" id="banStatusConfirmationModal" tabindex="-1" aria-labelledby="banStatusConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <div id="confirmation-message"></div>
                </div>

                <div class="modal-footer d-flex justify-content-around">
                    <form method="POST" id="ban-status-ip-form">
                        @csrf
                        @method('PUT')
                        <button type="submit" id="ban-status-ip-button">Potwierdź</button>
                    </form>

                    <button type="button" class="btn btn-secondary border border-2 border-dark" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        function changeBanStatusConfirmationModalContent(ip_id, ip, ip_banned) {
            if (ip_banned == 1) {
                $('#confirmation-message').text('Potwierdź odbanowanie IP: '+ip);
                $('#ban-status-ip-button').attr('class', 'btn btn-success border border-2 border-dark');

                urlUnbanIpToReplace = "{{ route('admin.unban-ip', '__ID__') }}";
                urlUnbanIp = urlUnbanIpToReplace.replace('__ID__', ip_id);
                $('#ban-status-ip-form').attr('action', urlUnbanIp);

            } else if (ip_banned == 0) {
                $('#confirmation-message').text('Potwierdź zbanowanie IP: '+ip);
                $('#ban-status-ip-button').attr('class', 'btn btn-danger border border-2 border-dark');

                urlBanIpToReplace = "{{ route('admin.ban-ip', '__ID__') }}";
                urlBanIp = urlBanIpToReplace.replace('__ID__', ip_id);
                $('#ban-status-ip-form').attr('action', urlBanIp);
            }
        }

        $(document).ready(function() {
            var visitorsTable = $('#VisitorsTable').DataTable({
                oLanguage: {
                    sUrl: "{{ asset('assets/plugins/DataTables/pl.json') }}"
                },
                order: [[ 0, 'asc' ]],
                serverSide: false,
                ajax: {
                    url: "{{ route('admin.visitors.get-all-visitors') }}",
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
                        title: 'IP',
                        data: '',
                        render: function (data, type, row, meta) {
                            urlIpSearchToReplace = "{{ route('admin.users.show', '__IP__') }}";
                            urlIpSearch = urlIpSearchToReplace.replace('__IP__', row.ip);
                            return `
                                        <a href="`+urlIpSearch+`" class="link-white">
                                            `+row.ip+`
                                        </a>
                                    `;
                        },
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        title: 'User-Agent',
                        data: 'user_agent',
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        title: 'Pierwsza wizyta',
                        data: 'created_at',
                        render: function (data, type, row, meta) {
                            let days = row.created_at.slice(0, 10);
                            let hours = row.created_at.slice(11, 19);
                            return days + " " + hours;
                        },
                        class: 'align-middle',
                    },
                    {
                        title: 'Ban',
                        data: '',
                        render: function (data, type, row, meta) {
                            if (row.ip_banned == 0) {
                                return '<i class="bi bi-check-lg text-success"></i>'
                            } else {
                                return '<i class="bi bi-exclamation-circle text-danger"></i>'
                            }
                        },
                        class: 'align-middle',
                        orderable: false,
                    },
                    {
                        title: 'Akcje',
                        data: '',
                        render: function (data, type, row, meta) {
                            // ip IS BANNED
                            if (row.ip_banned) {
                                return `
                                            <button onclick="changeBanStatusConfirmationModalContent(
                                                    '`+row.id+`',
                                                    '`+row.ip+`',
                                                    '`+row.ip_banned+`'
                                                );"
                                                    type="button" class="btn btn-success border border-2 border-light" data-bs-toggle="modal" data-bs-target="#banStatusConfirmationModal">
                                                Odbanuj
                                            </button>
                                        `;
                            } else {
                                // ip ISN'T BANNED
                                return `
                                            <button onclick="changeBanStatusConfirmationModalContent(
                                                    '`+row.id+`',
                                                    '`+row.ip+`',
                                                    '`+row.ip_banned+`'
                                                );"
                                                    type="button" class="btn btn-danger border border-2 border-light" data-bs-toggle="modal" data-bs-target="#banStatusConfirmationModal">
                                                Zbanuj
                                            </button>
                                        `;
                            }
                        },
                        class: 'align-middle',
                        orderable: false,
                    },
                ]
            });

            $('#allVisitors').on('click', function() {
                visitorsTable.ajax.url("{{ route('admin.visitors.get-all-visitors') }}").load();
            });
            $('#bannedVisitors').on('click', function() {
                visitorsTable.ajax.url("{{ route('admin.visitors.get-banned-visitors') }}").load();
            });
            $('#notbannedVisitors').on('click', function() {
                visitorsTable.ajax.url("{{ route('admin.visitors.get-notbanned-visitors') }}").load();
            });
        });





    </script>

@endsection
