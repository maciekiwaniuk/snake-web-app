@extends('layouts.layout')

@section('title')
    Logi serwera
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
                    <strong>Logi serwera</strong>
                </div>

                <div class="col-12 text-center">
                    <form action="{{ route('admin.server-logs.clear-server-logs') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-primary">Wyczyść logi</button>
                    </form>
                </div>

                <div class="col-12
                            mx-auto text-center fs-6">

                            <div class="mt-3
                                        table-responsive-xl">
                                <table id="LogsTable" class="table table-dark table-hover">
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
            var logsTable = $('#LogsTable').DataTable({
                oLanguage: {
                    sUrl: "{{ asset('assets/plugins/DataTables/pl.json') }}"
                },
                order: [[ 0, 'asc' ]],
                serverSide: false,
                ajax: {
                    url: "{{ route('admin.server-logs.get-server-logs') }}",
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
                        title: 'Zawartość loga',
                        data: 'content',
                        class: 'align-center'
                    },
                    {
                        title: 'Data',
                        data: 'date',
                        class: 'align-middle'
                    }
                ],

            });
        });

    </script>

@endsection
