    <nav class="p-2 ps-3 mb-3
                navbar navbar-expand-md navbar-light
                border border-2 border-top-0 border-success"
            style="border-bottom-left-radius: 15px;
                border-bottom-right-radius: 15px;
                background-image: linear-gradient(to right, rgb(183, 255, 0), rgb(18, 255, 18));">

        <a class="navbar-brand ms-2 fs-2" href="{{ route('home') }}">Snake</a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#toggleMobileMenu"
            aria-controls="toggleMobileMenu"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="toggleMobileMenu">
            <ul class="navbar-nav text-center ms-auto fs-4">
                <li>
                    <a class="nav-link me-3" href="{{ route('login') }}">Pobierz grę</a>
                </li>

                <li>
                    <a class="nav-link me-3" href="{{ route('log') }}">Logowanie</a>
                </li>

                <li>
                    <a class="nav-link me-3" href="{{ route('register') }}">Rejestracja</a>
                </li>
            </ul>
        </div>

    </nav>
