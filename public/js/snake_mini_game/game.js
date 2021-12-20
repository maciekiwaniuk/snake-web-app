import { SNAKE_SPEED,
         update as updateSnake,
         draw as drawSnake,
         getSnakeHeadPosition,
         snakeHitBody } from './snake.js';

import { update as updateFood,
         draw as drawFood } from './food.js';

import { outsideGrid as snakeHitWall } from './grid.js';

const gameBoard = document.getElementById('game-board');

let lastRenderTime = 0;
let gameOver = false;
let gameStarted = false;

let keysSnakeGameMoves = [
    'ArrowUp', 'ArrowDown',
    'ArrowLeft', 'ArrowRight',
    'KeyW', 'KeyS',
    'KeyA', 'KeyD',
    'Space'
];
// prevent to move website while clicking arrow or space
window.addEventListener('keydown', event => {
    if(keysSnakeGameMoves.includes(event.code)) {
        gameStarted = true;
        event.preventDefault();
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
}

function checkSnakeFail() {
    gameOver = snakeHitWall(getSnakeHeadPosition()) || snakeHitBody();
}


