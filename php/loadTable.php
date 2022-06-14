<?php
    $servername = "localhost";
    $username = "root";
    $password = "ScoreboardKart123";
    $dbname = "scoreboard";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT player, score, races, mean_score, mean_position FROM scores";
    $result = $conn->query($sql);

    echo '<div class="shown" id="scoreboard">';
    
    if ($result->num_rows > 0) {
        echo '<table id="scoreTable"><tr>';    
        echo '<th>'.'Player'.'</th>';
        echo '<th>'.'Total Score'.'</th>';
        echo '<th>'.'Races Played'.'</th>';
        echo '<th>'.'Avearge Score'.'</th>';
        echo '<th>'.'Average Position'.'</th>';
        echo '</tr>';

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["player"]. "</td><td>" . $row["score"] . "</td><td>"
            . $row["races"]. "</td><td>" . $row["mean_score"] . "</td><td>" . $row["mean_position"] . "</td></tr>";
        }
        echo '</table>';
        echo '</div>';
    } 
    else {
        echo "0 results";
    }
    $conn->close();
?>
