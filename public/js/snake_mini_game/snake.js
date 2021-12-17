import { getInputDirection } from './input.js';

export const SNAKE_SPEED = 7;

const snakeBody = [
    { x: 10, y: 11 },
    { x: 11, y: 11 },
    { x: 12, y: 11 }
];

let newSegments = 0;

export function update() {
    addSegments();
    const inputDirection = getInputDirection();
    for (let i = snakeBody.length - 2; i >= 0; i--) {
        snakeBody[i + 1] = { ...snakeBody[i] };
    }
    snakeBody[0].x += inputDirection.x;
    snakeBody[0].y += inputDirection.y;
}

export function draw(gameBoard) {
    snakeBody.forEach(segment => {
        const snakeElement = document.createElement('div');
        snakeElement.style.gridRowStart = segment.x;
        snakeElement.style.gridColumnStart = segment.y;
        snakeElement.classList.add('snake');
        gameBoard.appendChild(snakeElement);
    })
}

export function expandSnake(amount) {
    newSegments += amount;
}

export function ateBySnake(position, { ignoreHead = false } = {}) {
    return snakeBody.some((segment, index) => {
        if (ignoreHead && index == 0) return false;
        return equalPositions(segment, position);
    });
}

function equalPositions(pos1, pos2) {
    return pos1.x == pos2.x && pos1.y == pos2.y;
}

function addSegments() {
    for (let i = 0; i < newSegments; i++) {
        snakeBody.push({ ...snakeBody[snakeBody.length - 1] });
    }
    newSegments = 0;
}

export function getSnakeHeadPosition() {
    return snakeBody[0];
}

export function snakeHitsHisBody() {
    return ateBySnake(snakeBody[0], { ignoreHead: true });
}






