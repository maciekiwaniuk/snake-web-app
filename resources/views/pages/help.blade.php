@extends('layouts.layout')

@section('title')
    Pomoc
@endsection

@push('css')
    <!-- Help page CSS -->
    <link href="{{ asset('css/pages/help.css') }}" rel="stylesheet" type="text/css">
@endpush

<style>
    .link-blue{
        font-style: italic !important;
    }
</style>

@section('content')

<div class="col-12
            p-3
            mt-2 mt-sm-2 mt-md-3 mt-lg-4
            border border-2 border-success
            bg-gradient-to-left border-radius-15">


            <div class="accordion" id="helpAccordion" style="font-weight: 500;">

                <!-- general info -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingGenerally">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGenerally" aria-expanded="false" aria-controls="collapseGenerally">
                            <strong>Co tu się tak właściwie dzieje?</strong>
                        </button>
                    </h2>
                    <div id="collapseGenerally" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="co-sie-dzieje") collapse show @else collapse @endif" aria-labelledby="headingGenerally" data-bs-parent="#helpAccordion">
                        <div class="accordion-body text-start">

                            Strona umożliwiająca rywalizację graczy poprzez uczestniczenie w rozgrywce. Gra jest możliwa do pobrania w zakładce
                            <a class="link-blue" href="{{ route('download') }}">Pobierz grę</a>.
                            Więcej o tym jak zainstalować grę w zakładce <a class="link-blue" href="{{ route('help.show', 'zakladka-instalacja-gry') }}">Instalacja gry</a>.
                            Po utworzeniu konta na stronie użytkownik ma dostęp do ustawień, w których może m.in. zmienić swój awatar, który będzie widoczny w zakładce
                            <a class="link-blue" href="{{ route('ranking.index') }}">Ranking</a>.

                        </div>
                    </div>
                </div>

                <!-- install game -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingInstallGameTab">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInstallGameTab" aria-expanded="false" aria-controls="collapseInstallGameTab">
                            <strong>Instalacja gry</strong>
                        </button>
                    </h2>
                    <div id="collapseInstallGameTab" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="zakladka-instalacja-gry") collapse show @else collapse @endif" aria-labelledby="headingInstallGameTab" data-bs-parent="#helpAccordion">
                        <div class="accordion-body text-start">

                            Instalacja gry

                        </div>
                    </div>
                </div>

                <!-- game -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingGameTab">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGameTab" aria-expanded="false" aria-controls="collapseGameTab">
                            <strong>Wszystko o grze</strong>
                        </button>
                    </h2>
                    <div id="collapseGameTab" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="zakladka-o-grze") collapse show @else collapse @endif" aria-labelledby="headingGameTab" data-bs-parent="#helpAccordion">
                        <div class="accordion-body text-start">

                            o grze

                        </div>
                    </div>
                </div>

                <!-- options -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOptionsTab">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOptionsTab" aria-expanded="false" aria-controls="collapseOptionsTab">
                            <strong>Zakładka Ustawienia</strong>
                        </button>
                    </h2>
                    <div id="collapseOptionsTab" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="zakladka-ustawienia") collapse show @else collapse @endif" aria-labelledby="headingOptionsTab" data-bs-parent="#helpAccordion">
                        <div class="accordion-body text-start">

                            W zakładce <strong><em>Ustawienia</em></strong> możliwa jest zmiana awatara użytkownika, hasła oraz e-mail'a. Istnieje również możliwość permanentnego usunięcia
                            konta po podaniu hasła użytkownika. <br>

                        </div>
                    </div>
                </div>

                <!-- download -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingActionsDownload">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseActionsDownload" aria-expanded="false" aria-controls="collapseActionsDownload">
                            <strong>Zakładka Pobierz grę</strong>
                        </button>
                    </h2>
                    <div id="collapseActionsDownload" class="bg-accordion-body accordion-collapse @if(isset($selected) && ($selected=="pobierz-gre" || $selected=="pobieranie-plikow" || $selected=="pobieranie-instalatora")) collapse show @else collapse @endif" aria-labelledby="headingActionsDownload" data-bs-parent="#helpAccordion">
                        <div class="accordion-body text-start">

                            Pobranie gry umożliwia zakładka <a class="link-blue" href="{{ route('download') }}" target="_blank"><strong><em>Pobierz grę</em></strong></a>. Znajdziemy w niej przyciski,
                            które przenoszą na dany hosting w celu pobrania plików gry. Możliwe jest pobranie tzw. instalki, czyli pliku exe, który po podwójnym kliknięciu umożliwi nam zainstalowanie
                            gry we wskazanym miejscu na komputerze. W większości przypadków wiąże się to z wykryciem przez Windows Defender jako niedozwolone oprogramowanie, w celu obejścia tego
                            więcej w zakładce <strong><a class="link-blue" href="{{ route('help.show', 'pobieranie-instalatora') }}">Pobieranie instalatora gry</a></strong>. Jeżeli wystąpią poważniejsze
                            problemy zawsze jest możliwość <strong><a class="link-blue" href="{{ route('help.show', 'pobieranie-plikow') }}">pobrania plików</a></strong>, lecz może to potrwać
                            dłużej niż pobieranie instalatora.

                                <!-- nestle accordion with install tips -->
                                <div class="accordion mt-2" id="installationAccordion">

                                    <!-- exe -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingExe">
                                            <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExe" aria-expanded="false" aria-controls="collapseExe">
                                                <strong>Pobieranie instalatora</strong>
                                            </button>
                                        </h2>
                                        <div id="collapseExe" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="pobieranie-instalatora") collapse show @else collapse @endif" aria-labelledby="headingExe" data-bs-parent="#installationAccordion">
                                            <div class="accordion-body text-start">

                                                <strong>Aby zainstalować grę pobierając instalkę należy:</strong>
                                                <ol>
                                                    <li>Wejdź w zakładkę <a class="link-blue" href="{{ route('download') }}" target="_blank"><strong><em>Pobierz grę</em></strong></a></li>
                                                    <li>Kliknij w przycisk <strong><em class="text-success">Pobierz</em></strong> gdzie w nazwie jest napisane <strong><em>(instalka)</em></strong></li>
                                                    <li>Jeżeli na nowo otwartej karcie wyskoczyło potwierdzenie o ciasteczka, kliknij <strong class="text-success"><em>Accept all cookies</em></strong></li>
                                                    <li>Następnie kliknij w <strong class="text-success"><em>Download</em></strong></li>
                                                    <li>Po kliknięciu pobieranie powinno się rozpocząć.</li>
                                                    <li>Po pobraniu przejdź do folderu <em class="text-success">Pobrane</em> <kbd>Ctrl + J</kbd></li>
                                                    <li>Dwukrotnie kliknij na pobrany instalator</li>
                                                    <li>Po pojawieniu się okienka kliknij w <em>Więcej informacji</em></li>
                                                    <div class="col-12 col-sm-8 col-md-6 col-lg-5
                                                                text-center">
                                                        <img alt="Zdjęcie porady #2" class="w-100" src="{{ asset('assets/images/help_images/download_files/tip_2.jpg') }}">
                                                    </div>
                                                    <li>Po wyskoczeniu przycisku <em>Uruchom mimo to</em>, naciśnij go</li>
                                                    <div class="col-12 col-sm-8 col-md-6 col-lg-5
                                                                text-center">
                                                        <img alt="Zdjęcie porady #3" class="w-100" src="{{ asset('assets/images/help_images/download_files/tip_3.jpg') }}">
                                                    </div>
                                                    <li>Wejdź do zainstalowanego folderu z grą, kliknij na plik Snake raz lewym, a raz prawym przyciskiem i następnie kliknij <strong><em>Utwórz skrót</em></strong></li>
                                                    <li>Utworzony skrót przenieś na pulpit (może to być dowolne inne miejsce na urządzeniu) przeciągając go, następnie zmień nazwę skrótu na np. Snake</li>
                                                    <li>Uruchom grę poprzez dwukrotnie kliknięcie lewym przyciskiem</li>
                                                </ol>
                                                <strong class="text-success"><em>voilà! Udało się! :)</em></strong>
                                            </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- files -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFiles">
                                            <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiles" aria-expanded="false" aria-controls="collapseFiles">
                                                <strong>Pobieranie plików</strong>
                                            </button>
                                        </h2>
                                        <div id="collapseFiles" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="pobieranie-plikow") collapse show @else collapse @endif" aria-labelledby="headingFiles" data-bs-parent="#installationAccordion">
                                            <div class="accordion-body text-start">

                                                <strong>Aby zainstalować grę pobierając pliki należy:</strong>
                                                <ol>
                                                    <li>Wejdź w zakładkę <a class="link-blue" href="{{ route('download') }}" target="_blank"><strong><em>Pobierz grę</em></strong></a></li>
                                                    <li>Kliknij w przycisk <strong><em class="text-success">Pobierz</em></strong> gdzie w nazwie jest napisane <strong><em>(pliki)</em></strong></li>
                                                    <li>Jeżeli na nowo otwartej karcie wyskoczyło potwierdzenie o ciasteczka, kliknij <strong class="text-success"><em>Accept all cookies</em></strong></li>
                                                    <li>Następnie kliknij w <strong class="text-success"><em>Download as zip</em></strong></li>
                                                    <div class="col text-center">
                                                        <img alt="Zdjęcie porady #1" class="w-100" src="{{ asset('assets/images/help_images/download_files/tip_1.jpg') }}">
                                                    </div>
                                                    <li>Po kliknięciu pobieranie powinno się rozpocząć. Pobieranie może pod koniec zwolnić do bardzo niskiej prędkości (wówczas nie wyłączaj pobierania, tylko przeczekaj)</li>
                                                    <li>Po pobraniu przejdź do folderu <em class="text-success">Pobrane</em> <kbd>Ctrl + J</kbd></li>
                                                    <li>Następnie wypakuj pobrany plik</li>
                                                    <li>Wypakowany folder możesz przechowywać gdziekolwiek na urządzeniu (może to być pulpit)</li>
                                                    <li>Wejdź do wypakowanego folderu, kliknij na plik <em>Snake</em> raz lewym, a raz prawym przyciskiem i następnie kliknij <strong><em>Utwórz skrót</em></strong></li>
                                                    <li>Utworzony skrót przenieś na pulpit (może to być dowolne inne miejsce na urządzeniu) przeciągając go, następnie zmień nazwę skrótu na np. Snake</li>
                                                    <li>Uruchom grę poprzez dwukrotnie kliknięcie lewym przyciskiem</li>
                                                </ol>
                                                <strong class="text-success"><em>Sukces! :)</em></strong>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                        </div>
                    </div>
                </div>






                <!-- hidden tab - programming babble -->
                <div class="accordion-item d-none" style="font-weight: 500;">
                    <h2 class="accordion-header" id="headingInfo">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="false" aria-controls="collapseInfo">
                            <strong>Programistyczny bełkot</strong>
                        </button>
                    </h2>
                    <div id="collapseInfo" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="programistyczny-belkot") collapse show @else collapse @endif" aria-labelledby="headingInfo" data-bs-parent="#helpAccordion">
                        <div class="accordion-body text-start">

                            <strong>Do stworzenia strony zostały użyte następujące technologie:</strong>
                            <ol>
                                <li><a class="link-blue" href="https://laravel.com/" target="_blank">PHP Framework Laravel</a></li>
                                <li><a class="link-blue" href="https://getbootstrap.com/docs/5.0/getting-started/introduction/" target="_blank">Bootstrap 5</a></li>
                                <li><a class="link-blue" href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a></li>
                                <li><a class="link-blue" href="https://datatables.net/" target="_blank">DataTables</a></li>
                                <li><a class="link-blue" href="https://github.com/JeremyFagis/dropify" target="_blank">dropify</a></li>
                                <li><a class="link-blue" href="https://jquery.com/" target="_blank">jQuery</a></li>
                                <li><a class="link-blue" href="https://github.com/malsup/blockui" target="_blank">jQuery BlockUI</a></li>
                                <li><a class="link-blue" href="https://github.com/CodeSeven/toastr" target="_blank">toastr</a></li>
                                <li><a class="link-blue" href="https://developers.google.com/recaptcha/docs/display" target="_blank">reCAPTCHA v2</a></li>
                            </ol>

                            <strong>Do stworzenia gry zostały użyte poniższe technologie:</strong>
                            <ol>
                                <li><a class="link-blue" href="https://www.pygame.org/docs/" target="_blank">Python Framework pygame</a></li>
                                <li><a class="link-blue" href="https://pypi.org/project/PyQt5/">PyQt5</a></li>
                            </ol>

                            <strong>Oraz następujące moduły:</strong>
                            <ul>
                                <li><a class="link-blue" href="https://docs.python.org/3/library/tkinter.html" target="_blank">tkinter</a></li>
                                <li><a class="link-blue" href="https://docs.python.org/3/library/os.html" target="_blank">os</a></li>
                                <li><a class="link-blue" href="https://docs.python.org/3/library/json.html" target="_blank">json</a></li>
                                <li><a class="link-blue" href="https://docs.python.org/3/library/sys.html" target="_blank">sys</a></li>
                                <li><a class="link-blue" href="https://docs.python.org/3/library/shutil.html" target="_blank">shutil</a></li>
                                <li><a class="link-blue" href="https://docs.python.org/3/library/datetime.html" target="_blank">datetime</a></li>
                                <li><a class="link-blue" href="https://docs.python.org/3/library/random.html" target="_blank">random</a></li>
                                <li><a class="link-blue" href="https://docs.python.org/3/library/webbrowser.html" target="_blank">webbrowser</a></li>
                                <li><a class="link-blue" href="https://docs.python-requests.org/en/master/" target="_blank">requests</a></li>
                            </ul>

                        </div>
                    </div>
                </div>


            </div>

</div>

@endsection
