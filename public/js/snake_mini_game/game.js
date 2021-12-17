import { update as updateSnake, draw as drawSnake, SNAKE_SPEED, getSnakeHeadPosition, snakeHitsHisBody } from './snake.js';
import { update as updateFood, draw as drawFood } from './food.js';
import { outsideGrid } from './grid.js';

let lastRenderTime = 0;
let gameOver = false;
const gameBoard = document.getElementById('game-board');

// prevent to move website while clicking arrows, wsad or space
let keysSnakeGameMoves = [
    'ArrowUp', 'ArrowDown',
    'ArrowLeft', 'ArrowRight',
    'Space'
]
window.addEventListener('keydown', event => {
    if(keysSnakeGameMoves.includes(event.code)) {
        event.preventDefault();
    }
}, false);

function main(currentTime) {

    window.requestAnimationFrame(main);
    const secondsSinceLastRender = (currentTime - lastRenderTime) / 1000;
    if (secondsSinceLastRender < 1 / SNAKE_SPEED) return;

    lastRenderTime = currentTime;

    update();
    draw();
}

// animation loop -> looping main function
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
    gameOver = outsideGrid(getSnakeHeadPosition) || snakeHitsHisBody();
}


