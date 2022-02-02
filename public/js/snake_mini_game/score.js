import { createCookieWithDataIfNotExists } from './options.js';

let scoreDiv = document.getElementById('score');
let scoreRecordDiv = document.getElementById('score-record');

export function updateScore(score) {
    scoreDiv.textContent = score;
}

export function updateScoreRecord(score) {
    createCookieWithDataIfNotExists();

    let data = JSON.parse(Cookies.get('snake-mini-game'));

    if (data.scoreRecord < score) {
        data.scoreRecord = score;
        Cookies.set('snake-mini-game', JSON.stringify(data), { expires: 365 });
    }

    scoreRecordDiv.textContent = data.scoreRecord;
}

export function drawRecordAndEmptyScore() {
    updateScoreRecord();
    scoreDiv.textContent = 0;
}
