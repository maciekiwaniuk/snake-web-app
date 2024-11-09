@extends('layouts.layout')

@section('title')
    Serwer
@endsection

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
                    <strong>PHP Info</strong>
                </div>

                <iframe src="{{ route('admin.php-info.src') }}"
                        class="col-12 border border-2 border-dark"
                        style="height: 80vh;"></iframe>


    </div>

@endsection
