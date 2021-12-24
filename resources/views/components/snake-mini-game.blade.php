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

<div class="snake-game-content">
    <div class="snake-game-background">
        <img class="w-100" src="{{ asset('assets/images/snake_mini_game/board_background_purple.png') }}">
    </div>

    <div id="game-board" class="border border-top-0 border-2 border-success"></div>
</div>
