import { ateBySnake, expandSnake } from './snake.js';
import { getRandomGridPosition } from './grid.js';

let foodBody = getRandomFoodPosition();

const SNAKE_BODY_EXPANSION_RATE = 1;

export function update() {
    if (ateBySnake(foodBody)) {
        expandSnake(SNAKE_BODY_EXPANSION_RATE);
        foodBody = getRandomFoodPosition();
    }
}

export function draw(gameBoard) {
    const foodElement = document.createElement('div');
    foodElement.style.gridRowStart = foodBody.x;
    foodElement.style.gridColumnStart = foodBody.y;
    foodElement.classList.add('food');
    gameBoard.appendChild(foodElement);
}

function getRandomFoodPosition() {
    let newFoodPosition;
    while (newFoodPosition == null || ateBySnake(newFoodPosition)) {
        newFoodPosition = getRandomGridPosition();
    }
    return newFoodPosition;
}
