    <nav class="p-2 ps-3 mb-1
                navbar navbar-expand-md navbar-light
                border border-2 border-top-0 border-success
                bg-gradient-to-right"
         style="border-bottom-left-radius: 15px;
                border-bottom-right-radius: 15px;">

        <a class="navbar-brand ms-2 fs-2" href="{{ route('home') }}">Snake</a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#toggleMobileMenu"
            aria-controls="toggleMobileMenu"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="toggleMobileMenu">
            <ul class="navbar-nav text-center ms-auto fs-4">

                <!-- Zakładki administratora -->
                <div class="dropdown me-3 mb-1">
                    <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButtonAdmin" data-bs-toggle="dropdown" aria-expanded="false">
                        Administrator
                    </button>
                    <ul class="dropdown-menu text-center bg-bright " aria-labelledby="dropdownMenuButtonAdmin">
                        <li>
                            <a class="nav-link fw-bold bg-dropdown-btn-user color-black pe-3" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people me-1"></i>Użytkownicy
                            </a>

                            <a class="nav-link fw-bold bg-dropdown-btn-user color-black pe-3" href="{{ route('admin.visitors.index') }}">
                                <i class="bi bi-broadcast-pin me-1"></i>Odwiedzający
                            </a>

                            <a class="nav-link fw-bold bg-dropdown-btn-user color-black pe-3" href="{{ route('admin.messages.index') }}">
                                <i class="bi bi-envelope me-1"></i>Wiadomości
                            </a>

                            <a class="nav-link fw-bold bg-dropdown-btn-user color-black pe-3" href="{{ route('admin.app-logs.index') }}">
                                <i class="bi bi-text-left me-1"></i>Logi aplikacji
                            </a>

                            <a class="nav-link fw-bold bg-dropdown-btn-user color-black pe-3" href="{{ route('admin.server-logs.index') }}">
                                <i class="bi bi-hdd-rack me-1"></i>Logi serwera
                            </a>

                            <a class="nav-link fw-bold bg-dropdown-btn-user color-black pe-3" href="{{ route('admin.artisan-tools.index') }}">
                                <i class="bi bi-wrench me-1"></i>Narzędzia
                            </a>

                            <a class="nav-link fw-bold bg-dropdown-btn-user color-black pe-3" href="{{ route('admin.php-info.index') }}">
                                <i class="bi bi-gear-wide-connected me-1"></i>PHP Info
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Zakładki użytkownika -->
                <div class="dropdown me-3 mb-1">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonUser" data-bs-toggle="dropdown" aria-expanded="false">
                        Użytkownik
                    </button>
                    <ul class="dropdown-menu text-center bg-bright " aria-labelledby="dropdownMenuButtonUser">
                        <li>
                            <a class="nav-link fw-bold bg-dropdown-btn-user color-black pe-3" href="{{ route('help.index') }}">
                                <i class="bi bi-info-circle me-1"></i>Pomoc
                            </a>
                        </li>

                        <li>
                            <a class="nav-link fw-bold bg-dropdown-btn-user color-black pe-3" href="{{ route('download') }}">
                                <i class="bi bi-download me-1"></i>Pobierz grę
                            </a>
                        </li>

                        <li>
                            <a class="nav-link mb-1 fw-bold bg-dropdown-btn-user color-black pe-3" href="{{ route('ranking.index') }}">
                                <i class="bi bi-people me-1"></i>Ranking
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Profil d-md-none -->
                <li class="d-md-none">
                    <a class="nav-link me-3 mb-1" href="{{ route('profile', Auth::user()->name) }}">Profil</a>
                </li>

                <!-- Ustawienia d-md-none -->
                <li class="d-md-none">
                    <a class="nav-link me-3 mb-1" href="{{ route('options.index') }}">Ustawienia</a>
                </li>

                <!-- Wyloguj d-md-none -->
                <li class="d-md-none">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm
                                    mt-md-2
                                    ms-md-2
                                    me-md-2 me-sm-2 me-3
                                    border border-2 border-success
                                    border-radius-25 bg-lightblue" type="submit">
                        Wyloguj</button>
                    </form>
                </li>

                <!-- Nazwa użytkownika oraz awatar na większych ekranach -->
                <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle color-user mt-1 p-0" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <strong class="text-danger">{{ Auth::user()->name }}</strong> <img alt="Awatar użytkownika" style="height:50px; width: 50px; border-radius: 50%;"
                                class="border border-2 border-dark" id="user_avatar" src="{{ asset(Auth::user()->avatar) }}">
                            </a>
                            <ul class="dropdown-menu bg-bright" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item bg-dropdown-btn-user color-black" href="{{ route('profile', Auth::user()->name) }}"><i class="bi bi-person-circle me-1"></i>Profil</a></li>
                                <li><a class="dropdown-item bg-dropdown-btn-user color-black" href="{{ route('options.index') }}"><i class="bi bi-gear me-1"></i>Ustawienia</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" }}>
                                        @csrf
                                        <button type="submit" class="dropdown-item bg-dropdown-btn-user color-black" ><i class="bi bi-box-arrow-right me-1"></i>Wyloguj</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </ul>
        </div>

    </nav>
