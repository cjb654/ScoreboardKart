<?php
    if (isset($_POST['submit'])) {
        if (isset($_POST['player1'])) { $playersNum = 1; }
        if (isset($_POST['player2'])) { $playersNum = 2; }
        if (isset($_POST['player3'])) { $playersNum = 3; }
        if (isset($_POST['player4'])) { $playersNum = 4; }
        echo $playersNum;
        $scores = [$_POST['score1'],$_POST['score2'],$_POST['score3'],$_POST['score4']];
        $first = array_keys($scores, max($scores));
        $players = [];
        $playerVar = 'player';
        $scoreVar = 'score';
        $positionVar = 'position';

        for ( $i = 1; $i <= $playersNum; $i++) {
            $player = $_POST[$playerVar . $i];
            $score = $_POST[$scoreVar . $i];
            $position = $_POST[$positionVar . $i];
            $firstPos = false;
            if ( $i == $first) { $firstPos = true; }
            array_push($players, [$player, $score, $position, $firstPos]);
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
            for ( $row = 0; $row < $playersNum; $row++) {
                echo '<hr>';
                echo $row;
                echo '<hr>';
                $playerName = $players[$row][0];
                $playerScore = $players[$row][1];
                $playerPosition = $players[$row][2];
                $Insert = "INSERT INTO `scores` (`player`, `score`, `races`, `total_pos`) 
                VALUES ('$playerName', $playerScore, 1, $playerPosition) 
                ON DUPLICATE KEY UPDATE `player` =  '$playerName', `score` = `score` +  $playerScore,
                `races` =`races` +  1, `total_pos` = `total_pos` +  $playerPosition";
                echo $Insert;
                $result = $conn->query($Insert);
                echo $result;
            }
        }
        $conn->close();
    }
?>
