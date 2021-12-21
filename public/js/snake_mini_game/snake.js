import { getInputDirection } from './input.js';
import { updateScore,
         updateScoreRecord,
         updateTime } from './score.js';

export const SNAKE_SPEED = 5;

const snakeBody = [
    { x: 10, y: 11 },
    { x: 11, y: 11 },
    { x: 12, y: 11 }
];

let newSegments = 0;
let snakeHeadDirection = { x: 0, y: 0 };
let snakeTailDirection = { x: 0, y: 0 };
let snakeBodyLength;
let snakeHeadDiv;
let snakeTailDiv;
let score = 0;

export function update() {
    for (let i = 0; i < newSegments; newSegments--) {
        addSegmentToSnake();
    }

    const inputDirection = getInputDirection();

    for (let i = snakeBody.length - 2; i >= 0; i--) {
        snakeBody[i + 1] = { ...snakeBody[i] };
    }
    snakeBody[0].x += inputDirection.x;
    snakeBody[0].y += inputDirection.y;

    score = snakeBody.length - 3;
}

export function draw(gameBoard) {
    snakeBodyLength = snakeBody.length;

    // foreach on snake body segment
    snakeBody.forEach((segment, index) => {
        let snakeElement = document.createElement('div');
        snakeElement.style.gridRowStart = segment.x;
        snakeElement.style.gridColumnStart = segment.y;
        snakeElement.classList.add('snake-segment');

        if (index == 0) {
            snakeElement.setAttribute('id', 'snake-head');
        } else if (index == snakeBodyLength - 1) {
            snakeElement.setAttribute('id', 'snake-tail');
        } else {
            // segment which is not head and is not tail
            let currentNextSegmentRelation = getCurrentNextSegmentRelation(snakeBody, index);
            let currentPreviousSegmentRelation = getCurrentPreviousSegmentRelation(snakeBody, index);

            snakeElement = getSnakeElementWithCorrectClassAppearance(snakeElement, currentNextSegmentRelation, currentPreviousSegmentRelation);
        }

        gameBoard.appendChild(snakeElement);
    })
    snakeHeadDirection = getSnakeHeadDirection(snakeBody);
    snakeHeadDiv = document.getElementById('snake-head');
    snakeHeadDiv = getSnakeHeadWithCorrectClassAppearance(snakeHeadDiv, snakeHeadDirection);

    snakeTailDirection = getSnakeTailDirection(snakeBody);
    snakeTailDiv = document.getElementById('snake-tail');
    snakeTailDiv = getSnakeTailWithCorrectClassAppearance(snakeTailDiv, snakeTailDirection);

    // draw score bar
    updateScoreRecord(score);
    updateScore(score);
}

export function expandSnake(amount) {
    newSegments += amount;
}

export function positionIsInSnakeBody(position, { ignoreHead = false } = {}) {
    return snakeBody.some((segment, index) => {
        if (ignoreHead && index == 0) return false;
        return equalPositions(segment, position);
    });
}

export function getSnakeHeadPosition() {
    return snakeBody[0];
}

export function snakeHitBody() {
    return positionIsInSnakeBody(snakeBody[0], { ignoreHead: true });
}

function equalPositions(pos1, pos2) {
    return pos1.x == pos2.x && pos1.y == pos2.y;
}

function addSegmentToSnake() {
    snakeBody.push(snakeBody[snakeBody.length - 1]);
}

function getSnakeHeadDirection(snakeBody) {
    return {
        x: snakeBody[1].x - snakeBody[0].x,
        y: snakeBody[1].y - snakeBody[0].y
    };
}

function getSnakeTailDirection(snakeBody) {
    return {
        x: snakeBody[snakeBody.length - 1].x - snakeBody[snakeBody.length - 2].x,
        y: snakeBody[snakeBody.length - 1].y - snakeBody[snakeBody.length - 2].y
    };
}

function getCurrentPreviousSegmentRelation(snakeBody, segmentIndex) {
    return {
        x: snakeBody[segmentIndex].x - snakeBody[segmentIndex - 1].x,
        y: snakeBody[segmentIndex].y - snakeBody[segmentIndex - 1].y
    };
}

