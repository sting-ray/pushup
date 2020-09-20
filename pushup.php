<?php

include "header.inc.php";
include "team.class.php";
include "database.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full = fixInput($_POST["full"]);
    $knee = fixInput($_POST["knee"]);
    $wall = fixInput($_POST["wall"]);

    if (array_key_exists("confirm", $_POST)) {
        if ($_POST["confirm"] == "yes") {
            $conn = new mysqli(db_host, db_user, db_password, db_name);
            $conn->query("INSERT INTO PUSHUP (USER_ID, FULL, KNEE, WALL) VALUES (".playerId.", $full, $knee, $wall)");
            //calculate points for each exercise type and update the team score.
            $newPoints = $full;
            $newPoints += $knee * 0.5;
            $newPoints += $wall * 0.25;
            $currentPoints = $conn->query("SELECT POINTS FROM TEAM WHERE ID=".playerTeamId)->fetch_object()->POINTS;
            $totalPoints = $currentPoints + $newPoints;
            $toLeave = $conn->query("SELECT TOLEAVE FROM MAP WHERE Y=(SELECT POSITION_Y FROM TEAM WHERE ID=".playerTeamId.") AND X=(SELECT POSITION_X FROM TEAM WHERE ID=".playerTeamId.")")->fetch_object()->TOLEAVE;
            $maxPoints = $toLeave * 1.5;
            if ($totalPoints > $maxPoints) {
                $totalPoints = $maxPoints;
            }
            $conn->query("UPDATE TEAM SET POINTS=$totalPoints WHERE ID".playerTeamId);
            echo "Points Updated!";
            header('Location: main.php');
            die();
        }
        else {
            echo "Not confirmed";
            header('Location: pushup.php');
            die();
        }
    }
    else {
        echo "<h1>Confirm Pushup Amount</h1><br>";
        echo "Please confirm these are the correct amounts of pushups that you did.<br>";
        echo "If you made a mistake you can select no to enter in the correct amounts.<br>";
        echo "Please be honest!<br>";
        echo "Full Pushups: $full<br>";
        echo "Knee Pushups: $knee<br>";
        echo "Wall Pushups: $wall<br>";
        echo "Is this the correct amount?";
        echo "<form action='pushup.php' method='post'>";
        echo "<input type='hidden' name='full' value='$full'>";
        echo "<input type='hidden' name='knee' value='$knee'>";
        echo "<input type='hidden' name='wall' value='$wall'>";
        echo "<input type='radio' name='confirm' value='yes' checked>Yes! || ";
        echo "<input type='radio' name='confirm' value='no'>No! <input type='submit'></form><br>";
    }
}
else {
    //https://www.topendsports.com/testing/records/pushups.htm
    //The world record for the most number of non-stop push-ups is 10,507 by Minoru Yoshida of Japan
    echo "<h1>Enter Pushups</h1><br>";
    echo "How many pushups have you just done?<br>";
    echo "<form action='pushup.php' method='post'>";
    echo "Full body Pushups: <input type='number' name='full' min='0' max='10507' value='0'><br>";
    echo "From the Knees: <input type='number' name='knee' min='0' max='10507' value='0'><br>";
    echo "If injured, from the wall: <input type='number' name='wall' min='0' max='10507' value='0'><br>";
    echo "<input type='submit'><p>";
}