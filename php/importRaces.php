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
            $Insert = "INSERT INTO `scores` (`player`, `score`, `races`, `total_pos`) 
            VALUES ('$playerName', $playerScore, 1, $playerPosition) 
            ON DUPLICATE KEY UPDATE `player` =  '$playerName', `score` = `score` +  $playerScore,
            `races` =`races` +  1, `total_pos` = `total_pos` +  $playerPosition";
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
