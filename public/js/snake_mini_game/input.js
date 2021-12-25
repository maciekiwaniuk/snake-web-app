const moveUpButton = document.getElementById('move-up-button');
const moveDownButton = document.getElementById('move-down-button');
const moveLeftButton = document.getElementById('move-left-button');
const moveRightButton = document.getElementById('move-right-button');

let inputDirection = { x: 0, y: 0 };
let lastInputDirection = { x: 0, y: 0 };



window.addEventListener('keydown', event => {
    switch (event.code) {
        case 'KeyW':
        case 'ArrowUp': {
            if (lastInputDirection.x == 1) break;
            inputDirection = { x: -1, y: 0 };
        } break;

        case 'KeyS':
        case 'ArrowDown': {
            if (lastInputDirection.x == -1) break;
            inputDirection = { x: 1, y: 0 };
        } break;

        case 'KeyA':
        case 'ArrowLeft': {
            if (lastInputDirection.y == 1) break;
            inputDirection = { x: 0, y: -1 };
        } break;

        case 'KeyD':
        case 'ArrowRight': {
            if (lastInputDirection.y == -1) break;
            inputDirection = { x: 0, y: 1 };
        } break;
    }
});

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

export function resetInputDirection() {
    inputDirection = { x: 0, y: 0 };
    lastInputDirection = { x: 0, y: 0 };
}

export function getInputDirection() {
    if (lastInputDirection.x == 0 && lastInputDirection.y == 0 &&
        inputDirection.x == 1 && inputDirection.y == 0) {
        return;
    }
    lastInputDirection = inputDirection;

    return inputDirection;
}
