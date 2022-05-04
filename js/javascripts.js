const names = []

function addRace() {
    var nameVar
    var scoreVar
    if(isPopulated('user1')) {
        nameVar = document.getElementById('user1').value
        scoreVar = document.getElementById('score1').value
        addPlayerScore(nameVar, scoreVar);
    }
    if(isPopulated('user2')) {
        nameVar = document.getElementById('user2').value
        scoreVar = document.getElementById('score2').value
        addPlayerScore(nameVar, scoreVar);
    }
    if(isPopulated('user3')) {
        nameVar = document.getElementById('user3').value
        scoreVar = document.getElementById('score3').value
        addPlayerScore(nameVar, scoreVar);
    }
    if(isPopulated('user4')) {
        nameVar = document.getElementById('user4').value
        scoreVar = document.getElementById('score4').value
        addPlayerScore(nameVar, scoreVar);
    }
    clearEntryBoxes(false)
    switchScreen();
}

function switchScreen() {
    if((document.getElementById('scoreboard').className) == 'hidden') {
        document.getElementById('scoreboard').className = 'shown'
        document.getElementById('newRaceButton').className = 'shown'
        document.getElementById('saveScoresButton').className = 'shown'
        document.getElementById('addRace').className = 'hidden'
    }
    else {
        document.getElementById('scoreboard').className = 'hidden'
        document.getElementById('newRaceButton').className = 'hidden'
        document.getElementById('addRace').className = 'shown'
        document.getElementById('saveScoresButton').className = 'hidden'
    }
}

function addPlayerScore(nameVar, scoreVar) {
    var table = document.getElementById('scoreTable');

    //var nameVar = document.getElementById('user'+playerNum).value
    //var scoreVar = document.getElementById('score'+playerNum).value

    if(names.includes(nameVar)) {

        for (var i = 0, row; row = table.rows[i]; i++) {
            if(row.cells[0].innerHTML == nameVar) {
                row.cells[1].innerHTML = parseInt(row.cells[1].innerHTML) + parseInt(scoreVar)
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

function loadScores() {
    var fileUpload = document.getElementById("fileUpload");
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
    //if (regex.test(fileUpload.value.toLowerCase())) {
    if (true) {
        if (typeof (FileReader) != "undefined") {
            var reader = new FileReader();
            reader.onload = function (e) {
                var table = document.createElement("table");
                var rows = e.target.result.split("\n");
                for (var i = 0; i < rows.length; i++) {
                    if (i != 0) {
                        var cells = rows[i].split(",");
                        addPlayerScore(cells[0], cells[1])
                    }
                }
            }
            reader.readAsText(fileUpload.files[0]);
        } else {
            alert("This browser does not support HTML5.");
        }
    } else {
        alert("Please upload a valid CSV file.");
    }
}
