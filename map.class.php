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

    function drawEverything($teamArray, $draw = true) {
        $result = "";
        if (!empty($this->teamsAtFinish)) {
            $result .= "Teams at finish:<br>";
            $result .= $this->drawTeamsAtFinish($teamArray);
            $result .= "<br>";
        }
        $result .= $this->drawMap();
        $result .= "<br>";
        if (!empty($this->teamsAtStart)) {
            $result .= "Teams at start:<br>";
            $result .= $this->drawTeamsAtStart();
            $result .= "<br>";
        }
        if ($draw) {
            echo $result;
            return true;
        }
        else {
            return $result;
        }
    }

    function drawMap() {
        $result = "<table class='map'>";
        foreach ($this->mapYX as $y => $mapX) {
            $result .= "<tr>";
            foreach ($mapX as $x => $map) {
                $result .= "<td title='Points needed to move off this tile: ".$map["toLeave"]."'>".$map["image"]."</td>";
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

    function drawTeamsAtFinish($teamArray) {
        $result = "<table><tr>";
        ksort($this->teamsAtFinish);
        $position = 1;
        foreach ($this->teamsAtFinish as $dateTime => $teamId) {
            $result .= "<td>".$teamArray[$teamId]->getFlag();
            switch ($position) {
                case 1:
                    $result .= "<br>1st: ";
                    break;
                case 2:
                    $result .= "<br>2nd: ";
                    break;
                case 3:
                    $result .= "<br>3rd: ";
                    break;
                default:
                    $result .="<br>";
                    break;
            }
            $position++;
            $result .= $teamArray[$teamId]->getName();
            $result .= "<br><small>".$dateTime."</small></td>";
        }
        $result .= "</tr></table>";
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

    function updateFinishTeam($id, $datetime) {
        $this->teamsAtFinish[$datetime] = $id ;
    }

    function getRaw() {
        return $this->mapYX;
    }
}