<?php
session_start();
if (!isset($_SESSION["pushup_id"])) {
    header('Location: index.php');
    echo "Not logged in!";
    die();
}

if(!$_SESSION["pushup_team"]) {
    echo "Thank you for registering you will manually be put into a team soon and can then participate";
    session_destroy();
    die();
}

define("playerId", $_SESSION["pushup_id"]);
define("playerName", $_SESSION["pushup_name"]);
define("playerTeamId", $_SESSION["pushup_team"]);
//TODO: Create a page with the players individual stats


?>

<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='default.css'>
</head>

<body>

<?php
echo "Hello: ".playerName."<br>";

?>

<div class="pill-nav">
    <a href='main.php' id='main.php'>Map</a>
    <a href='pushup.php' id='pushup.php'>Pushups</a>
    <a href='team.php' id='team.php'>Team</a>
    <a href='individual.php' id='individual.php'>Individual</a>
    <a href='help.php' id='help.php'>Help</a>
    <a href='future.php' id='future.php'>Future</a>
    <a href='settings.php' id='settings.php'>Settings</a>
    <a href='logout.php' id='logout.php'>Log Out</a>
</div>

<script>
    var path = window.location.pathname;
    var page = path.split('/').pop();
    document.getElementById(page).className = 'active';
</script>