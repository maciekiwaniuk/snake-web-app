    <nav class="p-2 ps-3 mb-1
                navbar navbar-expand-lg navbar-light
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

                <li>
                    <a class="nav-link me-3" href="{{ route('help.index') }}"><i class="bi bi-info-circle"></i> Pomoc</a>
                </li>

                <li>
                    <a class="nav-link me-3" href="{{ route('mini-game') }}"><i class="bi bi-controller"></i> Mini gra</a>
                </li>

                <li>
                    <a class="nav-link me-3" href="{{ route('download') }}"><i class="bi bi-download"></i> Pobierz grę</a>
                </li>

                <li>
                    <a class="nav-link me-3 mb-1" href="{{ route('ranking.index') }}"><i class="bi bi-trophy"></i> Ranking</a>
                </li>

                <!-- Profile d-lg-none -->
                <li class="d-lg-none">
                    <a class="nav-link me-3 mb-1" href="{{ route('profile', Auth::user()->name) }}"><i class="bi bi-person-circle"></i> Profil</a>
                </li>

                <!-- Options d-lg-none -->
                <li class="d-lg-none">
                    <a class="nav-link me-3 mb-1" href="{{ route('options.index') }}"><i class="bi bi-gear"></i> Ustawienia</a>
                </li>

                <!-- Logout d-lg-none -->
                <li class="d-lg-none">
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

                <!-- Username and avatar on bigger screens -->
                <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle color-user mt-1 p-0" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <strong>{{ Auth::user()->name }}</strong> <img alt="Awatar użytkownika" style="height:50px; width: 50px; border-radius: 50%;"
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
