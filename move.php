<?php

include "header.inc.php";
include "database.inc.php";
include "team.class.php";
include "map.class.php";

$map = new Map();
$team = makeTeams(); //returns array

foreach ($team as $t) {
    $t->putOnMap($map);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_GET["move"]) && $_POST["confirm"] == "yes") {
        $move = fixInput($_GET["move"]);
        $teamPoints = $team[$playerTeam]->getPoints();
        switch ($move) {
            case "up":
            case "up_left":
            case "up_right":
                $pointsNeeded = $team[$playerTeam]->getPointsNeeded($map);
                break;
            case "left":
            case "right":
                $pointsNeeded = ($team[$playerTeam]->getPointsNeeded($map) / 2);
                break;
            default:
                echo "Invalid move!";
                header('Location: main.php');
                die();
                break;
        }
        if ($teamPoints >= $pointsNeeded) {
            $moveYX = $team[$playerTeam]->calculateMovement($map, $move);
            if ($moveYX) {
                $conn = new mysqli(db_host, db_user, db_password, db_name);
                $updatedPoints = $teamPoints - $pointsNeeded;
                $moveY = $moveYX["y"];
                $moveX = $moveYX["x"];
                $conn->query("UPDATE TEAM SET POINTS=$updatedPoints, POSITION_Y=$moveY, POSITION_X=$moveX WHERE ID=$playerTeam");
                echo "Movement Updated!";
                header('Location: main.php');
            }
        }
    }
    else {
        echo "Invalid entry or not confirmed!";
        header('Location: main.php');
        die();
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["move"])) {
        $move = fixInput($_GET["move"]);
        $teamPoints = $team[$playerTeam]->getPoints();
        switch ($move) {
            case "up":
            case "up_left":
            case "up_right":
                $pointsNeeded = $team[$playerTeam]->getPointsNeeded($map);
                break;
            case "left":
            case "right":
                $pointsNeeded = ($team[$playerTeam]->getPointsNeeded($map) / 2);
                break;
            default:
                echo "Invalid move!";
                header('Location: main.php');
                die();
                break;
        }

        if ($teamPoints >= $pointsNeeded) {
            if (!$team[$playerTeam]->calculateMovement($map, $move)) {
                echo "Invalid move!";
                header('Location: main.php');
                die();
            }
        }
        else {
            echo "Not enough points";
            header('Location: main.php');
            die();
        }

        echo "You are about to move $move.<br>";
        echo "This will use $pointsNeeded points out of your team's total of $teamPoints points.<br>";
        echo "Are you sure you want to make this move?: <form action='move.php?move=$move' method='post'>";
        echo "<input type='radio' name='confirm' value='yes' checked>Yes! || ";
        echo "<input type='radio' name='confirm' value='no'>No! <input type='submit'></form><br>";
        echo $map->drawMap();
    }
    else {
        echo "Invalid entry!";
        header('Location: main.php');
        die();
    }
}
else {
    echo "No move specified!";
    header('Location: main.php');
    die();
}