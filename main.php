<?php

include "header.inc.php";
include "database.inc.php";
include "team.class.php";
include "map.class.php";

echo "<h1>Main page</h1><br>";

$map = new Map();
$team = makeTeams(); //returns array

foreach ($team as $t) {
    $t->putOnMap($map);
}


if ($team[$_SESSION["pushup_team"]]->getPoints() >= $team[$_SESSION["pushup_team"]]->getPointsNeeded($map)) {
    $team[$_SESSION["pushup_team"]]->calculateMovement($map, "up");
    $team[$_SESSION["pushup_team"]]->calculateMovement($map, "up_left");
    $team[$_SESSION["pushup_team"]]->calculateMovement($map, "up_right");
}

if ($team[$_SESSION["pushup_team"]]->getPoints() >= ($team[$_SESSION["pushup_team"]]->getPointsNeeded($map) / 2)) {
    $team[$_SESSION["pushup_team"]]->calculateMovement($map, "left");
    $team[$_SESSION["pushup_team"]]->calculateMovement($map, "right");
}

echo "Your team has: ".$team[$_SESSION["pushup_team"]]->getPoints()." points.<br>";
echo "Your team needs: ".$team[$_SESSION["pushup_team"]]->getPointsNeeded($map)." points.<br>";
echo $map->drawMap();
