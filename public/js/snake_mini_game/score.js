let scoreDiv = document.getElementById('score');
let scoreRecordDiv = document.getElementById('score-record');
let timeDiv = document.getElementById('time');

export function updateScore(score) {
    scoreDiv.textContent = score;
}

export function updateScoreRecord(score) {
    let dataCookie = Cookies.get('snake-mini-game');
    if (dataCookie == null) {
        createDefaultCookieData();
    }

    let data = JSON.parse(Cookies.get('snake-mini-game'));

    if (data.scoreRecord < score) {
        data.scoreRecord = score;
        Cookies.set('snake-mini-game', JSON.stringify(data), { expires: 365 });
    }

    scoreRecordDiv.textContent = data.scoreRecord;
}

export function updateTime(time) {
    timeDiv.textContent = time;
}

function createDefaultCookieData() {
    let data = {
        scoreRecord: 0
    };
    Cookies.set('snake-mini-game', JSON.stringify(data), { expires: 365 });
}

