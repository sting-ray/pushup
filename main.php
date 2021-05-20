<?php

include "header.inc.php";
include "database.inc.php";

echo "<h1>Main page</h1><br>";

$conn = new mysqli(db_host, db_user, db_password, db_name);
$queryGames = $conn->query("SELECT NAME FROM GAME LEFT JOIN GAME_USER_JT ON GAME.ID = GAME_USER_JT.GAME_ID WHERE GAME_USER_JT.USER_ID = ".playerId);

echo "<a href='create_game.php'><img src='icons/new_game.png'><br>Create New Game</a>";