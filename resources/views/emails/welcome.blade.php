@component('mail::message')
# Konto zostało pomyślnie utworzone.

Dziękujemy za rejestrację na stronie! Życzymy udanej gry!

@component('mail::button', ['url' => URL::route('home')])
    <div>
        Strona główna
    </div>
@endcomponent

@endcomponent
