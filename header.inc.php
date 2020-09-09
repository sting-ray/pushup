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
?>

<html>
<head>
<style>
table {
    border: 1px solid black;
}
td {
    border: 1px solid black;
    height:50px;
    width:50px;
}
</style>
</head>
<body>

<?php
echo "Hello: ".$_SESSION["pushup_name"];
?>

<table><tr>
    <td><a href='main.php'>MAIN</a></td>
    <td><a href='logout.php'>LOG OUT</a></td>
</tr></table><br>