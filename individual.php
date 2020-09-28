<?php

include "header.inc.php";
include "database.inc.php";


echo "<h1>Individual Statistics</h1><br>";
echo "<table><tr><th>Full Pushups</th><th>Knee Pushups</th><th>Wall Pushups</th><th>Date & Time</th></tr>";

$conn = new mysqli(db_host, db_user, db_password, db_name);
$queryResult = $conn->query("SELECT DATETIME, FULL, KNEE, WALL FROM PUSHUP WHERE USER_ID=".playerId." ORDER BY DATETIME DESC");
while ($row = $queryResult->fetch_assoc()) {
    echo "<tr><td>".$row["FULL"]."</td><td>".$row["KNEE"]."</td><td>".$row["WALL"]."</td><td>".$row["DATETIME"]."</td></tr>";
}
echo "</table>";