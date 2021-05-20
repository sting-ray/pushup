<?php

include "header.inc.php";
include "database.inc.php";
include "team.class.php";
include "map.class.php";
include "emoticon.class.php";

$emoticons = new Emoticons();
$map = new Map();
$team = makeTeams(); //returns array

foreach ($team as $t) {
    $t->putOnMap($map);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["action_id"]) && !empty($_GET["emoticon_id"]) && !empty($_GET["emoticon_type"])) {
        $emoticonId = fixInput($_GET["emoticon_id"]);
        $actionId = fixInput($_GET["action_id"]);
        $emoticonType = fixInput($_GET["emoticon_type"]);
        $emoticons->updateIcon($emoticonId, $actionId, playerId, $emoticonType);
    }
}


if ($team[playerTeamId]->getPoints() >= $team[playerTeamId]->getPointsNeeded($map)) {
    $team[playerTeamId]->calculateMovement($map, "up");
    $team[playerTeamId]->calculateMovement($map, "up_left");
    $team[playerTeamId]->calculateMovement($map, "up_right");
}

/* - Edited out to take away sideways movement.  Edit back in to allow sideways movement.
if ($team[playerTeamId]->getPoints() >= ($team[playerTeamId]->getPointsNeeded($map) / 2)) {
    $team[playerTeamId]->calculateMovement($map, "left");
    $team[playerTeamId]->calculateMovement($map, "right");
}
*/

echo "<h1>Map page</h1><br>";

echo "<div class='left'>";
echo "Your team is<br>";
echo $team[playerTeamId]->getFlag()."<br>";
echo $team[playerTeamId]->getName()."<p>";

$maxPoints = $team[playerTeamId]->getPointsNeeded($map) * 1.5;
if ($maxPoints == 0) {
    $maxPoints = "unlimited";
}

echo "Your team has: ".$team[playerTeamId]->getPoints()." points out of a maximum: ".$maxPoints."<br>";
echo "Your team needs: ".$team[playerTeamId]->getPointsNeeded($map)." points to move forwards.<br>";
// echo "Your team needs: ".($team[playerTeamId]->getPointsNeeded($map) / 2)." points to move sideways.<br>"; - Put back in to allow sideways movement


$map->drawEverything($team);

echo "</div><div class='right'>";


$conn = new mysqli(db_host, db_user, db_password, db_name);

$queryResult = $conn->query("SELECT FLAG, TEAM.NAME AS TEAM_NAME, USER.NAME AS USER_NAME, X, Y, DATETIME, TEAM_MOVE.ID AS TEAM_MOVE_ID FROM TEAM_MOVE LEFT JOIN TEAM ON TEAM_MOVE.TEAM_ID=TEAM.ID LEFT JOIN USER ON TEAM_MOVE.USER_ID=USER.ID ORDER BY DATETIME DESC LIMIT 5");
while ($row = $queryResult->fetch_assoc()) {
    echo "<img src='team_flags/".$row["FLAG"]."'>";
    echo "Team ".$row["TEAM_NAME"]." was moved to X: ".$row["X"]." and Y: ".$row["Y"];
    echo " by ".$row["USER_NAME"]." - <i>".$row["DATETIME"]."</i> ";
    echo $emoticons->getIcons($row["TEAM_MOVE_ID"], "TEAM_MOVE", "main.php");
    echo "<br>";
}
echo "<hr>";

$queryResult = $conn->query("SELECT USER.NAME AS USER_NAME, TEAM.NAME AS TEAM_NAME, FLAG, DATETIME, FULL, KNEE, WALL, PUSHUP.ID AS PUSHUP_ID FROM PUSHUP LEFT JOIN USER ON PUSHUP.USER_ID = USER.ID LEFT JOIN TEAM ON USER.TEAM_ID = TEAM.ID WHERE PRIVACY=4 OR (PRIVACY=3 AND TEAM.ID=".playerTeamId.") OR (PRIVACY=2 AND TEAM.CAPTAIN = ".playerId.") OR (USER.ID = ".playerId.") ORDER BY DATETIME DESC LIMIT 10");

while ($row = $queryResult->fetch_assoc()) {
    echo "<img src='team_flags/".$row["FLAG"]."'> <b>";
    echo $row["USER_NAME"]."</b> has done ";
    if ($row["FULL"] > 0) {
        echo $row["FULL"]." Full Pushups";
    }
    if ($row["KNEE"] > 0) {
        if ($row["FULL"] > 0 && ($row["WALL"] > 0 || $row["KNEE"])) {
            echo ", ".$row["KNEE"]." Pushups from the Knees";
        }
        else if ($row["FULL"] > 0) {
            echo " and ".$row["KNEE"]." Pushups from the Knees";
        }
        else {
            echo $row["KNEE"]." Pushups from the Knees";
        }
    }
    if ($row["WALL"] > 0) {
        if ($row["FULL"] > 0 || $row["KNEE"] > 0) {
            echo " and ".$row["WALL"]." Pushups done off the wall";
        }
        else {
            echo $row["WALL"]." Pushups done off the wall";
        }
    }
    echo " for team ".$row["TEAM_NAME"].". - <i>".$row["DATETIME"]."</i> ";
    echo $emoticons->getIcons($row["PUSHUP_ID"], "PUSHUP", "main.php");
    echo "<br>";
}

echo "</div>";