function getCurrentNextSegmentRelation(snakeBody, segmentIndex) {
    return {
        x: snakeBody[segmentIndex].x - snakeBody[segmentIndex + 1].x,
        y: snakeBody[segmentIndex].y - snakeBody[segmentIndex + 1].y
    };
}

function getSnakeElementWithCorrectClassAppearance(snakeElement, currentNextSegmentRelation, currentPreviousSegmentRelation) {
    // TOP LEFT
    if (currentNextSegmentRelation.x == -1 && currentNextSegmentRelation.y == 0 &&
        currentPreviousSegmentRelation.x == 0 && currentPreviousSegmentRelation.y == -1) {
        snakeElement.classList.add('snake-border-top-left');
    }
    else if (currentNextSegmentRelation.x == 0 && currentNextSegmentRelation.y == -1 &&
            currentPreviousSegmentRelation.x == -1 && currentPreviousSegmentRelation.y == 0) {
        snakeElement.classList.add('snake-border-top-left');
    }

    // TOP RIGHT
    else if (currentNextSegmentRelation.x == 0 && currentNextSegmentRelation.y == 1 &&
            currentPreviousSegmentRelation.x == -1 && currentPreviousSegmentRelation.y == 0) {
        snakeElement.classList.add('snake-border-top-right');
    }
    else if (currentNextSegmentRelation.x == -1 && currentNextSegmentRelation.y == 0 &&
            currentPreviousSegmentRelation.x == 0 && currentPreviousSegmentRelation.y == 1) {
        snakeElement.classList.add('snake-border-top-right');
    }

    // BOTTOM LEFT
    else if (currentNextSegmentRelation.x == 1 && currentNextSegmentRelation.y == 0 &&
            currentPreviousSegmentRelation.x == 0 && currentPreviousSegmentRelation.y == -1) {
        snakeElement.classList.add('snake-border-bottom-left');
    }
    else if (currentNextSegmentRelation.x == 0 && currentNextSegmentRelation.y == -1 &&
        currentPreviousSegmentRelation.x == 1 && currentPreviousSegmentRelation.y == 0) {
        snakeElement.classList.add('snake-border-bottom-left');
    }

    // BOTTOM RIGHT
    else if (currentNextSegmentRelation.x == 0 && currentNextSegmentRelation.y == 1 &&
            currentPreviousSegmentRelation.x == 1 && currentPreviousSegmentRelation.y == 0) {
        snakeElement.classList.add('snake-border-bottom-right');
    }
    else if (currentNextSegmentRelation.x == 1 && currentNextSegmentRelation.y == 0 &&
        currentPreviousSegmentRelation.x == 0 && currentPreviousSegmentRelation.y == 1) {
        snakeElement.classList.add('snake-border-bottom-right');
    }

    return snakeElement;
}

function getSnakeHeadWithCorrectClassAppearance(snakeHeadDiv, snakeHeadDirection) {
    if (snakeHeadDirection.x == 1 && snakeHeadDirection.y == 0) {
        snakeHeadDiv.classList.add('snake-border-to-top');
    } else if (snakeHeadDirection.x == -1 && snakeHeadDirection.y == 0) {
        snakeHeadDiv.classList.add('snake-border-to-bottom');
    } else if (snakeHeadDirection.x == 0 && snakeHeadDirection.y == 1) {
        snakeHeadDiv.classList.add('snake-border-to-left');
    } else if (snakeHeadDirection.x == 0 && snakeHeadDirection.y == -1) {
        snakeHeadDiv.classList.add('snake-border-to-right');
    }

    return snakeHeadDiv;
}

function getSnakeTailWithCorrectClassAppearance(snakeTailDiv, snakeTailDirection) {
    if (snakeTailDirection.x == 1 && snakeTailDirection.y == 0) {
        snakeTailDiv.classList.add('snake-border-to-bottom');
    } else if (snakeTailDirection.x == -1  && snakeTailDirection.y == 0) {
        snakeTailDiv.classList.add('snake-border-to-top');
    } else if (snakeTailDirection.x == 0 && snakeTailDirection.y == 1) {
        snakeTailDiv.classList.add('snake-border-to-right');
    } else if (snakeTailDirection.x == 0 && snakeTailDirection.y == -1) {
        snakeTailDiv.classList.add('snake-border-to-left');
    }

    return snakeTailDiv;
}




