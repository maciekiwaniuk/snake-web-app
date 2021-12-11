@extends('layouts.layout')

@section('title')
    Wyślij wiadomość
@endsection

@push('css')
    <!-- Message page CSS -->
    <link href="{{ asset('css/pages/message.css') }}" type="text/css" rel="stylesheet">
@endpush

@push('js.header')
    <!-- reCAPTCHA v2 JS -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush


@section('content')

<style>
    .g-recaptcha {
        display: inline-block;
    }
</style>

    <div class="row mt-2 mt-sm-3 mt-md-5">

        <div class="col-xs-12 col-sm-9 col-md-8 col-lg-6 col-xl-5 col-xxl-5
                    mx-auto">
            <div class="p-3
                        border border-2 border-success
                        bg-gradient-to-left border-radius-25">

                    @if ($errors->any())
                        <div class="col-12 col-sm-10 mx-auto
                                    text-center mb-3 p-2 pb-3
                                    border border-2 border-danger
                                    border-radius-15 bg-error">
                            @foreach ($errors->all() as $error)
                                <div class="invalid-feedback d-block">
                                    <strong>• {{ $error }}</strong>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="col-12 col-sm-10 mx-auto
                                    text-center mb-3 p-2 pb-3
                                    border border-2 border-success
                                    border-radius-15 bg-complete">
                                    <div class="valid-feedback d-block">
                                        <strong>• {{ session('success') }}</strong>
                                    </div>
                        </div>
                     @endif

                <form method="POST" action="{{ route('message.index') }}" class="row g-3">
                    @csrf
                    <h4 class="text-center">Wyślij wiadomość</h4>

                    <div class="col-12">
                        <label for="subject">Temat</label>
                        <select name="subject" class="form-control">
                            <option value="contact" class="form-control" @if(isset($selected) && $selected=="kontakt") selected @endif>Kontakt</option>
                            <option value="error-website" class="form-control" @if(isset($selected) && $selected=="blad-strona") selected @endif>Błąd na stronie</option>
                            <option value="error-game" class="form-control" @if(isset($selected) && $selected=="blad-gra") selected @endif>Błąd w grze</option>
                            <option value="idea-website" class="form-control" @if(isset($selected) && $selected=="pomysl-strona") selected @endif>Pomysł dotyczący strony</option>
                            <option value="idea-game" class="form-control" @if(isset($selected) && $selected=="pomysl-gra") selected @endif>Pomysł dotyczący gry</option>
                            <option value="other" class="form-control" @if(isset($selected) && $selected=="inne") selected @endif>Inne</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="sender">Twoja nazwa</label>
                        <input type="text" name="sender" class="form-control" value="@if(Auth::check()){{ Auth::user()->name }}@else{{ old('sender') }}@endif" required>
                    </div>

                    <div class="col-12">
                        <label for="email">Twój e-mail</label>
                        <input type="text" name="email" class="form-control" value="@if(Auth::check()){{ Auth::user()->email }}@else{{ old('email') }}@endif" required>
                    </div>

                    <div class="col-12">
                        <label for="content">Treść wiadomości</label>
                        <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
                    </div>

                    @if(env('CAPTCHA_VALIDATION_ENABLED'))
                        <div class="col-12 text-center">
                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_PUBLIC_KEY') }}"></div>
                        </div>
                    @endif

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-sm fs-4
                                                     border border-2 border-success
                                                     border-radius-15 bg-orangeyellow"
                        >Wyślij</button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection
