<?php

include "database.inc.php";


session_start();

$conn = new mysqli(db_host, db_user, db_password, db_name);
$playerId = $_SESSION["pushup_id"];
$conn->query("DELETE FROM AUTH_TOKENS WHERE USER_ID = $playerId");
setcookie("selector", "", time() - 3600, "/");
setcookie("validator", "", time() - 3600, "/");

session_destroy();


header('Location: index.php');
echo "logged out";