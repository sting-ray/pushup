<?php

include "header.inc.php";
include "team.class.php";
include "map.class.php";
include "database.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full = fixInput($_POST["full"]);
    $knee = fixInput($_POST["knee"]);
    if ($knee > 50) {
        $knee = 50;
    }
    $wall = fixInput($_POST["wall"]);
    if ($wall > 20) {
        $wall = 20;
    }

    if (array_key_exists("confirm", $_POST)) {
        if ($_POST["confirm"] == "yes") {
            $team = new Team(playerTeamId, false);
            $map = new Map();

            $conn = new mysqli(db_host, db_user, db_password, db_name);
            $conn->query("INSERT INTO PUSHUP (USER_ID, FULL, KNEE, WALL) VALUES (".playerId.", $full, $knee, $wall)");
            //calculate points for each exercise type and update the team score.
            $newPoints = $full;
            $newPoints += $knee * 0.5;
            $newPoints += $wall * 0.25;
            $currentPoints = $team->getPoints();
            $totalPoints = $currentPoints + $newPoints;
            $toLeave = $team->getPointsNeeded($map);
            $maxPoints = $toLeave * 1.5;
            if ($totalPoints > $maxPoints && $maxPoints != 0) {
                $totalPoints = $maxPoints;
            }
            $conn->query("UPDATE TEAM SET POINTS=$totalPoints WHERE ID=".playerTeamId);
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
        //check to make sure there is at least a 5 minute gap between submissions.
        $conn = new mysqli(db_host, db_user, db_password, db_name);
        $seconds = $conn->query("SELECT TIMESTAMPDIFF(SECOND, (SELECT DATETIME FROM PUSHUP WHERE USER_ID=".playerId." ORDER BY DATETIME DESC LIMIT 1), now()) AS SECONDS")->fetch_object()->SECONDS;
        if ($seconds > 300 || $seconds == null) {
            echo "<h1>Confirm Pushup Amount</h1><br>";
            echo "Please confirm these are the correct amounts of pushups that you did.<br>";
            echo "If you made a mistake you can select no to enter in the correct amounts.<br>";
            echo "<b>Please be honest!</b><p>";
            echo "<b>Full</b> Pushups: <b>$full</b><br>";
            echo "<b>Knee</b> Pushups: <b>$knee</b><br>";
            echo "<b>Wall</b> Pushups: <b>$wall</b>";
            echo "<p class='alert'>Is this the correct amount?</p>";
            echo "<form action='pushup.php' method='post'>";
            echo "<input type='hidden' name='full' value='$full'>";
            echo "<input type='hidden' name='knee' value='$knee'>";
            echo "<input type='hidden' name='wall' value='$wall'>";
            echo "<input type='radio' name='confirm' value='yes' checked>Yes! || ";
            echo "<input type='radio' name='confirm' value='no'>No! <input type='submit'></form><br>";
        }
        else {
            echo "<h1>Confirm Pushup Amount</h1><br>";
            echo "You have just entered in your pushups just ".expandSeconds($seconds)." ago.<br>";
            echo "There is a limit of 1 entry every 5 minutes<br>";
        }


    }
}
else {
    //https://www.topendsports.com/testing/records/pushups.htm
    //The world record for the most number of non-stop push-ups is 10,507 by Minoru Yoshida of Japan
    echo "<h1>Enter Pushups</h1><br>";
    echo "How many pushups have you just done?<br>";
    echo "<form action='pushup.php' method='post'>";
    echo "Full body Pushups: <input type='number' name='full' min='0' max='10507' value='0'><br>";
    echo "From the Knees: <input type='number' name='knee' min='0' max='50' value='0'><i>*Max 50 <small>per session</small></i><br>";
    echo "If injured, from the wall: <input type='number' name='wall' min='0' max='20' value='0'><i>*Max 20 <small>per session</small></i><br>";
    echo "<input type='submit'><p>";
}

include "help_pushup.html";