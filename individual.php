<?php

include "header.inc.php";
include "database.inc.php";
include "emoticon.class.php";

$emoticons = new Emoticons();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["action_id"]) && !empty($_GET["emoticon_id"]) && !empty($_GET["emoticon_type"])) {
        $emoticonId = fixInput($_GET["emoticon_id"]);
        $actionId = fixInput($_GET["action_id"]);
        $emoticonType = fixInput($_GET["emoticon_type"]);
        $emoticons->updateIcon($emoticonId, $actionId, playerId, $emoticonType);
    }
}

echo "<h1>Individual Statistics</h1><br>";
echo "<table><tr><th>Full Pushups</th><th>Knee Pushups</th><th>Wall Pushups</th><th>Date & Time</th></tr>";

$conn = new mysqli(db_host, db_user, db_password, db_name);
$queryResult = $conn->query("SELECT DATETIME, FULL, KNEE, WALL FROM PUSHUP WHERE USER_ID=".playerId." ORDER BY DATETIME DESC");
while ($row = $queryResult->fetch_assoc()) {
    echo "<tr><td>".$row["FULL"]."</td><td>".$row["KNEE"]."</td><td>".$row["WALL"]."</td><td>".$row["DATETIME"]."</td></tr>";
}
echo "</table>";