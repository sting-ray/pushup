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

function expandSeconds($totalSeconds) {
    $days = floor($totalSeconds / 86400);
    $totalSeconds = ($totalSeconds % 86400);
    $hours = floor($totalSeconds / 3600);
    $totalSeconds %= 3600;
    $minutes = floor($totalSeconds / 60);
    $totalSeconds %= 60;
    $seconds = floor($totalSeconds);

    $result = "";
    if ($days) {
        if ($days == 1) {
            $result .= "$days day, ";
        }
        else {
            $result .= "$days days, ";
        }
    }
    if ($hours) {
        if ($hours == 1) {
            $result .= "$hours hour, ";
        }
        else {
            $result .= "$hours hours, ";
        }
    }
    if ($minutes) {
        if ($minutes ==1) {
            $result .= "$minutes minute and ";
        }
        else {
            $result .= "$minutes minutes and ";
        }
    }
    if ($seconds == 1) {
        $result .= "$seconds second";
    }
    else {
        $result .= "$seconds seconds";
    }
    return $result;
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