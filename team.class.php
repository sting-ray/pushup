<?php

//build all the teams
function makeTeams() {
    $team = array();
    $conn = new mysqli(db_host, db_user, db_password, db_name);
    $queryResult = $conn->query("SELECT * FROM TEAM");
    while ($row = $queryResult->fetch_assoc()) {
        $team[$row["ID"]] = new Team($row);
    }
    return $team;
}

//for tracking each team
class Team {
    private $id;
    private $name;
    private $captain;
    private $flag;
    private $x;
    private $y;
    private $points;

    function __construct($values) {
        $this->id = $values["ID"];
        $this->name = $values["NAME"];
        $this->captain = $values["CAPTAIN"];
        $this->flag = $values["FLAG"];
        $this->x = $values["POSITION_X"];
        $this->y = $values["POSITION_Y"];
        $this->points = $values["POINTS"];
    }

    function putOnMap ($map) {
        $status = $map->getTileStatus($this->y,$this->x);
        switch ($status) {
            //empty space
            case 0:
                $map->updateTile($this->y,$this->x,2,"<img src='team_flags/".$this->flag."'>");
                break;
            case 3:
                //update for teams at start
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
        $moveY = $this->y;
        $moveX = $this->x;
        while ($move = true) {
            switch ($direction) {
                case "left":
                    $status = $map->getTileStatus($moveY, --$moveX);
                    break;
                case "up_left":
                    $status = $map->getTileStatus(--$moveY, --$moveX);
                    break;
                case "up":
                    $status = $map->getTileStatus(--$moveY, $moveX);
                    break;
                case "up_right":
                    $status = $map->getTileStatus(--$moveY, ++$moveX);
                    break;
                case "right":
                    $status = $map->getTileStatus($moveY, ++$moveX);
                    break;
                default:
                    return false; //Something has gone wrong..
                    break;
            }
            switch($status) {
                case 0:
                    //normal blank tile
                    $map->updateTile($moveY, $moveX, 2, "<img src='icons/$direction.png'>");
                    return true;
                    break;
                case 2:
                    //other team exists, do nothing and loop again.
                    break;
                case 4:
                    //end is within reach!
                    //later on may use a different tile icon for this significant event
                    $map->updateTile($moveY, $moveX, 2, "<img src='icons/$direction.png'>");
                    return true;
                    break;
                default:
                    //no tile found (status:100) or something else weird happened...
                    return false;
                    break;
            }
        }
    }

    function getPoints() {
        return $this->points;
    }
}