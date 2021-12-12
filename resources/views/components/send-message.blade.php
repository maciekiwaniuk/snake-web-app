
    <!-- Message form modal -->
    <div class="modal fade" id="messageFormModal" tabindex="-1" aria-labelledby="messageFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <button type="button" class="btn-close" id="close-message-form-button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                        <h4 class="text-center">Wyślij wiadomość</h4>

                        <div class="col-12 mt-4">
                            <label for="subject">Temat</label>
                            <select name="subject" id="subject" class="form-control">
                                <option value="contact" class="form-control" selected>Kontakt</option>
                                <option value="error-website" class="form-control">Błąd na stronie</option>
                                <option value="error-game" class="form-control">Błąd w grze</option>
                                <option value="idea-website" class="form-control">Pomysł dotyczący strony</option>
                                <option value="idea-game" class="form-control">Pomysł dotyczący gry</option>
                                <option value="other" class="form-control">Inne</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="sender">Twoja nazwa</label>
                            <input type="text" name="sender" id="sender" class="form-control" value="@if(Auth::check()){{ Auth::user()->name }}@endif" required>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="email">Twój e-mail</label>
                            <input type="text" name="email" id="email" class="form-control" value="@if(Auth::check()){{ Auth::user()->email }}@endif" required>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="content">Treść wiadomości</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                        </div>

                        @if(env('CAPTCHA_VALIDATION_ENABLED'))
                            <div class="col-12 mt-3 text-center">
                                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_PUBLIC_KEY') }}"></div>
                            </div>
                        @endif
                </div>

                <div class="modal-footer d-flex justify-content-around bg-light">
                    <button id="send-message-button" class="btn btn-success">Wyślij</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Send message fixed left down corner div -->
    <div id="main-message-div" class="d-none">
        <div id="close-send-message-icon">
            <i class="message-close bi bi-x-lg"></i>
        </div>

        <span class="message-text" data-bs-toggle="modal" data-bs-target="#messageFormModal">
            Chcesz o coś zapytać?
        </span>
        <div class="message-icon" data-bs-toggle="modal" data-bs-target="#messageFormModal">
            <i class="bi bi-envelope"></i>
        </div>
    </div>

    <!-- Envelope icon div when user close above div -->
    <div id="after-message-div-close" class="d-none">
        <div class="closed-message-div-icon">
            <i class="bi bi-envelope" data-bs-toggle="modal" data-bs-target="#messageFormModal"></i>
        </div>
    </div>
