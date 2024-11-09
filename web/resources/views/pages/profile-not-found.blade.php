@extends('layouts.layout')

@section('title')
    Użytkownik nie istnieje
@endsection

@section('content')

    <div class="row">
        <div class="col-11 col-sm-10 col-md-10 col-lg-8
                    mx-auto text-center
                    mt-2 mt-sm-2
                    mb-1
                    fs-3 py-2
                    border border-2 border-success border-radius
                    bg-gradient-to-left
                    border-radius-15">
                    Użytkownik z nazwą {{ $name }} nie istnieje.</div>
    </div>

@endsection
