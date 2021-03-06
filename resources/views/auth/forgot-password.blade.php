@extends('layouts.layout')

@section('title')
    Przypomnij hasło
@endsection


@section('content')


    <div class="row mt-sm-1 mt-md-5">

        <div class="col-xs-12 col-sm-9 col-md-8 col-lg-6 col-xl-5 col-xxl-5
                    mx-auto">
            <div class="p-3
                        border border-2 border-success
                        bg-gradient-to-left border-radius-25">

                    @if (session('status'))
                        <div class="col-12 col-sm-10 mx-auto
                                    text-center mb-3 p-2 pb-3
                                    mt-2 fs-6
                                    border border-2 border-success
                                    border-radius-15 bg-complete">
                                    <div class="valid-feedback d-block">
                                        <strong>• Link resetujący hasło został wysłany na wskazany e-mail.</strong>
                                    </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="col-12 col-sm-10 mx-auto
                                    text-center mb-3 p-2 pb-3
                                    border border-2 border-danger
                                    border-radius-15"
                             style="background-color: rgb(240, 183, 183);">
                            @foreach ($errors->all() as $error)
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        </div>
                    @endif

                <form method="POST" action="{{ route('password.email') }}" class="row g-3">
                    @csrf

                    <div class="col-12">
                        Hasło się zgubiło? Nie ma problemu. Podaj nam swój adres email
                        na który zostało założone konto, a następnie wyślemy Ci
                        linka, który umożliwi ustawienie nowego.
                    </div>

                    <div class="col-12">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="mx-auto col-10 text-center">
                        <button type="submit" class="btn btn-sm fs-5
                                                     border border-2 border-success
                                                     border-radius-15 bg-orangeyellow"
                        >Wyślij link resetujący</button>
                    </div>
                </form>

            </div>

        </div>

    </div>


@endsection
