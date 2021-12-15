<style>
    .envelope-icon {
        color: black !important;
    }
    .envelope-icon:hover {
        color: rgb(82, 82, 82) !important;
    }

    .linkedin {
        color: #0e76a8 !important;
    }
    .linkedin:hover {
        color: rgb(29, 164, 227) !important;
    }

    .github {
        color: #333 !important;
    }
    .github:hover {
        color: rgb(81, 73, 73) !important;
    }
</style>

<footer class="footer mt-auto py-3
               border-top border-2 border-success
               navbar-fixed-bottom"
        style="background-color: rgb(230, 230, 205);">
    <div class="container text-center">
        <div class="text-muted col-12">

            <a class="link-none envelope-icon" href="mailto:iwaniukmaciej.kontakt@gmail.com">
                <i class="bi bi-envelope me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="iwaniukmaciej.kontakt@gmail.com"></i>
            </a>

            <a class="link-none me-1 linkedin" href="https://www.linkedin.com/in/maciej-iwaniuk-478505213/" target="_blank">
                <i class="bi bi-linkedin"></i>
            </a>

            <a class="link-none me-1 github" href="https://github.com/macieeek" target="_blank">
                <i class="bi bi-github"></i>
            </a>

            <span>Maciej Iwaniuk - 2021 © Wszelkie prawa zastrzeżone</span>

            <div class="d-none d-md-inline">|</div>
            <div class="d-inline d-md-none"><br></div>

            <a href="{{ route('message.show', ['selected' => 'kontakt']) }}" class="link-grey">Kontakt</a> |
            <a href="{{ route('message.show', ['selected' => 'blad-strona']) }}" class="link-grey">Zgłoś błąd</a>

        </div>

    </div>
</footer>
