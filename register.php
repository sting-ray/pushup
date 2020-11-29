<?php

include "database.inc.php";

//TODO: Add more form verification to ensure people don't trigger a mysql error.
//This could be done in theory if somebody posts bogus values for number fields, makes the length to large, too small etc.
//The result is mysql displaying the insert code on the webpage (at least when php is configured to do that).

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $name = fixInput($_POST["name"]);
        $email = fixInput($_POST["email"]);
        $password = makePassword($_POST["password"]);
        $sponser = fixInput($_POST["sponser"]);
        $privacy = fixInput($_POST["privacy"]);
        $pushups = fixInput($_POST["pushups"]);
        if ($pushups == null) {
            $pushups = 0;
        }
        $type = fixInput($_POST["type"]);
        if (queryDatabase("SELECT ID FROM USER WHERE EMAIL='$email'") == null) {
            $sql = "INSERT INTO USER (NAME, EMAIL, PASSWORD, SPONSER, PRIVACY, PUSHUP_ESTIMATE, PUSHUP_ESTIMATE_TYPE) VALUES ('$name','$email','$password','$sponser', '$privacy', '$pushups', '$type');";
            if (updateDatabase($sql)) {
                echo "Thank you for registering.<br>";
                echo "<b>You will need to wait for an admin to verify you and add you to a team</b><p>";
                echo "Once you have been added to a team you will receive an email from me. You will then be able to to login from the <a href='index.php'>front page</a> once the competititon starts<br>";
                echo "In the meantime, here are the instrustions for the competition:<p>";
                echo "<hr><p>";
                include "help.html";

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
        Register here, for the pushup competition.  Any questions send me an email.<p>

        <form action='register.php' method='post'>
        <table>
        <tr><th>Name:</th><td><input type='text' name='name'><i>* Full name, not nick name</i></td></tr>
        <tr><th>Email:</th><td><input type='email' name='email'><i>* Use Quest email if Quest employee</i></td></tr>
        <tr><th>Password:</th><td><input type='password' name='password'><i>* Password sent in plain text.  No Password restristions, but don't re-use a password that you use for important things</i></td></tr>
        <tr><th>Sponser:</th><td><input type='text' name='sponser'><i>* Who referred you here.  Important if you are outside of Quest so I can verify you.</i></td></tr>
        <tr><th>Privacy:</th><td><select name='privacy'>
            <option value='1'>Only you and the admins can see your pushups</option>
            <option value='2'>Pushups visible to your team leader and admins</option>
            <option value='3'>Pushups visible to your entire team and admins</option>
            <option value='4' selected>Pushups visible to everybody in the competition</option>
        </select></td></tr>
        </table>
        In a session how many: <input type='number' name='pushups' min='0' max='2000' value='0'> <select name='type'>
            <option value='full'>Full Pushups (hard)</option>
            <option value='knee'>Pushups from the knees (medium)</option>
            <option value='wall'>Pushups off the wall (easy)</option>
        </select> do you think you can do currently?<br>
        <input type='submit'><p>
    ";
}

include 'help_pushup.html';