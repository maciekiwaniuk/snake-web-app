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
                    <strong>IP odwiedzających</strong>
                </div>



    </div>

@endsection
