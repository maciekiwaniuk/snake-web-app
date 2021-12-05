@extends('layouts.layout')

@section('title')
    Zresetuj hasło
@endsection


@section('content')


    <div class="row mt-sm-1 mt-md-5">

        <div class="col-xs-12 col-sm-9 col-md-8 col-lg-6 col-xl-5 col-xxl-5
                    mx-auto">
            <div class="p-3
                        border border-2 border-success
                        bg-gradient-to-left border-radius-25">

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

                <form method="POST" action="{{ route('password.update') }}" class="row g-3">
                    @csrf

                    <h4 class="text-center">Resetowanie hasła</h4>

                    <div class="col-12">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>


                    <div class="col-12">
                        <label for="password">Hasło</label>
                        <input type="password" name="password" class="form-control" placeholder="" required>
                    </div>


                    <div class="col-12">
                        <label for="password_confirmation">Powtórz hasło</label>
                        <input type="password" name="password_confirmation" class="form-control"placeholder="" required>
                    </div>


                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-sm fs-4
                                                     border border-2 border-success
                                                     border-radius-15 bg-orangeyellow"
                        >Zresetuj</button>
                    </div>
                </form>

            </div>

        </div>

    </div>


@endsection
