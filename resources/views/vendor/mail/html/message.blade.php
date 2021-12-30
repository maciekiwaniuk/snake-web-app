@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <div style="color: white !important;">{{ config('app.name') }}</div>
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} | <a href="{{ route('home') }}" style="text-decoration: none;">snake-gra.pl</a> | Wszelkie prawa zastrzeżone
        @endcomponent
    @endslot
@endcomponent
