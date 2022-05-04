const names = []

function addRace() {
    var nameVar
    var scoreVar
    const scores = []

    if(isPopulated('user1')) {
        scoreVar = document.getElementById('score1').value
        scores.push(scoreVar)
        players = 1
    }
    if(isPopulated('user2')) {
        scoreVar = document.getElementById('score2').value
        scores.push(scoreVar)
        players = 2
    }
    if(isPopulated('user3')) {
        scoreVar = document.getElementById('score3').value
        scores.push(scoreVar)
        players = 3
    }
    if(isPopulated('user4')) {
        scoreVar = document.getElementById('score4').value
        scores.push(scoreVar)
        players = 4
    }
    first = 0
    for (var i = 1; i < scores.length; i++) {
        if (scores[i] > scores[first]) {
            first = i
        }
    }

    callAddScores(players, first)

    switchClear()
}

function switchClear() {
    clearEntryBoxes(false);
    switchScreen();
}

function callAddScores(players, first) {
    one = false
    two = false
    three = false
    four = false
    switch(first) {
        case 0:
            one = true
            break;
        case 1:
            two = true
            break;
        case 2:
            three = true
            break
        case 3: 
            four = true
            break;
    }

    switch(players) {
        case 1:
            addScores(1, one); 
            break;
        case 2:
            addScores(1, one); 
            addScores(2, two); 
            break;
        case 3:
            addScores(1, one); 
            addScores(2, two); 
            addScores(3, three);
            break;
        case 4:
            addScores(1, one); 
            addScores(2, two); 
            addScores(3, three);
            addScores(4, four); 
            break;
    }
}

function addScores(playerNum, first) {
    nameVar = document.getElementById('user'+playerNum).value
    scoreVar = document.getElementById('score'+playerNum).value
    addPlayerScore(nameVar, scoreVar, first);
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

function addPlayerScore(nameVar, scoreVar, first) {
    var table = document.getElementById('scoreTable');

    if(names.includes(nameVar)) {

        for (var i = 0, row; row = table.rows[i]; i++) {
            if(row.cells[0].innerHTML == nameVar) {
                row.cells[1].innerHTML = parseInt(row.cells[1].innerHTML) + parseInt(scoreVar)
                if (first) {
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
        if (first) {
            firsts.innerHTML = 1
        }
    }
}

function isPopulated(input) {
    if(document.getElementById(input).value){
        return true
    }
    return false
}

function htmlToCSV(html, filename) {
	var data = [];
	var rows = document.querySelectorAll("table tr");
			
	for (var i = 0; i < rows.length; i++) {
		var row = [], cols = rows[i].querySelectorAll("td, th");
				
		for (var j = 0; j < cols.length; j++) {
		        row.push(cols[j].innerText);
        }
		        
		data.push(row.join(",")); 		
	}

	downloadCSVFile(data.join("\n"), filename);
}

function downloadCSVFile(csv, filename) {
	var csv_file, download_link;

	csv_file = new Blob([csv], {type: "text/csv"});

	download_link = document.createElement("a");

	download_link.download = filename;

	download_link.href = window.URL.createObjectURL(csv_file);

	download_link.style.display = "none";

	document.body.appendChild(download_link);

	download_link.click();
}

function saveScores() {
    var html = document.querySelector("table").outerHTML;
    htmlToCSV(html, "scores.csv");
}

function clearEntryBoxes(players) {
    document.getElementById('score1').value = ""
    document.getElementById('score2').value = ""
    document.getElementById('score3').value = ""
    document.getElementById('score4').value = ""

    if(players == true) {
        document.getElementById('user1').value = ""
        document.getElementById('user2').value = ""
        document.getElementById('user3').value = ""
        document.getElementById('user4').value = ""
    }
}

async function loadScores() {
    try {
		let scores_data = await downloadFile();
	}
	catch(e) {
		alert(e.message);
	}
}

async function downloadFile() {
	let response = await fetch("/scores.csv");
		
	if(response.status != 200) {
		throw new Error("Server Error");
	}
		
	// read response stream as text
	let scores_data = await response.text();

	loadScoresFromData(scores_data.split("\n"));
}

function loadScoresFromData(scores) {
    var table = document.createElement("table");
    for (var i = 0; i < scores.length; i++) {
        if (i != 0) {
            var cells = scores[i].split(",");
            addPlayerScore(cells[0], cells[1])
        }
    }
}
