<?php

include "header.inc.php";
include "database.inc.php";
include "team.class.php";

$team = makeTeams(); //returns array

if (!empty($_GET["team"])) {
    $selectedTeam = fixInput($_GET["team"]);
}
else {
    $selectedTeam = playerTeamId;
}

echo "<h1>Team details</h1><br><table><tr>";

foreach ($team as $t) {
    echo "<td><a href='team.php?team=".$t->getId()."'>".$t->getFlag()."<br>".$t->getName()."</a></td>";
}

echo "</tr></table><p>";

echo "Details for team: ".$team[$selectedTeam]->getName()."<br>";
echo $team[$selectedTeam]->getFlag()."<p>";

echo "Captain: ".$team[$selectedTeam]->getCaptainName()."<br>";
echo "Points: ".$team[$selectedTeam]->getPoints()."<p>";

echo "<h2>Players</h2><br>";

$conn = new mysqli(db_host, db_user, db_password, db_name);
$queryResult = $conn->query("SELECT USER.ID, NAME, EMAIL FROM USER WHERE TEAM_ID=$selectedTeam");

while ($row = $queryResult->fetch_assoc()) {
    $user[$row["ID"]]["name"] = $row["NAME"];
    $user[$row["ID"]]["email"] = $row["EMAIL"];
    $user[$row["ID"]]["full"] = 0;
    $user[$row["ID"]]["knee"] = 0;
    $user[$row["ID"]]["wall"] = 0;
}

$queryResult = $conn->query("SELECT USER.ID, FULL, KNEE, WALL FROM PUSHUP LEFT JOIN USER ON PUSHUP.USER_ID=USER.ID LEFT JOIN TEAM ON USER.TEAM_ID=TEAM.ID WHERE TEAM.ID=$selectedTeam AND (PRIVACY=3 OR (PRIVACY=2 AND TEAM.ID=".playerTeamId.") OR (PRIVACY=1 AND TEAM.CAPTAIN = ".playerId.") OR (USER.ID = 1))");
while ($row = $queryResult->fetch_assoc()) {
    $user[$row["ID"]]["full"] += $row["FULL"];
    $user[$row["ID"]]["knee"] += $row["KNEE"];
    $user[$row["ID"]]["wall"] += $row["WALL"];
}

echo "<table><tr><th>Name</th><th>Email</th><th>Full</th><th>Knee</th><th>Wall</th></tr>";
foreach ($user as $row) {
    echo "<tr><td>".$row["name"]."</td>";
    echo "<td>".$row["email"]."</td>";
    echo "<td>".$row["full"]."</td>";
    echo "<td>".$row["knee"]."</td>";
    echo "<td>".$row["wall"]."</td></tr>";
}

echo "</table>";
