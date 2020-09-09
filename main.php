<?php

include "header.inc.php";
include "database.inc.php";

echo "<h1>Main page</h1><br>";

$yourTeamId = $_SESSION["pushup_team"];
$conn = new mysqli(db_host, db_user, db_password, db_name);

$queryResult = $conn->query("SELECT * FROM MAP");
while ($row = $queryResult->fetch_assoc()) {
    $mapYX[$row["Y"]][$row["X"]]["status"] = $row["STATUS"];
    $mapYX[$row["Y"]][$row["X"]]["image"] = "<img src='map_icons/".$row["IMAGE"]."'>";
    $mapYX[$row["Y"]][$row["X"]]["toLeave"] = $row["TOLEAVE"];
    $mapYX[$row["Y"]][$row["X"]]["toArrive"] = $row["TOARRIVE"];
}

$queryResult = $conn->query("SELECT * FROM TEAM");
while ($row = $queryResult->fetch_assoc()) {
    if ($mapYX[$row["POSITION_Y"]][$row["POSITION_X"]]["status"] == 3) {
        $teamsAtStart[] = $row["ID"];
    }
    else if ($mapYX[$row["POSITION_Y"]][$row["POSITION_X"]]["status"] == 4) {
        $teamsAtFinish[] = $row["ID"];
    }
    else {
        $mapYX[$row["POSITION_Y"]][$row["POSITION_X"]]["status"] = 2;
        $mapYX[$row["POSITION_Y"]][$row["POSITION_X"]]["image"] = "<img src='team_flags/".$row["FLAG"]."'>";
    }

    if ($row["ID"] == $yourTeamId) {
        $yourTeamY = $row["POSITION_Y"];
        $yourTeamX = $row["POSITION_X"];
        $yourTeamPoints = $row["POINTS"];
        $yourTeamTarget = $mapYX[$row["POSITION_Y"]][$row["POSITION_X"]]["toLeave"];
        if ($mapYX[$row["POSITION_Y"]][$row["POSITION_X"]]["status"] == 4) {
            $move = false;
        }
        else {
            $move = true;
        }
    }
}

if ($yourTeamPoints >= $yourTeamTarget && $move == true) {
    //up
    $moveY = $yourTeamY - 1;
    $moveX = $yourTeamX;
    while ($move) {
        //if blocked or does not exist
        if ($mapYX[$moveY][$moveX]["status"] == null || $mapYX[$moveY][$moveX]["status"] == 1) {
            break;
        }
        //free space to move to
        else if ($mapYX[$moveY][$moveX]["status"] == 0 || $mapYX[$moveY][$moveX]["status"] == 4) {
            $mapYX[$moveY][$moveX]["image"] = "<img src='icons/up.png'>";
            break;
        }
        //jumping another team
        else if ($mapYX[$moveY][$moveX]["status"] == 2) {
            $moveY -= 1;
        }
    }
    //up left
    $moveY = $yourTeamY - 1;
    $moveX = $yourTeamX - 1;
    while ($move) {
        //if blocked or does not exist
        if ($mapYX[$moveY][$moveX]["status"] == null || $mapYX[$moveY][$moveX]["status"] == 1) {
            break;
        }
        //free space to move to
        else if ($mapYX[$moveY][$moveX]["status"] == 0 || $mapYX[$moveY][$moveX]["status"] == 4) {
            $mapYX[$moveY][$moveX]["image"] = "<img src='icons/up_left.png'>";
            break;
        }
        //jumping another team
        else if ($mapYX[$moveY][$moveX]["status"] == 2) {
            $moveY -= 1;
            $moveX -= 1;
        }
    }
    //up right
    $moveY = $yourTeamY - 1;
    $moveX = $yourTeamX + 1;
    while ($move) {
        //if blocked or does not exist
        if ($mapYX[$moveY][$moveX]["status"] == null || $mapYX[$moveY][$moveX]["status"] == 1) {
            break;
        }
        //free space to move to
        else if ($mapYX[$moveY][$moveX]["status"] == 0 || $mapYX[$moveY][$moveX]["status"] == 4) {
            $mapYX[$moveY][$moveX]["image"] = "<img src='icons/up_right.png'>";
            break;
        }
        //jumping another team
        else if ($mapYX[$moveY][$moveX]["status"] == 2) {
            $moveY -= 1;
            $moveX += 1;
        }
    }
}

