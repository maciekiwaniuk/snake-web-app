<footer class="footer mt-auto py-3
               border-top border-2 border-success
               navbar-fixed-bottom"
        style="background-color: rgb(230, 230, 205);">
    <div class="container text-center">
        <div class="text-muted col-12">

            <a class="link-none" href="mailto:iwaniukmaciej.kontakt@gmail.com">
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
            <a href="{{ route('message.show', ['selected' => 'usterka']) }}" class="link-grey">Zgłoś usterkę</a>

        </div>

    </div>
</footer>
