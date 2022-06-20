<?php
    if (isset($_POST['submit'])) {
        $playersNum = 4;
        if (empty($_POST['player4'])) { $playersNum = 3; }
        if (empty($_POST['player3'])) { $playersNum = 2; }
        if (empty($_POST['player2'])) { $playersNum = 1; }
        echo $playersNum;
        $scores = [$_POST['score1'],$_POST['score2'],$_POST['score3'],$_POST['score4']];
        $first = array_keys($scores, max($scores));
        $players = [];
        $playerVar = 'player';
        $scoreVar = 'score';
        $positionVar = 'position';
        $raceLength = $_POST['length'];

        for ( $i = 1; $i <= $playersNum; $i++) {
            $player = $_POST[$playerVar . $i];
            $score = $_POST[$scoreVar . $i];
            $position = $_POST[$positionVar . $i];
            switch($raceLength){
                case 4:
                    $score = $score * 1.5;
                    break;
                case 8:
                    $score = $score * 0.75;
                    break;
                case 12:
                    $score = $score * 0.5;
                    break;
                case 24:
                    $score = $score * 0.25;
                    break; 
                case 48:
                    $score = $score * 0.125;
                    break;  
                default:
                break;
            }
            array_push($players, [$player, $score, $position,]);
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
                $Insert = "INSERT INTO `races` (`player`, `score`, `position`) 
                VALUES ($playerName, $playerScore $playerPosition)";
                echo $Insert;
                $result = $conn->query($Insert);
                echo $result;
            }
        }
        $conn->close();

        header('Location: ../scoreboardKart.html');
        exit;
    }
?>
