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
//TODO: Create a settings page where the privacy setting can be updated and the password changed.
?>

<html>
<head>
<style>

table {
    border: 1px solid black;
    border-spacing: 0px;
    border-collapse: collapse;
}
td {
    padding: 0px;
    border: 1px solid black;
    //height:50px;
    //width:50px;
}
</style>
</head>
<body>

<?php
echo "Hello: ".playerName."<br>";
?>

<table><tr>
    <td><a href='main.php'>Main Page</a></td>
    <td><a href='pushup.php'>Enter Pushups</a></td>
    <td><a href='team.php'>Team Details</a></td>
    <td><a href='future.php'>Future Ideas</a></td>
    <td><a href='settings.php'>Settings</a></td>
    <td><a href='logout.php'>Log Out</a></td>
</tr></table><br>