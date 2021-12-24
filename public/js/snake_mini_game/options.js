export function toogleOptionsMenu() {
    const optionsDiv = document.getElementById('options-content');

    if (optionsDiv.style.height == '0vmin') {
        optionsDiv.style.height = '50vmin';
    } else if (optionsDiv.style.height == '50vmin') {
        optionsDiv.style.height = '0vmin';
    }

}

export function createCookieWithDataIfNotExists() {
    if (Cookies.get('snake-mini-game') == null) {
        createDefaultCookieData();
    }
}

export function getSnakeSpeed() {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));

    switch (data.selectedSnakeSpeed) {
        case 'slow': {
            return 5;
        } break;

        case 'medium': {
            return 8;
        } break;

        case 'fast': {
            return 11;
        } break;
    }
}

export function updateSelectedBoardAppearance(gameBoard) {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));
    let backgroundImageTag = document.getElementById('background-image');

    switch (data.selectedBoard) {
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
}

export function getSnakeSegmentWithSelectedSnakeAppearance(snakeElement) {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));

    switch (data.selectedSnake) {
        case 'blue': {
            snakeElement.classList.add('snake-blue-background');
        }
    }
    return snakeElement;
}

export function getFoodBodyWithSelectedFoodAppearance(foodBody) {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));

    switch (data.selectedFood) {
        case 'yellow': {
            foodBody.classList.add('food-yellow');
        }
    }
    return foodBody;
}

export function createDefaultCookieData() {
    let data = {
        scoreRecord: 0,
        selectedSnakeSpeed: 'slow',
        selectedBoard: 'purple',
        selectedSnake: 'blue',
        selectedFood: 'yellow'
    };
    Cookies.set('snake-mini-game', JSON.stringify(data), { expires: 365 });
}

