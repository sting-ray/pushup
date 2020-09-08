<?php

include "config.inc.php";

function fixInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function makePassword($password) {
    $fixedPassword = crypt($password, salt);
    return $fixedPassword;
}

function updateDatabase($sql) {
    $conn = new mysqli(db_host, db_user, db_password, db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($conn->query($sql) === TRUE) {
        return TRUE;
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function queryDatabase($sql) {
    $conn = new mysqli(db_host, db_user, db_password, db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn->query($sql);
}