@extends('layouts.layout')

@section('title')
    Logowanie
@endsection


@section('content')


    <div class="row mt-sm-1 mt-md-5">

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 col-xl-5 col-xxl-5
                    mx-auto">
            <div class="login-form p-3
                        border border-2 border-success
                        bg-gradient-to-left border-radius-25">

                    @if ($errors->any())
                        <div class="col-10 offset-1 text-center mb-3 p-2 pb-3
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

                    <div class="col-12">
                        Dziękujemy za rejestracje! Przed rozpoczęciem korzystania ze strony,
                        bylibyśmy wdzięczni za weryfikację adresu email. Możesz to zrobić poprzez
                        link, który został na twój email. Jeżeli email nie doszedł, możemy
                        wysłać Ci kolejny email klikając w przycisk poniżej.
                    </div>

                <form method="POST" action="{{ route('register') }}" class="row g-3">
                    @csrf

                    <div class="row mt-4">
                        <div class="col-7 mt-2">
                            <button type="submit" class="btn btn-md
                                                         border border-2 border-success
                                                         border-radius-15 bg-orangeyellow"
                            >Wyślij link ponownie</button>
                        </div>

                        <div class="col-5 mt-2 text-end">
                            <form method="POST" action="{{ route('logout') }}">

                                    <button type="submit" class="btn btn-md
                                                                 border border-2 border-success
                                                                 border-radius-15 bg-orangeyellow"
                                    >Wyloguj</button>

                            </form>
                        </div>


                    </div>


                </form>

            </div>

        </div>

    </div>


@endsection
