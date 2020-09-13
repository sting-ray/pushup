<?php
session_start();
if (!isset($_SESSION["pushup_id"])) {
    header('Location: index.php');
    echo "Not logged in!";
    die();
}

if(!$_SESSION["pushup_team"]) {
    echo "Thank you for registering you will manually be put into a team soon and can then participate";
    die();
}

$playerId = $_SESSION["pushup_id"];
$playerName = $_SESSION["pushup_name"];
$playerTeam = $_SESSION["pushup_team"];

?>

<html>
<head>
<style>
table {
    border: 1px solid black;
}
td {
    border: 1px solid black;
    //height:50px;
    //width:50px;
}
</style>
</head>
<body>

<?php
echo "Hello: $playerName<br>";
?>

<table><tr>
    <td><a href='main.php'>Main Page</a></td>
    <td><a href='pushup.php'>Enter Pushups</a></td>
    <td><a href='logout.php'>Log Out</a></td>
</tr></table><br>