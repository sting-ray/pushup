<?php

include "database.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $name = fixInput($_POST["name"]);
        $email = fixInput($_POST["email"]);
        $password = makePassword($_POST["password"]);
        $sponser = fixInput($_POST["sponser"]);
        $privacy = fixInput($_POST["privacy"]);
        if (queryDatabase("SELECT ID FROM USER WHERE EMAIL='$email'") == null) {
            $sql = "INSERT INTO USER (NAME, EMAIL, PASSWORD, SPONSER, PRIVACY) VALUES ('$name','$email','$password','$sponser', '$privacy');";
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
        Email: <input type='email' name='email'><i>Use your Quest email if you are a Quest employee</i><br>
        Password: <input type='password' name='password'>
         <i>Do not use a password you care about or use elsewhere.
         This server is not very secure so it could get stolen.<br></i>
        Sponser: <input type='text' name='sponser'>
         <i>If you do not work at Quest, please provide the email address of the employee at Quest who referred you here.</i><br>
         Privacy: <select name='privacy'>
            <option value='1'>Only you and the admins can see your pushups</option>
            <option value='2'>Pushups visible to your team leader and admins</option>
            <option value='3'>Pushups visible to your entire team and admins</option>
            <option value='4'>Pushups visible to everybody in the competition</option>
        </select><br>
        <input type='submit'><p>
    ";
}