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
                            <a class="link-blue" href="{{ route('game-hostings.index') }}">Pobierz grę</a>.
                            Więcej o tym jak zainstalować grę w zakładce <a class="link-blue" href="{{ route('help.show', 'zakladka-instalacja-gry') }}">Instalacja gry</a>.
                            Po pobraniu gry oraz założeniu konta na stronie, użytkownik może się zalogować do gry w panelu logowania.

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

                            Pobranie gry umożliwia zakładka <a class="link-blue" href="{{ route('game-hostings.index') }}" target="_blank"><strong><em>Pobierz grę</em></strong></a>.
                            Aby pobrać grę należy kliknąć w wybrany przycisk <strong>Pobierz</strong> a następnie poczekać na zakończenie pobierania. Po pomyślnym zakończeniu pobierania
                            instalatora należy kliknąć na niego 2 razy i zainstalować grę w wybranym miejscu na urządzeniu.

                            <!-- nestle accordion with install tips -->
                            <div class="accordion mt-2" id="installationAccordion">

                                <!-- install game tips -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingExe">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExe" aria-expanded="false" aria-controls="collapseExe">
                                            <strong>Instalacja krok po kroku</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseExe" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="pobieranie-instalatora") collapse show @else collapse @endif" aria-labelledby="headingExe" data-bs-parent="#installationAccordion">
                                            <div class="accordion-body text-start">
                                                <strong>Aby zainstalować grę należy:</strong>
                                                <ol>
                                                    <li>Po pobraniu przejdź do folderu <em class="text-success">Pobrane</em>. Skrót klawiszowy: <kbd>Ctrl + J</kbd></li>
                                                    <li>Dwukrotnie kliknij na pobrany plik</li>
                                                    <li>Po pojawieniu się okienka kliknij w <em>Więcej informacji</em></li>
                                                    <div class="col-12 col-sm-8 col-md-6 col-lg-5
                                                                text-center">
                                                        <img alt="Zdjęcie porady #2" class="w-100" src="{{ asset('assets/images/help_images/download_files/tip_2.jpg') }}">
                                                    </div>
                                                    <li>Po pojawieniu się przycisku <em>Uruchom mimo to</em>, naciśnij go.</li>
                                                    <div class="col-12 col-sm-8 col-md-6 col-lg-5
                                                                text-center">
                                                        <img alt="Zdjęcie porady #3" class="w-100" src="{{ asset('assets/images/help_images/download_files/tip_3.jpg') }}">
                                                    </div>
                                                    <li>OD TĄD NIEPEWNE</li>
                                                    <li>Wejdź do zainstalowanego folderu z grą, kliknij na plik Snake raz lewym, a raz prawym przyciskiem i następnie kliknij <strong><em>Utwórz skrót</em></strong></li>
                                                    <li>Utworzony skrót przenieś na pulpit (może to być dowolne inne miejsce na urządzeniu) przeciągając go, następnie zmień nazwę skrótu na np. Snake</li>
                                                    <li>Uruchom grę poprzez dwukrotnie kliknięcie lewym przyciskiem</li>
                                                    <li>DO TĄD NIEPEWNE</li>
                                                </ol>
                                                <strong class="text-success"><em>voilà! Miłego grania! :)</em></strong>
                                            </div>

                                    </div>
                                </div>
                            </div>
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

                            Jest to gra 'w węża', która została zmodyfikowana o wiele dodatków takich różne skórki do węży, wiele owoców do wyboru, rozmaite kolory plansz, czy
                            nawet ranking graczy, przez co niezbędne jest połączenie z internetem. Gracz odblokowuje różne rodzaje poziomów trudności gry, bije rekordy równocześnie
                            zdobywając punkty oraz monety, które może wydać przykładowo na skórki do węży, lub na ulepszenia, które pozwolą szybciej się rozwijać.<br> <br>

                            <!-- nestle accordion with tabs -->
                            <div class="accordion" id="accordionNestleGameTabs" style="font-weight: 500;">

                                <!-- Play tab -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingPlayTab">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlayTab" aria-expanded="true" aria-controls="collapsePlayTab">
                                            <strong>Graj</strong>
                                        </button>
                                    </h2>
                                    <div id="collapsePlayTab" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingPlayTab" data-bs-parent="#accordionNestleGameTabs">
                                        <div class="accordion-body text-start">
                                            Graj kontent
                                        </div>
                                    </div>
                                </div>

                                <!-- Diffilculty levels tab -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingDifficultiesTab">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDifficultiesTab" aria-expanded="true" aria-controls="collapseDifficultiesTab">
                                            <strong>Poziomy trudności</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseDifficultiesTab" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingDifficultiesTab" data-bs-parent="#accordionNestleGameTabs">
                                        <div class="accordion-body text-start">
                                            Poziomy trudności kontent
                                        </div>
                                    </div>
                                </div>

                                <!-- Shop tab -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingShopTab">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShopTab" aria-expanded="true" aria-controls="collapseShopTab">
                                            <strong>Sklep</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseShopTab" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingShopTab" data-bs-parent="#accordionNestleGameTabs">
                                        <div class="accordion-body text-start">
                                            Sklep kontent
                                        </div>
                                    </div>
                                </div>

                                <!-- Inventory tab  -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingInventoryTab">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInventoryTab" aria-expanded="true" aria-controls="collapseInventoryTab">
                                            <strong>Ekwipunek</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseInventoryTab" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingInventoryTab" data-bs-parent="#accordionNestleGameTabs">
                                        <div class="accordion-body text-start">
                                            Ekwipunek kontent
                                        </div>
                                    </div>
                                </div>

                                <!-- Upgrades tab  -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingUpgradesTab">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUpgradesTab" aria-expanded="true" aria-controls="collapseUpgradesTab">
                                            <strong>Ulepszenia</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseUpgradesTab" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingUpgradesTab" data-bs-parent="#accordionNestleGameTabs">
                                        <div class="accordion-body text-start">
                                            Ulepszenia kontent
                                        </div>
                                    </div>
                                </div>

                                <!-- Settings tab  -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSettingsTab">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettingsTab" aria-expanded="true" aria-controls="collapseSettingsTab">
                                            <strong>Ustawienia</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseSettingsTab" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingSettingsTab" data-bs-parent="#accordionNestleGameTabs">
                                        <div class="accordion-body text-start">
                                            Ustawienia kontent
                                        </div>
                                    </div>
                                </div>

                                <!-- Statistics tab  -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingStatisticsTab">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStatisticsTab" aria-expanded="true" aria-controls="collapseStatisticsTab">
                                            <strong>Statystyki</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseStatisticsTab" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingStatisticsTab" data-bs-parent="#accordionNestleGameTabs">
                                        <div class="accordion-body text-start">
                                            Statystyki kontent
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
