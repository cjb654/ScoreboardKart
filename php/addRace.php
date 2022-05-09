<?php
    if (isset($_POST['submit'])) {
        if (isset($_POST['player1'])) { $players = 1; }
        if (isset($_POST['player2'])) { $players = 2; }
        if (isset($_POST['player3'])) { $players = 3; }
        if (isset($_POST['player4'])) { $players = 4; }
        $scores = [$_POST['score1'],$_POST['score2'],$_POST['score3'],$_POST['score4']];
        $first = array_keys($scores, max($scores));
        $players = [];
        $playerVar = 'player';
        $scoreVar = 'score';
        $positionVar = 'position';
        for ( $i = 1; $i < intval($players); $i++) {
            
            $player = $_POST['player'. $i];
            $score = $_POST['score' . $i];
            $position = $_POST['position' . $i];
            $firstPos = false;
            if ( $i == $first) { $firstPos = true; }
            array_push($scores, [$player, $score, $position, $firstPos]);
        }
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
        else {
            for ( $row = 0; $row < intval($players); $row++) {
                $Insert = "INSERT INTO 'scores' ('player', 'score', 'races', 'total_pos') 
                values ($row[0], $row[1], 1, $row[2]) ON DUPLICATE KEY UPDATE 'player' = $row[0], 'score' = 'score' + $row[1],
                'races' ='races' +  1, 'total_pos' = 'total_pos' + $row[2]";
                $result = $conn->query($Insert);
            }
        }
        $conn->close();
    }
?>