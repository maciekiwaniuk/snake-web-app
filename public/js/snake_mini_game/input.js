const moveUpButton = document.querySelector('#move-up-button');
const moveDownButton = document.querySelector('#move-down-button');
const moveLeftButton = document.querySelector('#move-left-button');
const moveRightButton = document.querySelector('#move-right-button');

const messageFormModal = document.querySelector('#messageFormModal');

let inputDirection = { x: 0, y: 0 };
let lastInputDirection = { x: 0, y: 0 };


window.addEventListener('keydown', event => {
    switch (event.code) {
        case 'KeyW':
        case 'ArrowUp': {
            if (messageFormModal.style.display == 'block') break;
            if (lastInputDirection.x == 1) break;
            inputDirection = { x: -1, y: 0 };
        } break;

        case 'KeyS':
        case 'ArrowDown': {
            if (messageFormModal.style.display == 'block') break;
            if (lastInputDirection.x == -1) break;
            inputDirection = { x: 1, y: 0 };
        } break;

        case 'KeyA':
        case 'ArrowLeft': {
            if (messageFormModal.style.display == 'block') break;
            if (lastInputDirection.y == 1) break;
            inputDirection = { x: 0, y: -1 };
        } break;

        case 'KeyD':
        case 'ArrowRight': {
            if (messageFormModal.style.display == 'block') break;
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
