@extends('layouts.layout')

@push('css')
    <link href="{{ asset('assets/plugins/filepond/filepond.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/pages/profile.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('js.header')
    <script src="{{ asset('assets/plugins/jQuery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond.min.js') }}"></script>
@endpush


@section('title')
    Profil {{ $user->name }}
@endsection


@section('content')

    <div class="col-12
                mx-auto
                mx-5 mt-2 mb-3 fs-3 pt-2 pb-3
                border border-2 border-success
                bg-gradient-to-left border-radius-15">


                <div class="col-12 col-sm-6
                            ms-sm-4
                            mt-sm-2
                            bg-success text-center">


                    <div class="p-sm-4">
                        <div class="col-6 col-sm-12
                                mt-2
                                mx-auto
                                text-center">

                                @if (Auth::user()->id == $user->id)
                                    <a href="{{ route('options.selected', 'awatar') }}">
                                        <img class="img-thumbnail" src="{{ asset($user->avatar) }}">
                                    </a>
                                @else
                                    <img class="img-thumbnail" src="{{ asset($user->avatar) }}">
                                @endif

                        </div>

                        <div class="col-12
                                mx-auto text-center">

                                <span class="nick-size bg-light text-center">
                                    <strong>{{ $user->name }}</strong>
                                </span>
                        </div>
                    </div>



                </div>

    </div>

@endsection
