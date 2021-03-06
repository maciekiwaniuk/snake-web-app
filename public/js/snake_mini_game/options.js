const optionsButton = document.querySelector('#options-div');

// speed
const slowSnakeSpeedButton = document.querySelector('#slowSnakeSpeedButton');
const mediumSnakeSpeedButton = document.querySelector('#mediumSnakeSpeedButton');
const fastSnakeSpeedButton = document.querySelector('#fastSnakeSpeedButton');

const slowSnakeSpeedRadio = document.querySelector('#slowSnakeSpeedRadio');
const mediumSnakeSpeedRadio = document.querySelector('#mediumSnakeSpeedRadio');
const fastSnakeSpeedRadio = document.querySelector('#fastSnakeSpeedRadio');

// board appearance
const purpleBoardAppearanceButton = document.querySelector('#purpleBoardAppearanceButton');
const greenBoardAppearanceButton = document.querySelector('#greenBoardAppearanceButton');
const brownBoardAppearanceButton = document.querySelector('#brownBoardAppearanceButton');

const purpleBoardAppearanceRadio = document.querySelector('#purpleBoardAppearanceRadio');
const greenBoardAppearanceRadio = document.querySelector('#greenBoardAppearanceRadio');
const brownBoardAppearanceRadio = document.querySelector('#brownBoardAppearanceRadio');

// snake appearance
const blueSnakeAppearanceButton = document.querySelector('#blueSnakeAppearanceButton');
const whiteSnakeAppearanceButton = document.querySelector('#whiteSnakeAppearanceButton');
const orangeSnakeAppearanceButton = document.querySelector('#orangeSnakeAppearanceButton');

const blueSnakeAppearanceRadio = document.querySelector('#blueSnakeAppearanceRadio');
const whiteSnakeAppearanceRadio = document.querySelector('#whiteSnakeAppearanceRadio');
const orangeSnakeAppearanceRadio = document.querySelector('#orangeSnakeAppearanceRadio');

// food appearance
const yellowFoodAppearanceButton = document.querySelector('#yellowFoodAppearanceButton');
const redFoodAppearanceButton = document.querySelector('#redFoodAppearanceButton');
const greenFoodAppearanceButton = document.querySelector('#greenFoodAppearanceButton');

const yellowFoodAppearanceRadio = document.querySelector('#yellowFoodAppearanceRadio');
const redFoodAppearanceRadio = document.querySelector('#redFoodAppearanceRadio');
const greenFoodAppearanceRadio = document.querySelector('#greenFoodAppearanceRadio');


setButtonsToCheckedWhichAreSelected();

// toogle options menu
optionsButton.addEventListener('click', function() {
    toogleOptionsMenu();
});

// snake speed buttons
slowSnakeSpeedButton.addEventListener('click', function() {
    changeSnakeSpeed('slow');
    slowSnakeSpeedRadio.checked = true;
});
mediumSnakeSpeedButton.addEventListener('click', function() {
    changeSnakeSpeed('medium');
    mediumSnakeSpeedRadio.checked = true;
});
fastSnakeSpeedButton.addEventListener('click', function() {
    changeSnakeSpeed('fast');
    fastSnakeSpeedRadio.checked = true;
});

// board appearance buttons
purpleBoardAppearanceButton.addEventListener('click', function() {
    changeBoardAppearance('purple');
    purpleBoardAppearanceRadio.checked = true;
});
greenBoardAppearanceButton.addEventListener('click', function() {
    changeBoardAppearance('green');
    greenBoardAppearanceRadio.checked = true;
});
brownBoardAppearanceButton.addEventListener('click', function() {
    changeBoardAppearance('brown');
    brownBoardAppearanceRadio.checked = true;
});

// snake appearance buttons
blueSnakeAppearanceButton.addEventListener('click', function() {
    changeSnakeAppearance('blue');
    blueSnakeAppearanceRadio.checked = true;
});
whiteSnakeAppearanceButton.addEventListener('click', function() {
    changeSnakeAppearance('white');
    whiteSnakeAppearanceRadio.checked = true;
});
orangeSnakeAppearanceButton.addEventListener('click', function() {
    changeSnakeAppearance('orange');
    orangeSnakeAppearanceRadio.checked = true;
});

