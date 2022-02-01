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
                            Aby pobrać grę należy kliknąć w wybrany przycisk <strong>Pobierz</strong> a następnie poczekać na zakończenie pobierania. Po pomyślnym pobraniu
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

                <!-- all game info -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingGameTab">
                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGameTab" aria-expanded="false" aria-controls="collapseGameTab">
                            <strong>Wszystko o grze</strong>
                        </button>
                    </h2>
                    <div id="collapseGameTab" class="bg-accordion-body accordion-collapse @if(isset($selected) && $selected=="zakladka-o-grze") collapse show @else collapse @endif" aria-labelledby="headingGameTab" data-bs-parent="#helpAccordion">
                        <div class="accordion-body text-start">

                            Jest to gra 'w węża', która została zmodyfikowana o wiele dodatków takich jak różne skórki do węży, wiele owoców do wyboru, rozmaite kolory plansz, czy
                            nawet ranking graczy. Gracz odblokowuje różne rodzaje poziomów trudności gry, bije rekordy równocześnie
                            zdobywając punkty oraz monety, które może wydać na przykład na skórki do węży, lub na ulepszenia, które pozwolą szybciej się rozwijać. Niezbędne jest połączenie
                            z internetem, ponieważ gra na bieżąco aktualizuje dane.<br> <br>

                            <!-- nestle accordion with tabs -->
                            <div class="accordion" id="accordionNestleGameTabs" style="font-weight: 500;">

                                <!-- Login panel tab -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingLoginPanel">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLoginPanel" aria-expanded="true" aria-controls="collapseLoginPanel">
                                            <strong>Panel logowania</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseLoginPanel" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingLoginPanel" data-bs-parent="#accordionNestleGameTabs">
                                        <div class="accordion-body text-start">
                                            Aby zalogować się do gry należy użyć danych z konta utworzonego na stronie.
                                        </div>
                                    </div>
                                </div>

                                <!-- Gameplay presentation tab -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingPlayPresentationTab">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlayPresentationTab" aria-expanded="true" aria-controls="collapsePlayPresentationTab">
                                            <strong>Prezentacja rozgrywki</strong>
                                        </button>
                                    </h2>
                                    <div id="collapsePlayPresentationTab" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingPlayPresentationTab" data-bs-parent="#accordionNestleGameTabs">
                                        <div class="accordion-body text-start">
                                            <a class="link-blue" href="https://youtu.be/3N2n-qiO-jQ" target="_blank">Link do prezentacji rozgrywki na YouTube</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gameplay tab -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingPlayTab">
                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlayTab" aria-expanded="true" aria-controls="collapsePlayTab">
                                            <strong>Rozgrywka</strong>
                                        </button>
                                    </h2>
                                    <div id="collapsePlayTab" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingPlayTab" data-bs-parent="#accordionNestleGameTabs">
                                        <div class="accordion-body text-start">
                                            Rozgrywka polega na zjadaniu pojawiających się owoców, równocześnie uważając aby nie uderzyć głową w inną część węża oraz w ściankę planszy. Grając
                                            zdobywasz punkty, monety oraz aktualizujesz informację o swoich aktualnych rekordach na poszczególnych poziomach trudności, które możesz porównywać
                                            z innymi graczami w zakładce <a class="link-blue" href="{{ route('ranking.index') }}">Ranking</a>.
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
                                            W grze dostępne są cztery poziomy trudności, które różnią się od siebie szybkością poruszania się węża oraz ilością otrzymywanych monet oraz punktów
                                            za zjedzony owoc.

                                            <!-- nestle accordion with diffulcty lvls tabs -->
                                            <div class="accordion mt-2" id="accordionNestleDifficultyLvls">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingEasyDifficultyLvl">
                                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            <strong>Easy (Łatwy)</strong>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingEasyDifficultyLvl" data-bs-parent="#accordionNestleDifficultyLvls">
                                                        <div class="accordion-body text-start">
                                                            Jak odblokować: odblokowany od samego początku <hr>
                                                            Prędkość poruszania się węża: wolna <hr>
                                                            Początkowa ilość otrzymywanych monet za zjedzony owoc: 1 <hr>
                                                            Początkowa ilość otrzymywanych punktów za zjedzony owoc: 10 <hr>
                                                            Zwiększanie ilości otrzymywanych monet za każdy kolejny zjedzony owoc wraz ze wzrostem wyniku: co 20 zjedzonych owoców o 1 monetę <hr>
                                                            Zwiększanie ilości otrzymywanych punktów za każdy kolejny zjedzony owoc wraz ze wrostem wyniku: co 20 zjedzonych owoców o 10 punktów <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingMediumDifficultyLvl">
                                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            <strong>Medum (Średni)</strong>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingMediumDifficultyLvl" data-bs-parent="#accordionNestleDifficultyLvls">
                                                        <div class="accordion-body text-start">
                                                            Jak odblokować: należy zjeść 50 owoców w ciągu jednej rozgrywki na poziomie trudności Easy (Łatwy) <hr>
                                                            Prędkość poruszania się węża: średnia <hr>
                                                            Początkowa ilość otrzymywanych monet za zjedzony owoc: 3 <hr>
                                                            Początkowa ilość otrzymywanych punktów za zjedzony owoc: 30 <hr>
                                                            Zwiększanie ilości otrzymywanych monet za każdy kolejny zjedzony owoc wraz ze wzrostem wyniku: co 15 zjedzonych owoców o 1 monetę <hr>
                                                            Zwiększanie ilości otrzymywanych punktów za każdy kolejny zjedzony owoc wraz ze wrostem wyniku: co 15 zjedzonych owoców o 10 punktów <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingHardDifficultyLvl">
                                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            <strong>Hard (Trudny)</strong>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingHardDifficultyLvl" data-bs-parent="#accordionNestleDifficultyLvls">
                                                        <div class="accordion-body text-start">
                                                            Jak odblokować: należy zjeść 50 owoców w ciągu jednej rozgrywki na poziomie trudności Medium (Średni) <hr>
                                                            Prędkość poruszania się węża: szybka <hr>
                                                            Początkowa ilość otrzymywanych monet za zjedzony owoc: 5 <hr>
                                                            Początkowa ilość otrzymywanych punktów za zjedzony owoc: 50 <hr>
                                                            Zwiększanie ilości otrzymywanych monet za każdy kolejny zjedzony owoc wraz ze wzrostem wyniku: co 10 zjedzonych owoców o 1 monetę <hr>
                                                            Zwiększanie ilości otrzymywanych punktów za każdy kolejny zjedzony owoc wraz ze wrostem wyniku: co 10 zjedzonych owoców o 10 punktów <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSpeedDifficultyLvl">
                                                        <button class="accordion-button collapsed bg-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                            <strong>Speed (Trudność zależna od wielkości węża)</strong>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFour" class="bg-accordion-body accordion-collapse collapse" aria-labelledby="headingSpeedDifficultyLvl" data-bs-parent="#accordionNestleDifficultyLvls">
                                                        <div class="accordion-body text-start">
                                                            Jak odblokować: do kupienia w zakładce Ulepszenia za 1000 monet <hr>
                                                            Prędkość poruszania się węża: na początku wolna, im wąż jest większy tym szybszy... <hr>
                                                            Początkowa ilość otrzymywanych monet za zjedzony owoc: 1 <hr>
                                                            Początkowa ilość otrzymywanych punktów za zjedzony owoc: 10 <hr>
                                                            Zwiększanie ilości otrzymywanych monet za każdy kolejny zjedzony owoc wraz ze wzrostem wyniku: co 15 zjedzonych owoców o 1 monetę, lecz zwiększa się to dynamicznie wraz ze wzrostem wyniku <hr>
                                                            Zwiększanie ilości otrzymywanych punktów za każdy kolejny zjedzony owoc wraz ze wrostem wyniku: co 15 zjedzonych owoców o 10 punktów, lecz zwiększa się to dynamicznie wraz ze wzrostem wyniku <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
                                            W sklepie możesz wydawać zarobione monety na skórki do węży, owoce oraz plansze. Gdy posiadasz wystarczającą ilość waluty aby kupić dany przedmiot,
                                            po kliknięciu <strong>Kup</strong> trafia on do <strong>Ekwipunku</strong>.
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
                                            W ekwipunku możesz zmieniać swoje przedmioty kupione w sklepie.
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
                                            Ulepszenia kupuje się za zdobyte monety. Ulepszenia pozwolą Ci szybciej zdobywać punkty, monety oraz poprzez większą ilość owoców na planszy gra stanie się
                                            bardziej dynamiczna. <hr>
                                            Ulepszenie: Ilość owoców na planszy <br>
                                            Ilość ulepszeń do kupienia: 2 <br>
                                            Koszt ulepszenia: 500$/5000$ <hr>

                                            Ulepszenie: Dodatkowe monety (ilość dodatkowych monet za zjedzony owoc) <br>
                                            Ilość ulepszeń do kupienia: 3 <br>
                                            Koszt ulepszenia: 500$/2500$/5000$ <hr>

                                            Ulepszenie: Dodatkowe punkty (ilość dodatkowych punktów za zjedzony owoc) <br>
                                            Ilość ulepszeń do kupienia: 3 <br>
                                            Koszt ulepszenia: 500$/2500$/5000$ <hr>
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
                                            Ustawienia umożliwiają wybranie komfortowej głośności dźwięku, włączenie/wyłączenie efektów, włączenie/wyłączenie muzyki oraz ustawienie
                                            szybkości odświeżania ekranu (30/60/144/240 klatek na sekundę). Im wyższa wartość tym komputer jest bardziej obciążony. Na słabszych urządzeniach
                                            zaleca się mniejsze wartości.
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
                                            W zakładce <strong>Statystyki</strong> są widoczne informacje na temat rozgrywki.
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
