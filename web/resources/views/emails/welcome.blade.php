@component('mail::message')
@if(isset($user))
# Hej, {{ $user->name }}!
@else
# Hej!
@endif
# Konto zostało pomyślnie utworzone.

Dziękujemy za rejestrację na stronie! Życzymy udanej rozgrywki!

@component('mail::button', ['url' => URL::route('home')])
    Strona główna
@endcomponent

@endcomponent
