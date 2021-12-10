
    <!-- Message form modal -->
    <div class="modal fade" id="messageFormModal" tabindex="-1" aria-labelledby="messageFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light">
                <form method="POST" action="{{ route('message.index') }}" class="row g-3">
                    @csrf
                    <h4 class="text-center">Wyślij wiadomość</h4>

                    <div class="col-12">
                        <label for="subject">Temat</label>
                        <select name="subject" class="form-control">
                            <option value="contact" class="form-control" selected>Kontakt</option>
                            <option value="error-website" class="form-control">Błąd na stronie</option>
                            <option value="error-game" class="form-control">Błąd w grze</option>
                            <option value="idea-website" class="form-control">Pomysł dotyczący strony</option>
                            <option value="idea-game" class="form-control">Pomysł dotyczący gry</option>
                            <option value="other" class="form-control">Inne</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="sender">Od kogo</label>
                        <input type="text" name="sender" class="form-control" value="@if(Auth::check()){{ Auth::user()->name }}@endif" required>
                    </div>

                    <div class="col-12">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" class="form-control" value="@if(Auth::check()){{ Auth::user()->email }}@endif" required>
                    </div>

                    <div class="col-12">
                        <label for="content">Treść wiadomości</label>
                        <textarea name="content" class="form-control" rows="5" required></textarea>
                    </div>

                    @if(env('CAPTCHA_VALIDATION_ENABLED'))
                        <div class="col-12 text-center">
                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_PUBLIC_KEY') }}"></div>
                        </div>
                    @endif
            </div>

            <div class="modal-footer d-flex justify-content-around bg-light">
                <button type="submit" class="btn btn-success">Wyślij</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                </form>
            </div>
        </div>
        </div>
    </div>

    <!-- Send message fixed left down corner div -->
    <div class="message-div d-none d-xxl-block">
        <div class="message-close">
            <i class="bi bi-x-lg"></i>
        </div>

        <div id="message-content">
            <div class="message-text" data-bs-toggle="modal" data-bs-target="#messageFormModal">Chcesz o coś zapytać?</div>
            <div class="message-icon" data-bs-toggle="modal" data-bs-target="#messageFormModal">
                <i class="bi bi-envelope"></i>
            </div>
        </div>
    </div>
