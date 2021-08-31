@extends('layouts.layout')

@section('title')
    Pomoc
@endsection

@push('css')
    <link href="{{ asset('css/pages/support.css') }}" rel="stylesheet" type="text/css">
@endpush

<style>
    .link-blue{
        font-style: italic !important;
    }
</style>

@section('content')

<div class="col-12
            p-3
            mt-0 mt-sm-2 mt-md-3 mt-lg-4
            border border-2 border-success
            bg-gradient-to-left border-radius-15">


            <div class="accordion" id="supportAccordion" style="font-weight: 500;">

                <!-- Co tu się tak właściwie dzieje? -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingGenerally">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGenerally" aria-expanded="false" aria-controls="collapseGenerally">
                            <strong>Co tu się tak właściwie dzieje?</strong>
                        </button>
                    </h2>
                    <div id="collapseGenerally" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="co-sie-dzieje") collapse show @else collapse @endif" aria-labelledby="headingGenerally" data-bs-parent="#supportAccordion">
                        <div class="accordion-body text-start">

                            Jest to strona na której możemy utworzyć konto, które umożliwia m.in. rywalizację z innymi użytkownikami, modyfikację profilu, czy wczytanie postępu z gry,
                            która jest dostępna do pobrania na komputer w zakładce <a class="link-blue" href="{{ route('support.show', 'pobierz-gre') }}">Pobierz grę</a>. Więcej o wczytywaniu
                            postępu w grze na stronę w zakładce <a class="link-blue" href="{{ route('support.show', 'akcje') }}">Akcje</a>.

                        </div>
                    </div>
                </div>

                <!-- Zakładka ustawienia -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOptionsTab">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOptionsTab" aria-expanded="false" aria-controls="collapseOptionsTab">
                            <strong>Zakładka Ustawienia</strong>
                        </button>
                    </h2>
                    <div id="collapseOptionsTab" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="zakladka-ustawienia") collapse show @else collapse @endif" aria-labelledby="headingOptionsTab" data-bs-parent="#supportAccordion">
                        <div class="accordion-body text-start">

                            W zakładce <strong><em>Ustawienia</em></strong> możliwa jest zmiana awatara użytkownika, hasła oraz e-maila. Istnieje również możliwość permanentnego usunięcia
                            konta po podaniu hasła użytkownika. <br>

                        </div>
                    </div>
                </div>

                <!-- Zakładka akcje -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingActionsTab">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseActionsTab" aria-expanded="false" aria-controls="collapseActionsTab">
                            <strong>Zakładka Akcje</strong>
                        </button>
                    </h2>
                    <div id="collapseActionsTab" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="akcje") collapse show @else collapse @endif" aria-labelledby="headingActionsTab" data-bs-parent="#supportAccordion">
                        <div class="accordion-body text-start">

                            Wczytanie postępu z gry jest możliwe z pliku, który jesteśmy w stanie uzyskać z zainstalowanej gry. Po udanej instalacji gry a następnie wejściu w ustawienia
                            (w grze) oraz kliknięciu <em>Zapisz progres</em>, utworzy się plik wraz całym osiągniętym postępem w grze we wskazanym miejscu na urządzeniu.

                            <!-- Zagnieżdżony accordion ze szczegółowymi wskazówkami dotyczącymi wczytywania postępu -->
                            <div class="accordion mt-2" id="actionDetailsAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingactionDetails">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseactionDetails" aria-expanded="false" aria-controls="collapseactionDetails">
                                            <strong>Szczegółowo</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseactionDetails" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingactionDetails" data-bs-parent="#actionDetailsAccordion">
                                        <div class="accordion-body text-start">
                                            <strong>Aby dodać postęp w grze a następnie pojawić się w rankingu:</strong>
                                            <ol class="mt-2">
                                                <li><a class="link-blue" href="{{ route('support.show', 'pobierz-gre') }}">Pobierz grę</a> a następnie ją uruchom</li>
                                                <li>Wejdź do gry, następnie wejdź do zakładki z ustawieniami</li>
                                                <li>Kliknij w <strong><em>Zapisz progres</em></strong></li>
                                                <li>Wybierz miejsce na urządzeniu poprzez kliknięcie w dowolne miejsce <em>(np. pulpit)</em> w okienku, które się pojawiło </li>
                                                <li>Po wybraniu miejsca utworzenia, kliknij w <strong><em>Wybierz folder</em></strong> w prawym dolnym rogu okna</li>
                                                <li>Zaloguj się na stronę</li>
                                                <li>Kliknij na swoją nazwę/awatar</li>
                                                <li>Kliknij w zakładkę <strong><em>Akcje</em></strong></li>
                                                <li>Pod napisem <strong>Wczytaj postęp osiągnięty w grze z pliku</strong> kliknij w <em class="text-success">Wybierz plik | Nie wybrano pliku</em></li>
                                                <li>Wybierz wcześniej zapisany plik z postępem gry poprzez kliknięcie w utworzony plik we wcześniejszych podpunktach</li>
                                                <li>Kliknij w prawym dolnym rogu okienka <strong><em>Otwórz</em></strong></li>
                                                <li>Po pomyślnym wczytaniu postępu, wybierz go w celu wyświetlenia w rankingu</li>
                                                <li>W celu ustawienia postępu kliknij w kółeczko w kolumnie <em>Ustaw</em></li>
                                            </ol>
                                            <strong class="text-success"><em>GOTOWE! :)</em></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Zakładka pobierz grę -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingActionsDownload">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseActionsDownload" aria-expanded="false" aria-controls="collapseActionsDownload">
                            <strong>Zakładka Pobierz grę</strong>
                        </button>
                    </h2>
                    <div id="collapseActionsDownload" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="pobierz-gre") collapse show @else collapse @endif" aria-labelledby="headingActionsDownload" data-bs-parent="#supportAccordion">
                        <div class="accordion-body text-start">

                            Pobranie gry umożliwia zakładka <a class="link-blue" href="{{ route('download') }}" target="_blank"><strong><em>Pobierz grę</em></strong></a>. Znajdziemy w niej przyciski,
                            które przenoszą na dany hosting w celu pobrania plików gry. Możliwe jest pobranie tzw. instalki czyli, pliku exe który po podwójnym kliknięciu umożliwi nam zainstalowanie
                            gry we wskazanym miejscu na komputerze. Pobranie instalatora (plik exe) w większości przypadków wiąże się z problemami związanymi z wykrywaniem pliku przez Windows Defener
                            jako niebezpiecznie oprogramowanie, więc jeżeli chcemy uniknąć tego typu problemów zalecane jest zwykłe pobranie plików gry (pobieranie plików może zająć odrobinę dłużej
                            niż pobieranie instalatora).

                                <!-- Zagnieżdżony accordion ze wskazówkami dotyczącymi instalacji -->
                                <div class="accordion mt-2" id="installationAccordion">
                                    <!-- Pliki -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFiles">
                                            <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiles" aria-expanded="false" aria-controls="collapseFiles">
                                                <strong>Zwykłe pobieranie plików</strong>
                                            </button>
                                        </h2>
                                        <div id="collapseFiles" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="pobieranie-plikow") collapse show @else collapse @endif" aria-labelledby="headingFiles" data-bs-parent="#installationAccordion">
                                            <div class="accordion-body text-start">

                                                <strong>Aby zainstalować grę w najprostszy sposób należy:</strong>
                                                <ol>
                                                    <li>Wejdź w zakładkę <a class="link-blue" href="{{ route('download') }}" target="_blank"><strong><em>Pobierz grę</em></strong></a></li>
                                                    <li>Kliknij w przycisk <strong><em class="text-success">Pobierz</em></strong> gdzie w nazwie jest napisane <strong><em>(pliki)</em></strong></li>
                                                    <li>Jeżeli na nowo otwartej karcie wyskoczyło potwierdzenie o ciasteczka, kliknij <strong class="text-success"><em>Accept all cookies</em></strong>
                                                        w przeciwnym wypadku, przejdź do kolejnego punktu</li>
                                                    <li>Następnie kliknij w <strong class="text-success"><em>Download as zip</em></strong></li>
                                                    <div class="col text-center">
                                                        <img class="w-100" src="{{ asset('assets/images/support_images/download_files/tip_1.jpg') }}">
                                                    </div>
                                                    <li>Po kliknięciu pobieranie powinno się rozpocząć, pobieranie może pod koniec zwolnić do bardzo niskiej prędkości, wówczas nie wyłączać pobierania, tylko przeczekać</li>
                                                    <li>Po pobraniu przejdź do folderu <em class="text-success">Pobrane</em> <kbd>Ctrl + J</kbd></li>
                                                    <li>Następnie wypakuj pobrany plik</li>
                                                    <li>Wypakowany folder możesz przechowywać gdziekolwiek na urządzeniu (może to być pulpit)</li>
                                                    <li>Wejdź do wypakowanego folderu, kliknij na niego raz lewym nastepnie prawym przyciskiem a następnie kliknij <strong><em>Utwórz skrót</em></strong></li>
                                                    <li>Utworzony skrót przenieś na pulpit (może to być dowolne inne miejsce na urządzeniu) przeciągając go, następnie zmień nazwę skrótu na np. Snake</li>
                                                    <li>A następnie uruchom grę poprzez dwukrotnie kliknięcie lewym przyciskiem</li>
                                                </ol>
                                                <strong class="text-success"><em>voilà! Udało się! :)</em></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- EXE -->
                                    {{-- <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingExe">
                                            <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExe" aria-expanded="false" aria-controls="collapseExe">
                                                <strong>Pobieranie instalatora</strong>
                                            </button>
                                        </h2>
                                        <div id="collapseExe" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="pobieranie-instalki") collapse show @else collapse @endif" aria-labelledby="headingExe" data-bs-parent="#installationAccordion">
                                            <div class="accordion-body text-start">



                                            </div>
                                        </div>
                                    </div> --}}
                                </div>

                        </div>
                    </div>


                </div>

            </div>

</div>

@endsection
