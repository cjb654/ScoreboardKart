<?php
$servername = "localhost";
$username = "root";
$password = "ScoreboardKart123";
$dbname = "scoreboard";

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
  echo '<table id="scoreTable"><tr>';

  //$header

  echo '<th>'.'name'.'</th>';
  echo '<th>'.'score'.'</th>';
  echo '<th>'.'races'.'</th>';
  echo '<th>'.'mean_score'.'</th>';
  echo '<th>'.'mean_position'.'</th>';
  
  echo '</tr>';

  foreach($scores as $row) {
      echo '<tr>';
      for ($i = 0; $i < $scores.length; $i++) {
        echo '<td>'.$row[$i].'</td>';
      }
      echo '</tr>';
  }
  echo '</table>';
}

?>
