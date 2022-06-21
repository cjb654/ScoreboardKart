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
    
    $sql = "SELECT player, score, position FROM races";
    $result = $conn->query($sql);

    echo '<div class="shown" id="scoreboard">';
    $sortedPlayers = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $player = [$row["player"], $row["score"], $row["position"], 1];
            if(empty($sortedPlayers)){
                array_push($sortedPlayers, $player);
            }
            else{
                foreach($sortedPlayers as $sortedPlayer){
                    if ($sortedPlayer[0] == $player[0]){
                        $total_score = ($sortedPlayer[1] * $sortedPlayer[3]);
                        $total_position = ($sortedPlayer[2] * $sortedPlayer[3]);
                        $player[3] += $sortedPlayer[3];
                        $player[2] += $total_position;
                        $player[2] = $player[2] / $player[3];
                        $player[1] += $total_score;
                        $player[1] = $player[1] / $player[3];
                        $sortedPlayer = $player;
                        goto place;
                    }
                }
                place:
                array_push($sortedPlayers, $player);
            }
        }

        usort($sortedPlayers, "cmp");

        echo '<table id="scoreTable"><tr>';    
        echo '<th>'.'Player'.'</th>';
        echo '<th>'.'Races Played'.'</th>';
        echo '<th>'.'Avearge Score'.'</th>';
        echo '<th>'.'Average Position'.'</th>';
        echo '</tr>';

        foreach($sortedPlayers as $player){
            echo "<tr><td>" . $player[0]. "</td><td>"
            . $player[3]. "</td><td>" . $player[1] . "</td><td>" . $player[2] . "</td></tr>";
        }
        echo '</table>';
        echo '</div>';
    } 
    else {
        echo "0 results";
    }
    $conn->close();

    function cmp($a, $b) {
        return strcmp($a->name, $b->name);
    }
?>
