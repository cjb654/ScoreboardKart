<?php
$servername = "localhost";
$username = "root";
$password = "ScoreboardKart123";
$dbname = "scoreboard";

// get the func parameter from URL
$func = $_REQUEST["func"];

switch($func) {
  case "load" : 
    return loadTable()
}

function loadTable() {
  $query = "SELECT player, score, races, mean_score, mean_position FROM scores";
  return sendQuery($query)
}

function addRace(player, score, position){
  $query = "UPDATE scores SET score = score + $score, total_pos = total_pos + $position, races = races + 1  WHERE player == $player"
  sendQuery($query)
}

function addRaceNewPlayer(player, score, position) {
  $query = "INSERT INTO scores (player, score, total_pos, races) VALUES ($player, $score, $position, 1)"
  sendQuery($query)
}

function updateTotals() {
  $mean_score_query = "UPDATE scores SET mean_score = score / races"
  $mean_position_query = "UPDATE scores SET mean_position = total_pos / races"
  sendQuery($mean_score_query)
  sendQuery($mean_position_query)
}

function sendQuery(query) {
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }

  $sql = $query;
  $result = $conn->query($sql);

  $scores = []
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      player = [
        $row["player"],
        $row["score"],
        $row["races"],
        $row["mean_score"],
        $row["mean_position"],
      ]
      array_push($scores, player);
    }
  } else {
    echo "0 results";
  }
  $conn->close();

  loadScoresFromData($scores);
}

function loadScoresFromData(scores) {
  var table = document.getElementById("scoreboard").appendChild(
    document.createElement("table"));
  table.id = "scoreTable"

  for (var i = 0; i < scores.length; i++) {
      var row = table.insertRow()

      var name = row.insertCell(0);
      var score = row.insertCell(1);
      var races = row.insertCell(2);
      var mean_score = row.insertCell(3);
      var mean_position = row.insertCell(4);

      name.innerHTML = scores[i][0]
      score.innerHTML = scores[i][1]
      races.innerHTML = scores[i][2]
      mean_score.innerHTML = scores[i][3]
      mean_position.innerHTML = scores[i][4]
      score.innerHTML = scoreVar
  }
}

?>
