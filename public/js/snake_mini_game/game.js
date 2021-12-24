import { SNAKE_SPEED,
         update as updateSnake,
         draw as drawSnake,
         getSnakeHeadPosition,
         snakeHitBody } from './snake.js';

import { update as updateFood,
         draw as drawFood } from './food.js';

import { outsideGrid as snakeHitWall } from './grid.js';

import { toogleOptionsMenu } from './options.js';

console.log(snakeHitBody());

const gameBoard = document.getElementById('game-board');
const optionsButton = document.getElementById('options-div');

let lastRenderTime = 0;
let gameOver = false;
let gameStarted = false;
let snakeMoved = false;


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

    if (gameOver) {
        console.log('game over = true');
    }
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
    console.log(snakeHitBody());
    gameOver = snakeHitWall(getSnakeHeadPosition()) || snakeHitBody();
}


