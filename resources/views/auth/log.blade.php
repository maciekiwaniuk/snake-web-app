@extends('layouts.layout')

@section('title')
    Logowanie
@endsection


@section('content')


    <div class="row mt-5">

        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4
                    offset-sm-1 offset-md-2 offset-lg-3 col-xl-4"
             style="">
            <div class="login-form p-3
                        border border-2 border-success"
                 style="background-image: linear-gradient(to left, rgb(183, 255, 0), rgb(18, 255, 18));
                        border-radius: 15px;">
                <form action="" method="" class="row g-3">
                    <h4 class="text-center">Panel logowania</h4>
                    <div class="col-12">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" placeholder="">
                    </div>
                    <div class="col-12">
                        <label>Hasło</label>
                        <input type="password" name="password" class="form-control" placeholder="">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Zapamiętaj mnie</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark float-end">Zaloguj</button>
                    </div>
                </form>
                <hr class="mt-4">
                <div class="col-12">
                    <p class="text-center mb-0">Jeszcze nie masz konta?
                        <a href="#" class="btn btn-primary">Zarejestruj się!</a></p>
                </div>
            </div>
        </div>

    </div>


@endsection
