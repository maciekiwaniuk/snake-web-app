@extends('layouts.layout')

@section('title')
    Narzędzia
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
                    <strong>Narzędzia</strong>
                </div>


                @if (session('message'))

                    <div class="col-12 col-sm-10 mx-auto
                                text-center mb-3 p-2 pb-3
                                border border-2 border-success
                                border-radius-15 bg-complete">
                        <div class="valid-feedback d-block">
                            • {{ session('message') }}
                        </div>
                    </div>

                @endif


                <div class="row">

                    <div class="col-11 col-md-5
                                mt-3
                                pt-2
                                pb-3
                                mx-auto text-center
                                bg-light
                                border border-2 border-success
                                border-radius-15">

                            <div class="col-12 pb-1">
                                Czyszczenie cache aplikacji
                            </div>

                            <div class="col-12">
                                <form action="{{ route('admin.artisan-tools.clear-app-cache') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger border border-2 border-dark">Wykonaj</button>
                                </form>
                            </div>
                    </div>

                    <div class="col-11 col-md-5
                                mt-3
                                pt-2
                                pb-3
                                mx-auto text-center
                                bg-light
                                border border-2 border-success
                                border-radius-15">

                            <div class="col-12 pb-1">
                                Czyszczenie cache routingu
                            </div>

                            <div class="col-12">
                                <form action="{{ route('admin.artisan-tools.clear-route-cache') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger border border-2 border-dark">Wykonaj</button>
                                </form>
                            </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-11 col-md-5
                                mt-3
                                pt-2
                                pb-3
                                mx-auto text-center
                                bg-light
                                border border-2 border-success
                                border-radius-15">

                            <div class="col-12 pb-1">
                                Czyszczenie cache konfiguracji
                            </div>

                            <div class="col-12">
                                <form action="{{ route('admin.artisan-tools.clear-config-cache') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger border border-2 border-dark">Wykonaj</button>
                                </form>
                            </div>
                    </div>

                    <div class="col-md-5 mx-auto"></div>

                </div>


    </div>

@endsection
