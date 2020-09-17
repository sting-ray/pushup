<?php

include "header.inc.php";
include "database.inc.php";
include "team.class.php";

$team = makeTeams(); //returns array

if (!empty($_GET["team"])) {
    $selectedTeam = fixInput($_GET["team"]);
}
else {
    $selectedTeam = $playerTeam;
}

echo "<h1>Team details</h1><br><table><tr>";

foreach ($team as $t) {
    echo "<td><a href='team.php?team=".$t->getId()."'>".$t->getFlag()."<br>".$t->getName()."</a></td>";
}

echo "</tr></table><p>";

echo "Details for team: ".$team[$selectedTeam]->getName()."<br>";
echo $team[$selectedTeam]->getFlag()."<p>";

echo "Captain: <br>";// TODO: should I do mysql here or in the object itself..?
echo "Points: ".$team[$selectedTeam]->getPoints()."<p>";

echo "<h2>Players</h2><br>";

$conn = new mysqli(db_host, db_user, db_password, db_name);
$queryResult = $conn->query("SELECT USER.ID, NAME, EMAIL FROM USER WHERE TEAM_ID=$selectedTeam");

//SELECT USER.ID, FULL, KNEE, WALL FROM PUSHUP LEFT JOIN USER ON PUSHUP.USER_ID=USER.ID LEFT JOIN TEAM ON USER.TEAM_ID=TEAM.ID WHERE TEAM.ID=1 AND (PRIVACY=3 OR (PRIVACY=2 AND TEAM.ID=1) OR (PRIVACY=1 AND TEAM.CAPTAIN = 1) OR (USER.ID = 1))
