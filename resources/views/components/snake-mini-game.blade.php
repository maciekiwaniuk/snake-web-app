<script>
    const BACKGROUND_PURPLE_URL = "{{ asset('assets/images/snake_mini_game/board_background_purple.png') }}";
    const BACKGROUND_GREEN_URL = "{{ asset('assets/images/snake_mini_game/board_background_green.png') }}";
    const BACKGROUND_BROWN_URL = "{{ asset('assets/images/snake_mini_game/board_background_brown.png') }}";
</script>

<!-- SCORE BAR -->
<div class="snake-game-score">
    <div class="game-score
                border border-2 border-success d-flex justify-content-around">
        <div id="score-record-div">
            Rekordowy wynik: <span id="score-record"></span>
        </div>

        <div id="score-div">
            Aktualny wynik: <span id="score"></span>
        </div>

        <div id="options-div">
            Ustawienia gry <i class="bi bi-gear-fill"></i>
        </div>
    </div>
</div>
<!-- END SCORE BAR -->

<!-- OPTIONS CONTENT -->
<div class="snake-game-options">
    <div id="options-content" class="border border-top-0 border-1 border-success bg-light d-block" style="height: 0vmin;">
        <div id="all-options-divs" style="display: none;">
            <div class="d-block snake-speed-option-padding"></div>

            <!-- SNAKE SPEED -->
            <div class="snake-speed-option">
                <div class="btn-group col-10 mx-auto d-flex" role="group" aria-label="snakeSpeedButtonGroup">
                    <strong class="me-2 fs-4">Prędkość węża</strong>

                    <input type="radio" id="slowSnakeSpeedRadio" class="btn-check" name="snakeSpeedRadio" autocomplete="off">
                    <label id="slowSnakeSpeedButton" class="btn btn-outline-dark rounded-start" for="slowSnakeSpeedRadio">
                        <strong class="text-primary">Wolna</strong>
                    </label>

                    <input type="radio" id="mediumSnakeSpeedRadio" class="btn-check" name="snakeSpeedRadio" autocomplete="off">
                    <label id="mediumSnakeSpeedButton" class="btn btn-outline-dark" for="mediumSnakeSpeedRadio">
                        <strong class="text-success">Średnia</strong>
                    </label>

                    <input type="radio" id="fastSnakeSpeedRadio" class="btn-check" name="snakeSpeedRadio" autocomplete="off">
                    <label id="fastSnakeSpeedButton" class="btn btn-outline-dark rounded-end" for="fastSnakeSpeedRadio">
                        <strong class="text-danger">Szybka</strong>
                    </label>
                </div>
            </div>
            <!-- END SNAKE SPEED -->

            <!-- BOARD APPEARANCE -->
            <div class="snake-speed-option">
                <div class="btn-group col-10 mx-auto d-flex" role="group" aria-label="boardAppearanceButtonGroup">
                    <strong class="me-2 fs-4">Kolor planszy</strong>

                    <input type="radio" id="purpleBoardAppearanceRadio" class="btn-check" name="boardAppearanceRadio" autocomplete="off">
                    <label id="purpleBoardAppearanceButton" class="btn btn-outline-dark rounded-start" for="purpleBoardAppearanceRadio">
                        <strong class="color-purple">Fioletowy</strong>
                    </label>

                    <input type="radio" id="greenBoardAppearanceRadio" class="btn-check" name="boardAppearanceRadio" autocomplete="off">
                    <label id="greenBoardAppearanceButton" class="btn btn-outline-dark" for="greenBoardAppearanceRadio">
                        <strong class="text-success">Zielony</strong>
                    </label>

                    <input type="radio" id="brownBoardAppearanceRadio" class="btn-check" name="boardAppearanceRadio" autocomplete="off">
                    <label id="brownBoardAppearanceButton" class="btn btn-outline-dark rounded-end" for="brownBoardAppearanceRadio">
                        <strong class="color-bronze">Brązowy</strong>
                    </label>
                </div>
            </div>
            <!-- END BOARD APPEARANCE -->

            <!-- SNAKE APPEARANCE -->
            <div class="snake-speed-option">
                <div class="btn-group col-10 mx-auto d-flex" role="group" aria-label="snakeAppearanceButtonGroup">
                    <strong class="me-2 fs-4">Kolor węża</strong>

                    <input type="radio" id="blueSnakeAppearanceRadio" class="btn-check" name="snakeAppearanceRadio" autocomplete="off">
                    <label id="blueSnakeAppearanceButton" class="btn btn-outline-dark rounded-start" for="blueSnakeAppearanceRadio">
                        <strong class="text-primary">Niebieski</strong>
                    </label>

                    <input type="radio" id="whiteSnakeAppearanceRadio" class="btn-check" name="snakeAppearanceRadio" autocomplete="off">
                    <label id="whiteSnakeAppearanceButton" class="btn btn-outline-dark" for="whiteSnakeAppearanceRadio">
                        <strong class="color-grey">Biały</strong>
                    </label>

                    <input type="radio" id="orangeSnakeAppearanceRadio" class="btn-check" name="snakeAppearanceRadio" autocomplete="off">
                    <label id="orangeSnakeAppearanceButton" class="btn btn-outline-dark rounded-end" for="orangeSnakeAppearanceRadio">
                        <strong class="color-orange">Pomarańczowy</strong>
                    </label>
                </div>
            </div>
            <!-- END SNAKE APPEARANCE -->

            <div class="d-block snake-speed-option-padding"></div>
        </div>
    </div>
</div>
<!-- END OPTIONS CONTENT -->

<!-- GAME CONTENT -->
<div class="snake-game-content mb-1">
    <div class="snake-game-background">
        <img id="background-image" class="w-100">
    </div>

    <div id="game-board" class="border border-top-0 border-2 border-success"></div>
</div>
<!-- END GAME CONTENT -->

<!-- MOVE BUTTONS -->
<div class="snake-game-buttons">
    <div class="buttons-content mb-5">
        <div class="row mx-1">
            <button id="move-up-button" class="col-12 btn btn-success border border-1 border-light">
                <i class="bi bi-arrow-up-circle"></i>
            </button>
        </div>


        <div class="row mx-1">
            <button id="move-left-button" class="col-6 btn btn-success border border-1 border-light">
                <i class="bi bi-arrow-left-circle"></i>
            </button>

            <button id="move-right-button" class="col-6 btn btn-success border border-1 border-light">
                <i class="bi bi-arrow-right-circle"></i>
            </button>
        </div>

        <div class="row mx-1">
            <button id="move-down-button" class="col-12 btn btn-success border border-1 border-light">
                <i class="bi bi-arrow-down-circle"></i>
            </button>
        </div>

    </div>
</div>
<!-- END MOVE BUTTONS -->
