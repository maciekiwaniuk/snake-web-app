@extends('layouts.layout')

@section('title')
    Logowanie
@endsection


@section('content')


    <div class="row mt-2 mt-sm-3 mt-md-5">

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 col-xl-5 col-xxl-4
                    mx-auto">
            <div class="login-form p-3
                        border border-2 border-success
                        bg-gradient-to-left border-radius-25">

                <form method="POST" action="{{ route('login') }}" class="row g-3">
                    @csrf
                    <h4 class="text-center mb-0">Panel logowania</h4>
                    <div class="col-12">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" class="form-control" placeholder="" value="{{ old('email') }}">
                    </div>
                    @if ($errors)
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first() }}</strong>
                        </div>
                    @endif


                    <div class="col-12">
                        <label for="password">Hasło</label>
                        <input type="password" name="password" class="form-control" placeholder="" required>
                    </div>


                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Zapamiętaj mnie</label>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-sm fs-4
                                                     border border-2 border-success
                                                     border-radius-15 bg-orangeyellow"
                        >Zaloguj</button>
                    </div>
                    <div class="col-12 text-center my-0">
                        <a href="{{ route('password.request') }}" class="btn link mt-1 p-0">Hasło się zapodziało?</a>
                    </div>
                </form>


                <hr class="mt-2">

                <div class="col-12">
                    <p class="text-center mb-0">Nie masz jeszcze konta?
                        <a href="{{ route('register') }}" class="btn border border-2 border-success
                                           bg-orangeyellow border-radius-10"
                        >Zarejestruj się!</a>
                    </p>
                </div>

            </div>

        </div>

    </div>


@endsection
