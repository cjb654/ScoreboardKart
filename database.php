<?php
$servername = "localhost";
$username = "root";
$password = "ScoreboardKart123";
$dbname = "scoreboard";

// get the func parameter from URL
$func = $_REQUEST["func"];

switch($func) {
  case "load" : 
    loadTable();
}

function loadTable() {
  $query = "SELECT player, score, races, mean_score, mean_position FROM scores";
  return sendQuery($query);
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
  echo '<table id="scoreTable"><thead><tr>';

  //$header

  foreach($scores[0] as $header) {
      echo '<th>'.$header.'</th>';
  }

  echo '<th>'.'name'.'</th>';
  echo '<th>'.'score'.'</th>';
  echo '<th>'.'races'.'</th>';
  echo '<th>'.'mean_score'.'</th>';
  echo '<th>'.'mean_position'.'</th>';
  
  echo '</tr></thead><tbody>';

  foreach($scores as $row) {
      echo '<tr>';
      for ($i = 0; $i < $scores.length; $i++) {
        echo '<td>'.$row[$i].'</td>';
      }
      echo '</tr>';
  }
  echo '</tbody></table>';
}

?>
