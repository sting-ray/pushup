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

echo "Your team has: ".$team[$playerTeam]->getPoints()." points out of a maximum: ".($team[$playerTeam]->getPointsNeeded($map) * 1.5)."<br>";
echo "Your team needs: ".$team[$playerTeam]->getPointsNeeded($map)." points to move forwards.<br>";
echo "Your team needs: ".($team[$playerTeam]->getPointsNeeded($map) / 2)." points to move sideways.<br>";
echo $map->drawMap();
