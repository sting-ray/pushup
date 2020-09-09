<?php

include "database.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $name = fixInput($_POST["name"]);
        $email = fixInput($_POST["email"]);
        $password = makePassword($_POST["password"]);
        $sponser = fixInput($_POST["sponser"]);
        if (queryDatabase("SELECT ID FROM USER WHERE EMAIL='$email'") == null) {
            $sql = "INSERT INTO USER (NAME, EMAIL, PASSWORD, SPONSER) VALUES ('$name','$email','$password','$sponser');";
            if (updateDatabase($sql)) {
                echo "New record created successfully";
            }
        }
        else {
            echo "You have already registered with this email address!<br>";
        }

    }
    else {
        echo "Name, email or password was missing!";
    }
}
else {
    echo "
        <html>
        <body>
        <h2>Register for the pushup competition</h2><p>
        Here is where you can register for my pushup competition.<br>
        Make sure to use your work email address and real name so I know who you are<br>
        Once you are registered I will place you in a team<p>

        <form action='register.php' method='post'>
        Name: <input type='text' name='name'><br>
        Email: <input type='text' name='email'><br>
        Password: <input type='password' name='password'><br>
         <i>Do not use a password you care about or use elsewhere.<br>
         This server is not very secure so it could get stolen<br></i>
        Sponser: <input type='text' name='sponser'><br>
         <i>If you do not work at Quest, please provide the email address of the employee at Quest who referred you here.<i/><br>
        <input type='submit'><p>
    ";
}