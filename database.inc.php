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

function queryDatabase($sql, $returnArray = false) {
    $conn = new mysqli(db_host, db_user, db_password, db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $queryResult =  $conn->query($sql);

    if ($queryResult->num_rows == 0) {
        return null;
    }
    else {
        if (!$returnArray) {
            return $queryResult->fetch_assoc();
        }
        else {
        $result = array();
            while ($row = $queryResult->fetch_assoc()) {
                $result[][] = $row;
            }
            return $result;
        }
    }
}