// food appearance buttons
yellowFoodAppearanceButton.addEventListener('click', function() {
    changeFoodAppearance('yellow');
    yellowFoodAppearanceRadio.checked = true;
});
redFoodAppearanceButton.addEventListener('click', function() {
    changeFoodAppearance('red');
    redFoodAppearanceRadio.checked = true;
});
greenFoodAppearanceButton.addEventListener('click', function() {
    changeFoodAppearance('green');
    greenFoodAppearanceRadio.checked = true;
});


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
            return 6;
        }
        case 'medium': {
            return 9;
        }
        case 'fast': {
            return 12;
        }
    }
}


export function updateSelectedBoardAppearance(gameBoard) {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));
    let backgroundImageTag = document.querySelector('#background-image');

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
        } break;

        case 'white': {
            snakeElement.classList.add('snake-white-background');
        } break;

        case 'orange': {
            snakeElement.classList.add('snake-orange-background');
        } break;
    }
    return snakeElement;
}

export function getFoodBodyWithSelectedFoodAppearance(foodBody) {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));

    switch (data.selectedFood) {
        case 'yellow': {
            foodBody.classList.add('food-yellow');
        } break;

        case 'red': {
            foodBody.classList.add('food-red');
        } break;

        case 'green': {
            foodBody.classList.add('food-green');
        } break;
    }
    return foodBody;
}

export function createDefaultCookieData() {
    let data = {
        scoreRecord: 0,
        selectedSnakeSpeed: 'slow',
        selectedBoard: 'green',
        selectedSnake: 'blue',
        selectedFood: 'yellow'
    };
    Cookies.set('snake-mini-game', JSON.stringify(data), { expires: 365 });
}

function toogleOptionsMenu() {
    const optionsContent = document.querySelector('#options-content');
    const allOptionsDivs = document.querySelector('#all-options-divs');

    if (optionsContent.style.height == '0vmin') {
        optionsContent.style.height = '50vmin';

        setTimeout(function() {
            allOptionsDivs.style.display = 'inline';
        }, 250);

    } else if (optionsContent.style.height == '50vmin') {
        optionsContent.style.height = '0vmin';

        setTimeout(function() {
            allOptionsDivs.style.display = 'none';
        }, 250);
    }

}

function saveCookieData(data) {
    Cookies.set('snake-mini-game', JSON.stringify(data), { expires: 365 });
}

function setButtonsToCheckedWhichAreSelected() {
    createCookieWithDataIfNotExists();
    let data = JSON.parse(Cookies.get('snake-mini-game'));

    if (data.selectedSnakeSpeed == 'slow') {
        slowSnakeSpeedRadio.checked = true;
    } else if (data.selectedSnakeSpeed = 'medium') {
        mediumSnakeSpeedRadio.checked = true;
    } else if (data.selectedSnakeSpeed == 'fast') {
        fastSnakeSpeedRadio.checked = true;
    }

    if (data.selectedBoard == 'purple') {
        purpleBoardAppearanceRadio.checked = true;
    } else if (data.selectedBoard == 'green') {
        greenBoardAppearanceRadio.checked = true;
    } else if (data.selectedBoard == 'brown') {
        brownBoardAppearanceRadio.checked = true;
    }

    if (data.selectedSnake == 'blue') {
        blueSnakeAppearanceRadio.checked = true;
    } else if (data.selectedSnake == 'white') {
        whiteSnakeAppearanceRadio.checked = true;
    } else if (data.selectedSnake == 'orange') {
        orangeSnakeAppearanceRadio.checked = true;
    }

    if (data.selectedFood == 'yellow') {
        yellowFoodAppearanceRadio.checked = true;
    } else if (data.selectedFood == 'red') {
        redFoodAppearanceRadio.checked = true;
    } else if (data.selectedFood == 'green') {
        greenFoodAppearanceRadio.checked = true;
    }
}

function changeSnakeSpeed(newSnakeSpeed) {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));
    data.selectedSnakeSpeed = newSnakeSpeed;
    saveCookieData(data);
}

function changeBoardAppearance(newBoardAppearance) {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));
    data.selectedBoard = newBoardAppearance;
    saveCookieData(data);
}

function changeSnakeAppearance(newSnakeAppearance) {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));
    data.selectedSnake = newSnakeAppearance;
    saveCookieData(data);
}

function changeFoodAppearance(newFoodAppearance) {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));
    data.selectedFood = newFoodAppearance;
    saveCookieData(data);
}
