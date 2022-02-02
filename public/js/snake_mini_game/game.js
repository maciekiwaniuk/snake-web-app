import { update as updateSnake,
         draw as drawSnake,
         getSnakeHeadPosition,
         snakeHitBody,
         resetSnakePosition } from './snake.js';

import { update as updateFood,
         draw as drawFood } from './food.js';

import { outsideGrid as snakeHitWall } from './grid.js';

import { getSnakeSpeed,
         updateSelectedBoardAppearance } from './options.js';

import { resetInputDirection } from './input.js';

import { drawRecordAndEmptyScore } from './score.js';

const gameBoard = document.getElementById('game-board');

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
        if (!document.body.classList.contains('modal-open')) {
            event.preventDefault();
        }
    }

    // start game
    if (keysThatMoveSnake.includes(event.code)) {
        gameStarted = true;
    }
}, false);


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

draw();
drawRecordAndEmptyScore();

var playButton = document.getElementById('playButton');
var halfTransparentBoardBackground = document.getElementById('boardHalfTransparentBackground');
// click on play button - run main loop function
playButton.addEventListener('click', event => {
    playButton.classList.add('d-none');
    halfTransparentBoardBackground.classList.add('d-none');

    // start animation loop function
    window.requestAnimationFrame(main);
});

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
    SNAKE_SPEED = getSnakeSpeed();
}

function checkSnakeFail() {
    if (snakeHitWall(getSnakeHeadPosition()) || snakeHitBody()) {
        gameStarted = false;
        resetSnakePosition();
        resetInputDirection();
    }
}