if ($yourTeamPoints >= ($yourTeamTarget / 2) && $move == true) {
    //left
    $moveY = $yourTeamY;
    $moveX = $yourTeamX - 1;
    while ($move) {
        //if blocked or does not exist
        if ($mapYX[$moveY][$moveX]["status"] == null || $mapYX[$moveY][$moveX]["status"] == 1) {
            break;
        }
        //free space to move to
        else if ($mapYX[$moveY][$moveX]["status"] == 0 || $mapYX[$moveY][$moveX]["status"] == 4) {
            $mapYX[$moveY][$moveX]["image"] = "<img src='icons/left.png'>";
            break;
        }
        //jumping another team
        else if ($mapYX[$moveY][$moveX]["status"] == 2) {
            $moveX -= 1;
        }
    }
    //right
    $moveY = $yourTeamY;
    $moveX = $yourTeamX +1;
    while ($move) {
        //if blocked or does not exist
        if ($mapYX[$moveY][$moveX]["status"] == null || $mapYX[$moveY][$moveX]["status"] == 1) {
            break;
        }
        //free space to move to
        else if ($mapYX[$moveY][$moveX]["status"] == 0 || $mapYX[$moveY][$moveX]["status"] == 4) {
            $mapYX[$moveY][$moveX]["image"] = "<img src='icons/right.png'>";
            break;
        }
        //jumping another team
        else if ($mapYX[$moveY][$moveX]["status"] == 2) {
            $moveX += 1;
        }
    }
}
echo "Your team has: $yourTeamPoints out of it's limit of: ".($yourTeamPoints * 1.5)." points.<br>";
echo "To forwards your team needs: $yourTeamTarget points.<br>";
echo "To move sideways your team needs: ".($yourTeamTarget / 2)." points.<p>";

echo "<table>";
foreach ($mapYX as $y => $mapX) {
    echo "<tr>";
    foreach ($mapX as $x => $map) {
        echo "<td>".$map["image"]."</td>";
    }
    echo "</tr>";
}
echo "</table>";

/*
$allTeams = queryDatabase("SELECT * FROM TEAM", TRUE);

foreach ($allTeams as $singleTeam) {
    print_r($singleTeam);
    echo "<p>";

    $teamY = $singleTeam[0]["POSITION_Y"];
    $teamX = $singleTeam[0]["POSITION_X"];
    $teamFlag = $singleTeam[0]["FLAG"];
    if ($singleTeam[0]["ID"] == $yourTeamId) {
        $yourTeamY = $teamY;
        $yourTeamX = $teamX;
        $yourTeamPoints = $singleTeam[0]["POINTS"];
        $yourTeamName = $singleTeam[0]["NAME"];
    }
    $map[$teamX][$teamY][]
    //$boardYX[$teamY][$teamX] = $teamFlag;
}

$yourTeamPointTarget = ($yourTeamY + 1) * 200;
$yourTeamHalfTarget = $yourTeamPointTarget / 2;
$yourTeamPointLimit = $yourTeamPointTarget * 1.5;

echo "Your team ID is: $yourTeamId.<br>";
echo "Your team name is: $yourTeamName.<br>";
echo "Your team currently has: $yourTeamPoints points.<br>";
echo "Your team can move forwards when they reach: $yourTeamPointTarget points.<br>";
echo "Your team will be able to move sideways when they reach: $yourTeamHalfTarget points.<br>";
echo "The maximum amount of points your team can store without moving is: $yourTeamPointLimit points<br>";
/*
//calculate moving forwards
//check the square infront of you, is it empty?
$targetFinish = "no";
$targetY = $yourTeamY + 1;
$targetX = $yourTeamX;
while ($targetY < 10) {
    if (($targetY == 9 and $targetX != 3) or
        ($targetY == 8 and ($targetX == 1 or $targetX == 2 or $targetX == 4 or $targetX==5)) or
        ($targetY == 7 and ($targetX == 1 or $targetX == 5))) {
        break;
    }
    else if ($targetY == 9 and $targetX == 3) {
        $targetFinish = "up";
    }
    else if ($boardYX[$targetY][$targetX]) {
        $targetY += 1;
    }
    else {
        $boardYX[$targetY][$targetX] = "up.jpg";
        break;
    }
}



echo "<table>";
if ($targetFinish == "no") {
    echo "<tr><td colspan='2'><td>finish.jpg</td><td colspan='2'></td></tr>";
    }
else if ($targetFinish == "up") {
    echo "<tr><td colspan='2'><td>up.jpg</td><td colspan='2'></td></tr>";
}
for ($loopY = 8; $loopY != 0; $loopY--) {
    echo "<tr>";
    for ($loopX = 1; $loopX < 6; $loopX++) {
        echo "<td>".$boardYX[$loopY][$loopX]."</td>";
    }
    echo "</tr>";
}
echo "<tr><td colspan='2'><td>start.jpg</td><td colspan='2'></td></tr>";

echo "</table>";

print_r($boardYX);
*/