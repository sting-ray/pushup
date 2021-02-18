<?php

include "header.inc.php";
include "database.inc.php";
include "team.class.php";
include "map.class.php";
include "emoticon.class.php";

$emoticons = new Emoticons();
$team = makeTeams(false); //returns array

echo "<h1>Full Game History</h1><br>";

$conn = new mysqli(db_host, db_user, db_password, db_name);

$queryResult = $conn->query("SELECT TEAM.ID AS TEAM_ID, FLAG, TEAM.NAME AS TEAM_NAME, USER.NAME AS USER_NAME, X, Y, DATETIME, TEAM_MOVE.ID AS TEAM_MOVE_ID FROM TEAM_MOVE LEFT JOIN TEAM ON TEAM_MOVE.TEAM_ID=TEAM.ID LEFT JOIN USER ON TEAM_MOVE.USER_ID=USER.ID ORDER BY DATETIME ASC");
while ($row = $queryResult->fetch_assoc()) {
    echo "<img src='team_flags/".$row["FLAG"]."'>";
    echo "Team ".$row["TEAM_NAME"]." was moved to X: ".$row["X"]." and Y: ".$row["Y"];
    echo " by ".$row["USER_NAME"]." - <i>".$row["DATETIME"]."</i> ";
    echo $emoticons->getIcons($row["TEAM_MOVE_ID"], "TEAM_MOVE", "main.php");
    echo "<br>";

    $team[$row["TEAM_ID"]]->updatePosition($row["X"],$row["Y"], $row["DATETIME"]);
    //TODO: Re-write the code so it is not constantly destroying and re-building a class (involving database calls) constantly
    $map = new Map();
    foreach ($team as $t) {
        $t->putOnMap($map);
    }

    $map->drawEverything($team);
    unset($map);
    echo "<hr>";
}