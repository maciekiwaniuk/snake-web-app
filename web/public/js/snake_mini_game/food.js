import { positionIsInSnakeBody,
         expandSnake } from './snake.js';

import { getRandomGridPosition } from './grid.js';

import { getFoodBodyWithSelectedFoodAppearance } from './options.js';

const SNAKE_BODY_EXPANSION_RATE = 1;

let foodBody = getRandomFoodPosition();


export function update() {
    if (positionIsInSnakeBody(foodBody)) {
        expandSnake(SNAKE_BODY_EXPANSION_RATE);
        foodBody = getRandomFoodPosition();
    }
}

export function draw(gameBoard) {
    let foodElement = document.createElement('div');
    foodElement = getFoodBodyWithSelectedFoodAppearance(foodElement);
    foodElement.style.gridRowStart = foodBody.x;
    foodElement.style.gridColumnStart = foodBody.y;
    foodElement.classList.add('food');
    gameBoard.appendChild(foodElement);
}

function getRandomFoodPosition() {
    let newFoodPosition;
    while (newFoodPosition == null || positionIsInSnakeBody(newFoodPosition)) {
        newFoodPosition = getRandomGridPosition();
    }
    return newFoodPosition;
}
