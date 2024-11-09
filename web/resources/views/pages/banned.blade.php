@extends('layouts.layout')

@section('title')
    Twoje ip zostało zbanowane!
@endsection

@section('content')

    <div class="container-md mb-5" style="min-height: 100vh">
        <div class="col-12 text-center fs-1 text-danger">Twoje IP: <strong>{{ $ip }}</strong> zostało zbanowane.</div>
    </div>

@endsection
