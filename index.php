<?php

include "database.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = fixInput($_POST["email"]);
        $password = makePassword($_POST["password"]);
        if ($user = queryDatabase("SELECT ID, NAME, TEAM_ID FROM USER WHERE EMAIL='$email' AND PASSWORD='$password'")) {
            session_start();
            $_SESSION["pushup_id"] = $user["ID"];
            $_SESSION["pushup_name"] = $user["NAME"];
            $_SESSION["pushup_team"] = $user["TEAM_ID"];
            header('Location: main.php');
            echo "logged in!";
        }
        else {
            echo "wrong email or password";
        }
    }
}
else {
    echo "
        <html>
        <body>
        <h1>Pushup</h1><p>
        <h2>login:</h2><br>
        <form action='index.php' method='post'>
        Email: <input type='text' name='email'><br>
        Password: <input type='password' name='password'><br>
        <input type='submit'><p>

        <a href='register.php'>Signup as a new user</a>
    ";
}