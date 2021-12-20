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

export function getInputDirection() {
    lastInputDirection = inputDirection;
    return inputDirection;
}