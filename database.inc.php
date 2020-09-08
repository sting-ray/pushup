<?php

include "config.inc.php";

function inputFix($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function makePassword($password, $config) {
    $fixedPassword = crypt($password, $config["salt"]);
    return $fixedPassword;
}