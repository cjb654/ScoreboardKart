function switchClear() {
    clearEntryBoxes();
    switchScreen();
}

function switchScreen() {
    var scoreboardExists = document.getElementById('scoreboard');
    if(scoreboardExists) {
        if((document.getElementById('addRace').className) == 'hidden') {
            document.getElementById('scoreboard').className = 'hidden'
            document.getElementById('buttons').className = 'hidden'
            document.getElementById('addRace').className = 'shown'
        }
        else {
            document.getElementById('scoreboard').className = 'shown'
            document.getElementById('buttons').className = 'shown'
            document.getElementById('addRace').className = 'hidden'
        }
    }
    else {
        if((document.getElementById('addRace').className) == 'hidden') {
            document.getElementById('buttons').className = 'hidden'
            document.getElementById('addRace').className = 'shown'
        }
        else {
            document.getElementById('buttons').className = 'shown'
            document.getElementById('addRace').className = 'hidden'
        }
    }
}

function clearEntryBoxes() {
    //document.getElementById('player1').value = '';
    document.getElementById('score1').value = '';
    document.getElementById('position1').value = '';

    //document.getElementById('player2').value = '';
    document.getElementById('score2').value = '';
    document.getElementById('position2').value = '';

    //document.getElementById('player3').value = '';
    document.getElementById('score3').value = '';
    document.getElementById('position3').value = '';

    //document.getElementById('player4').value = '';
    document.getElementById('score4').value = '';
    document.getElementById('position4').value = '';
}
