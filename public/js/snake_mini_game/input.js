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
    if (lastInputDirection.x == 0 && lastInputDirection.y == 0 &&
        inputDirection.x == 1 && inputDirection.y == 0) {
        return {
            x: 0,
            y: 0
        };
    }

    lastInputDirection = inputDirection;

    // console.log('lastInputDirection.x ==> '+lastInputDirection.x);
    // console.log('lastInputDirection.y ==> '+lastInputDirection.y);
    // console.log('inputDirection.x ==> '+inputDirection.x);
    // console.log('inputDirection.y ==> '+inputDirection.y);
    // console.log('====');


    console.log(inputDirection);
    return inputDirection;
}
