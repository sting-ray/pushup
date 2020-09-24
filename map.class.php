<?php

//for creating the main player map
class Map {
    private $mapYX = array();
    private $teamsAtStart = array();
    private $teamsAtFinish = array();

    function __construct() {
        $conn = new mysqli(db_host, db_user, db_password, db_name);
        $queryResult = $conn->query("SELECT * FROM MAP");
        while ($row = $queryResult->fetch_assoc()) {
            $this->mapYX[$row["Y"]][$row["X"]]["status"] = $row["STATUS"];
            $this->mapYX[$row["Y"]][$row["X"]]["image"] = "<img src='map_icons/".$row["IMAGE"]."'>";
            $this->mapYX[$row["Y"]][$row["X"]]["toLeave"] = $row["TOLEAVE"];
            $this->mapYX[$row["Y"]][$row["X"]]["toArrive"] = $row["TOARRIVE"];
        }
    }

    function drawMap() {
        $result = "<table class='map'>";
        foreach ($this->mapYX as $y => $mapX) {
            $result .= "<tr>";
            foreach ($mapX as $x => $map) {
                $result .= "<td class='map' title='Points needed to move off this tile: ".$map["toLeave"]."'>".$map["image"]."</td>";
            }
            $result .= "</tr>";
        }
        $result .= "</table><br>";
        return $result;
    }

    function drawTeamsAtStart() {
        $result = "";
        foreach($this->teamsAtStart as $team) {
            $result .= $team." ";
        }
        return $result;
    }

    function drawTeamsAtFinish() {
        //TODO: how to order a 2d array?
        //$this->teamsAtFinish[id][datetime]
        //needs to be ordered by datetime column.

        $result = "";
        foreach ($this->teamsAtFinish as $team) {
            $result .= $team["image"]." ";
        }
        return $result;
    }

    function checkTileExists($y, $x) {
        if (array_key_exists($y, $this->mapYX)) {
            $mapX = $this->mapYX[$y];
            if (array_key_exists($x, $mapX)) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    function getTileToLeave($y, $x) {
        return $this->mapYX[$y][$x]["toLeave"];
    }

    function getTileStatus($y, $x) {
        if ($this->checkTileExists($y, $x)) {
            return $this->mapYX[$y][$x]["status"];
        }
        else {
            return 100;
        }
    }

    function updateTile($y, $x, $status, $image) {
        $this->mapYX[$y][$x]["status"] = $status;
        $this->mapYX[$y][$x]["image"] = $image;
    }

    function updateStartTeam($image) {
        array_push($this->teamsAtStart, $image);
    }

    function updateFinishTeam($id, $image, $dateTime) {
        $this->teamsAtFinish[$id]['image'] = $image;
        $this->teamsAtFinish[$id]['dateTime'] = $dateTime;
    }

    function getRaw() {
        return $this->mapYX;
    }
}