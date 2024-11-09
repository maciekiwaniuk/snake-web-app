import { getInputDirection } from './input.js';

import { updateScore,
         updateScoreRecord } from './score.js';

import { getSnakeSegmentWithSelectedSnakeAppearance } from './options.js';

let snakeBody = [
    { x: 10, y: 11 },
    { x: 11, y: 11 },
    { x: 12, y: 11 }
];

let newSegments = 0;
let snakeHeadDirection = { x: 0, y: 0 };
let snakeTailDirection = { x: 0, y: 0 };
let score = 0;

export function update() {
    for (let i = 0; i < newSegments; newSegments--) {
        addSegmentToSnake();
    }

    const inputDirection = getInputDirection();

    for (let i = snakeBody.length - 2; i >= 0; i--) {
        let nextSegment = {
            x: snakeBody[i].x,
            y: snakeBody[i].y
        }
        snakeBody[i + 1] = nextSegment;
    }
    if (typeof inputDirection == 'undefined') {
        return;
    } else {
        snakeBody[0].x += inputDirection.x;
        snakeBody[0].y += inputDirection.y;
    }

}

export function draw(gameBoard) {
    let snakeBodyLength = snakeBody.length;

    // foreach on snake body segment
    snakeBody.forEach((segment, index) => {
        let snakeElement = document.createElement('div');
        snakeElement = getSnakeSegmentWithSelectedSnakeAppearance(snakeElement);
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
    let snakeHeadDiv = document.querySelector('#snake-head');
    snakeHeadDiv = getSnakeHeadWithCorrectClassAppearance(snakeHeadDiv, snakeHeadDirection);

    snakeTailDirection = getSnakeTailDirection(snakeBody);
    let snakeTailDiv = document.querySelector('#snake-tail');
    snakeTailDiv = getSnakeTailWithCorrectClassAppearance(snakeTailDiv, snakeTailDirection);

    // draw score bar and handle data from cookie mechanism
    score = snakeBody.length - 3;
    updateScoreRecord(score);
    updateScore(score);
}

export function expandSnake(amount) {
    newSegments += amount;
}

export function positionIsInSnakeBody(position) {
    return snakeBody.some((segment, index) => {
        return equalPositions(segment, position);
    });
}

export function snakeHitBody() {
    let hit = false;
    snakeBody.forEach(function(segment, index) {
        if (index != 0 && equalPositions(snakeBody[0], segment)) {
            hit = true;
        }
    });
    return hit;
}

export function getSnakeHeadPosition() {
    return snakeBody[0];
}

export function resetSnakePosition() {
    snakeBody = [
        { x: 10, y: 11 },
        { x: 11, y: 11 },
        { x: 12, y: 11 }
    ];
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
    snakeHeadDiv.classList.add('position-relative');

    // creating snake's eyes
    let leftSnakeEye = document.createElement('div');
    let rightSnakeEye = document.createElement('div');

    leftSnakeEye.classList.add('position-absolute');
    rightSnakeEye.classList.add('position-absolute');

    leftSnakeEye.classList.add('snake-eye');
    rightSnakeEye.classList.add('snake-eye');

    if (snakeHeadDirection.x == 1 && snakeHeadDirection.y == 0) {
        snakeHeadDiv.classList.add('snake-border-to-top');
        leftSnakeEye.style.top = '0.7vmin';
        leftSnakeEye.style.left = '0.7vmin';
        rightSnakeEye.style.top = '0.7vmin';
        rightSnakeEye.style.right = '0.7vmin';
    } else if (snakeHeadDirection.x == -1 && snakeHeadDirection.y == 0) {
        snakeHeadDiv.classList.add('snake-border-to-bottom');
        leftSnakeEye.style.bottom = '0.7vmin';
        leftSnakeEye.style.left = '0.7vmin';
        rightSnakeEye.style.bottom = '0.7vmin';
        rightSnakeEye.style.right = '0.7vmin';
    } else if (snakeHeadDirection.x == 0 && snakeHeadDirection.y == 1) {
        snakeHeadDiv.classList.add('snake-border-to-left');
        leftSnakeEye.style.bottom = '0.7vmin';
        leftSnakeEye.style.left = '0.7vmin';
        rightSnakeEye.style.top = '0.7vmin';
        rightSnakeEye.style.left = '0.7vmin';
    } else if (snakeHeadDirection.x == 0 && snakeHeadDirection.y == -1) {
        snakeHeadDiv.classList.add('snake-border-to-right');
        leftSnakeEye.style.bottom = '0.7vmin';
        leftSnakeEye.style.right = '0.7vmin';
        rightSnakeEye.style.top = '0.7vmin';
        rightSnakeEye.style.right = '0.7vmin';
    }

    snakeHeadDiv.appendChild(leftSnakeEye);
    snakeHeadDiv.appendChild(rightSnakeEye);
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





