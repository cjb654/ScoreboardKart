function addRace() {
    var nameVar
    var scoreVar
    var posVar

    /*var player1 = []
    var player2 = []
    var player3 = []
    var player4 = []*/

    if(isPopulated('name1')) {
        var player1 = []
        player1[0] = document.getElementById('name1').value
        player1[1] = document.getElementById('score1').value
        player1[2] = document.getElementById('position1').value
        players = 1
    }
    if(isPopulated('name2')) {
        var player2 = []
        player2[0] = document.getElementById('name2').value
        player2[1] = document.getElementById('score2').value
        player2[2] = document.getElementById('position2').value
        players = 2
    }
    if(isPopulated('name3')) {
        var player3 = []
        player3[0] = document.getElementById('name3').value
        player3[1] = document.getElementById('score3').value
        player3[2] = document.getElementById('position3').value
        players = 3
    }
    if(isPopulated('name4')) {
        var player4 = []
        player4[0] = document.getElementById('name4').value
        player4[1] = document.getElementById('score4').value
        player4[2] = document.getElementById('position4').value
        players = 4
    }
    first = Math.max(player1[1],player2[1],player3[1],player4[1])

    var players = []
    for (var i = 1; i <= 4; i++) {
        var player = "player"+i
        if(this[player])
        players.push(this[player])
    } 

    addScores(players, first)

    switchClear()
}

function switchClear() {
    clearEntryBoxes(false);
    switchScreen();
}

function addScores(players, first) {
    for (var i = 0; i < players.length; i++) {
        if(first == i) {
            addPlayerScore(players[i], true)
        }
        else{
            addPlayerScore(players[i], false)
        }
    }
}

function switchScreen() {
    if((document.getElementById('scoreboard').className) == 'hidden') {
        document.getElementById('scoreboard').className = 'shown'
        document.getElementById('buttons').className = 'shown'
        document.getElementById('addRace').className = 'hidden'
    }
    else {
        document.getElementById('scoreboard').className = 'hidden'
        document.getElementById('buttons').className = 'hidden'
        document.getElementById('addRace').className = 'shown'
    }
}

function addPlayerScore(player, first) {
    var table = document.getElementById('scoreTable');

    if(names.includes(nameVar)) {

        for (var i = 0, row; row = table.rows[i]; i++) {
            if(row.cells[0].innerHTML == nameVar) {
                row.cells[1].innerHTML = parseInt(row.cells[1].innerHTML) + parseInt(scoreVar)
                if (firstVar) {
                    row.cells[2].innerHTML = (parseInt(row.cells[2].innerHTML)) + 1
                }
            }
        }
    }
    else {
        names.push(nameVar)

        var row = table.insertRow();

        var name = row.insertCell(0);
        var score = row.insertCell(1);
        var firsts = row.insertCell(2);
        var twelfths = row.insertCell(3);

        name.innerHTML = nameVar
        score.innerHTML = scoreVar
        firsts.innerHTML = 0
        if (firstVar) {
            firsts.innerHTML = firstVar
        }
    }
}

function isPopulated(input) {
    if(document.getElementById(input).value){
        return true
    }
    return false
}

function loadScoresFromData(scores) {
    var table = document.createElement("table");
    for (var i = 0; i < scores.length; i++) {
        if (i != 0) {
            var cells = scores[i].split(",");
            addPlayerScore(cells[0], cells[1], cells[2])
        }
    }
}

function loadScores() {
    makeScoresRequest()
}

function makeScoresRequest() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "database.php?func=" + "load", true);
    xmlhttp.send();    
}
