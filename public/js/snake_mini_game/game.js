import { update as updateSnake,
         draw as drawSnake,
         getSnakeHeadPosition,
         snakeHitBody,
         resetSnakePosition } from './snake.js';

import { update as updateFood,
         draw as drawFood } from './food.js';

import { outsideGrid as snakeHitWall } from './grid.js';

import { toogleOptionsMenu,
         getSnakeSpeed,
         updateSelectedBoardAppearance } from './options.js';

import { resetInputDirection } from './input.js';

const gameBoard = document.getElementById('game-board');
const optionsButton = document.getElementById('options-div');
const moveUpButton = document.getElementById('move-up-button');
const moveDownButton = document.getElementById('move-down-button');
const moveLeftButton = document.getElementById('move-left-button');
const moveRightButton = document.getElementById('move-right-button');

let SNAKE_SPEED = getSnakeSpeed();
let lastRenderTime = 0;
let gameStarted = false;

let keysThatMayMoveScrollbar = [
    'ArrowUp', 'ArrowDown',
    'ArrowLeft', 'ArrowRight',
    'Space'
];

let keysThatMoveSnake = [
    'ArrowUp', 'ArrowDown',
    'ArrowLeft', 'ArrowRight',
    'KeyW', 'KeyS',
    'KeyA', 'KeyD'
];

window.addEventListener('keydown', event => {
    // prevent to move website while clicking arrow or space
    if(keysThatMayMoveScrollbar.includes(event.code)) {
        event.preventDefault();
    }

    // start game
    if (keysThatMoveSnake.includes(event.code)) {
        gameStarted = true;
    }
}, false);

// simulate move snake keys while clicking move buttons
moveUpButton.addEventListener('click', function() {
    window.dispatchEvent(new KeyboardEvent('keydown', {
        code: 'ArrowUp'
    }));
});
moveLeftButton.addEventListener('click', function() {
    window.dispatchEvent(new KeyboardEvent('keydown', {
        code: 'ArrowLeft'
    }));
});
moveRightButton.addEventListener('click', function() {
    window.dispatchEvent(new KeyboardEvent('keydown', {
        code: 'ArrowRight'
    }));
});
moveDownButton.addEventListener('click', function() {
    window.dispatchEvent(new KeyboardEvent('keydown', {
        code: 'ArrowDown'
    }));
});

// toogle options menu
optionsButton.addEventListener('click', function() {
    toogleOptionsMenu();
});

// main loop function
function main(currentTime) {
    window.requestAnimationFrame(main);

    const secondsSinceLastRender = (currentTime - lastRenderTime) / 1000;
    if (secondsSinceLastRender < 1 / SNAKE_SPEED) return;

    lastRenderTime = currentTime;

    if (gameStarted) {
        update();
    }
    draw();

}

// start animation loop function
window.requestAnimationFrame(main);

function update() {
    updateSnake();
    updateFood();
    checkSnakeFail();
}

function draw() {
    gameBoard.innerHTML = '';
    drawSnake(gameBoard);
    drawFood(gameBoard);
    updateSelectedBoardAppearance(gameBoard);
}

function checkSnakeFail() {
    if (snakeHitWall(getSnakeHeadPosition()) || snakeHitBody()) {
        gameStarted = false;
        resetSnakePosition();
        resetInputDirection();
    }
}


