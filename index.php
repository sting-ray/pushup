<?php

include "database.inc.php";
include "team.class.php";
include "map.class.php";

session_start();
$conn = new mysqli(db_host, db_user, db_password, db_name);

if (isset($_SESSION["pushup_id"])) {
    header('Location: main.php');
    echo "re-directing to main.php";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = fixInput($_POST["email"]);
        $password = makePassword($_POST["password"]);
        if ($user = queryDatabase("SELECT ID, NAME, TEAM_ID FROM USER WHERE EMAIL='$email' AND PASSWORD='$password'")) {
            $userId = $user["ID"];
            $_SESSION["pushup_id"] = $user["ID"];
            $_SESSION["pushup_name"] = $user["NAME"];
            $_SESSION["pushup_team"] = $user["TEAM_ID"];
            if ($_POST["remember"]) {
                //https://www.w3docs.com/snippets/php/how-to-generate-a-random-string-with-php.html
                $selector = bin2hex(random_bytes(6));
                $validator = bin2hex(random_bytes(32));
                $validatorHash = makePassword($validator);
                $expires = time() + (86400 * 30); //86400 = 1 day
                setcookie("selector", $selector, $expires, "/");
                setcookie("validator", $validator, $expires, "/");
                $conn->query("INSERT INTO AUTH_TOKENS (SELECTOR, VALIDATOR, USER_ID, EXPIRES) VALUES ('$selector', '$validatorHash', '$userId', FROM_UNIXTIME($expires))");
            }
            header('Location: main.php');
            echo "logged in!";
        }
        else {
            echo "Wrong email or password";
        }
    }
}

if (isset($_COOKIE["selector"])) {
    //https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
    $selectorCookie = fixInput($_COOKIE["selector"]);
    $validatorCookie = makePassword($_COOKIE["validator"]);

    if ($userAuth = $conn->query("SELECT VALIDATOR, USER_ID, UNIX_TIMESTAMP(EXPIRES) AS EXPIRES FROM AUTH_TOKENS WHERE SELECTOR='$selectorCookie'")->fetch_assoc()) {
        if (($userAuth["VALIDATOR"] == $validatorCookie) && ($userAuth["EXPIRES"] > time())) {
            $user = $conn->query("SELECT ID, NAME, TEAM_ID FROM USER WHERE ID=".$userAuth["USER_ID"])->fetch_assoc();
            $_SESSION["pushup_id"] = $user["ID"];
            $_SESSION["pushup_name"] = $user["NAME"];
            $_SESSION["pushup_team"] = $user["TEAM_ID"];
            header('Location: main.php');
            echo "logged in!";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='default.css'>
</head>

<?php

$seconds = $conn->query("SELECT TIMESTAMPDIFF(SECOND, now(), (SELECT START FROM SETTINGS LIMIT 1)) AS SECONDS")->fetch_object()->SECONDS;
if ($seconds < 0 || $seconds == null) {
    echo "
    <body>
    <h1>Pushup</h1><p>
    <h2>login:</h2><br>
    <form action='index.php' method='post'>
    Email: <input type='text' name='email'><br>
    Password: <input type='password' name='password'><br>
    <input type='checkbox' name='remember' checked>Stay logged in after browser is closed?<br>
    <input type='submit'><p>";
}
else {
    echo "<body><h1>Pushup</h1><p>";
    echo "Competition has not started yet.<br>";
    echo "Login will be available in: ".expandSeconds($seconds).".<p>";
}

echo "<a href='register.php'>Signup as a new user</a><br>";
echo "<a href='help.html'>The rules of this competition</a><p>";

$map = new Map();
$team = makeTeams(); //returns array

foreach ($team as $t) {
    $t->putOnMap($map);
}

$map->drawEverything($team);