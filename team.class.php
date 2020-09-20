<?php

//build all the teams
function makeTeams() {
    $team = array();
    $conn = new mysqli(db_host, db_user, db_password, db_name);
    $queryResult = $conn->query("SELECT TEAM.ID, TEAM.NAME, CAPTAIN, FLAG, POSITION_X, POSITION_Y, POINTS, USER.NAME AS CAPTAIN_NAME FROM TEAM LEFT JOIN USER ON TEAM.CAPTAIN = USER.ID;");
    while ($row = $queryResult->fetch_assoc()) {
        $team[$row["ID"]] = new Team($row);
    }
    return $team;
}

//for tracking each team
class Team {
    private $id;
    private $name;
    private $captainId;
    private $captainName;
    private $flagImg;
    private $x;
    private $y;
    private $points;

    function __construct($values) {
        $this->id = $values["ID"];
        $this->name = $values["NAME"];
        $this->captainId = $values["CAPTAIN"];
        $this->captainName = $values["CAPTAIN_NAME"];
        $this->flagImg = "<img src='team_flags/".$values["FLAG"]."'>";
        $this->x = $values["POSITION_X"];
        $this->y = $values["POSITION_Y"];
        $this->points = $values["POINTS"];
    }

    function putOnMap ($map) {
        $status = $map->getTileStatus($this->y,$this->x);
        switch ($status) {
            //empty space
            case 0:
                $map->updateTile($this->y,$this->x,2,$this->flagImg);
                break;
            case 3:
                $map->updateStartTeam($this->flagImg);
                break;
            case 4:
                //update for teams at finish
                break;
        }
    }

    function getPointsNeeded ($map) {
        //this just checks the tile the team is on, later may create function to check from and to
        return $map->getTileToLeave($this->y, $this->x);
    }

    function calculateMovement ($map, $direction) {
        $move["y"] = $this->y;
        $move["x"] = $this->x;
        while ($untilBroken = true) {
            switch ($direction) {
                case "left":
                    $status = $map->getTileStatus($move["y"], --$move["x"]);
                    break;
                case "up_left":
                    $status = $map->getTileStatus(--$move["y"], --$move["x"]);
                    break;
                case "up":
                    $status = $map->getTileStatus(--$move["y"], $move["x"]);
                    break;
                case "up_right":
                    $status = $map->getTileStatus(--$move["y"], ++$move["x"]);
                    break;
                case "right":
                    $status = $map->getTileStatus($move["y"], ++$move["x"]);
                    break;
                default:
                    return false; //Something has gone wrong..
                    break;
            }
            switch($status) {
                case 0:
                    //normal blank tile
                    $map->updateTile($move["y"], $move["x"], 2, "<a href='move.php?move=$direction'><img src='icons/$direction.png'></a>");
                    return $move;
                    break;
                case 2:
                    //other team exists, do nothing and loop again.
                    break;
                case 4:
                    //end is within reach!
                    //later on may use a different tile icon for this significant event
                    $map->updateTile($move["y"], $move["x"], 2, "<a href='move.php?move=$direction'><img src='icons/$direction.png'></a>");
                    return $move;
                    break;
                default:
                    //no tile found (status:100), ran into a wall or something else weird happened...
                    return false;
                    break;
            }
        }
    }

    function getPoints() {
        return $this->points;
    }

    function getFlag() {
        return $this->flagImg;
    }

    function getName() {
        return $this->name;
    }

    function getId() {
        return $this->id;
    }

    function getCaptainName() {
        return $this->captainName;
    }
}