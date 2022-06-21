<?php

    function add($player){
    
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
            $playerName = $player[0];
            $playerScore = $player[1];
            $playerPosition = $player[2];
            $length = $player[3];
            switch($length){
                case 4:
                    $playerScore = $playerScore * 1.5;
                    break;
                case 8:
                    $playerScore = $playerScore * 0.75;
                    break;
                case 12:
                    $playerScore = $playerScore * 0.5;
                    break;
                case 24:
                    $playerScore = $playerScore * 0.25;
                    break; 
                case 48:
                    $playerScore = $playerScore * 0.125;
                    break;  
                default:
                break;
            }
            $Insert = "INSERT INTO `races` (`player`, `score`, `position`) 
            VALUES ('$playerName', $playerScore, $playerPosition)";
            echo $Insert;
            $result = $conn->query($Insert);
            echo $result;    
        }
        $conn->close();
    }

    $handle = fopen('scores.csv','r');

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        add($data);
    }
    fclose($handle);
?>
