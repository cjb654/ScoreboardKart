<?php
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT player, score, races, mean_score, mean_position FROM scores";
    $result = $conn->query($sql);
    
    $scores = []
    if ($result->num_rows > 0) {
        echo '<table id="scoreTable"><tr>';    
        echo '<th>'.'name'.'</th>';
        echo '<th>'.'score'.'</th>';
        echo '<th>'.'races'.'</th>';
        echo '<th>'.'mean_score'.'</th>';
        echo '<th>'.'mean_position'.'</th>';
        echo '</tr>';

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["player"]. "</td><td>" . $row["score"] . "</td><td>"
            . $row["races"]. "</td><td>" . $row["mean_score"] . "</td><td>" . $row["mean_position"] . "</td></tr>";
        }
        echo '</table>'
    } else {
        echo "0 results";
    }
    $conn->close();
?>