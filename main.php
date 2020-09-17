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

if ($team[$playerTeam]->getPoints() >= $team[$playerTeam]->getPointsNeeded($map)) {
    $team[$playerTeam]->calculateMovement($map, "up");
    $team[$playerTeam]->calculateMovement($map, "up_left");
    $team[$playerTeam]->calculateMovement($map, "up_right");
}

if ($team[$playerTeam]->getPoints() >= ($team[$playerTeam]->getPointsNeeded($map) / 2)) {
    $team[$playerTeam]->calculateMovement($map, "left");
    $team[$playerTeam]->calculateMovement($map, "right");
}

echo "<h1>Main page</h1><br>";

echo "Your team is<br>";
echo $team[$playerTeam]->getFlag()."<br>";
echo $team[$playerTeam]->getName()."<p>";

echo "Your team has: ".$team[$playerTeam]->getPoints()." points out of a maximum: ".($team[$playerTeam]->getPointsNeeded($map) * 1.5)."<br>";
echo "Your team needs: ".$team[$playerTeam]->getPointsNeeded($map)." points to move forwards.<br>";
echo "Your team needs: ".($team[$playerTeam]->getPointsNeeded($map) / 2)." points to move sideways.<br>";
echo $map->drawMap();

//Get history Items.


//TODO: Query database using below query
//Create a table recording the history of the movement of a team
//Make sure when a team moves, this table is being updated.
//Create a query here to show these moves as well.
$conn = new mysqli(db_host, db_user, db_password, db_name);
$queryResult = $conn->query("SELECT USER.NAME AS USER_NAME, TEAM.NAME AS TEAM_NAME, FLAG, DATETIME, FULL, KNEE, WALL FROM PUSHUP LEFT JOIN USER ON PUSHUP.USER_ID = USER.ID LEFT JOIN TEAM ON USER.TEAM_ID = TEAM.ID WHERE PRIVACY=3 OR (PRIVACY=2 AND TEAM.ID=$playerTeam) OR (PRIVACY=1 AND TEAM.CAPTAIN = $playerId) OR (USER.ID = $playerId) ORDER BY DATETIME DESC");

while ($row = $queryResult->fetch_assoc()) {
    echo "<img src='team_flags/".$row["FLAG"]."'> ".$row["DATETIME"]." - <b>".$row["USER_NAME"]."</b> has done: ".$row["FULL"]." Full Pushups, ".$row["KNEE"]. " pushups from the knees and ".$row["WALL"]." pushups from the wall.<br>";
}
