<script>
    const BACKGROUND_PURPLE_URL = "{{ asset('assets/images/snake_mini_game/board_background_purple.png') }}";
    const BACKGROUND_GREEN_URL = "{{ asset('assets/images/snake_mini_game/board_background_green.png') }}";
    const BACKGROUND_BROWN_URL = "{{ asset('assets/images/snake_mini_game/board_background_brown.png') }}";

    let backgroundImageTag = document.getElementById('background-image');

    if (Cookies.get('snake-mini-game') == null) {
        let data = {
            scoreRecord: 0,
            selectedSnakeSpeed: 'slow',
            selectedBoard: 'purple',
            selectedSnake: 'blue',
            selectedFood: 'yellow'
        };
        Cookies.set('snake-mini-game', JSON.stringify(data), { expires: 365 });
    }
    let cookieData = Cookies.get('snake-mini-game');

    switch (cookieData.selectedBoard) {
        case 'purple': {
            backgroundImageTag.src = BACKGROUND_PURPLE_URL;
        } break;

        case 'green': {
            backgroundImageTag.src = BACKGROUND_GREEN_URL;
        } break;

        case 'brown': {
            backgroundImageTag.src = BACKGROUND_BROWN_URL;
        } break;
    }

</script>

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

<div class="snake-game-options">
    <div id="options-content" class="border border-top-0 border-1 border-success d-block" style="height: 0vmin;">

    </div>
</div>

<div class="snake-game-content mb-1">
    <div class="snake-game-background">
        <img id="background-image" class="w-100">
    </div>

    <div id="game-board" class="border border-top-0 border-2 border-success"></div>
</div>

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
