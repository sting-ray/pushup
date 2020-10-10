<?php

//For displaying the little smiling faces and other symbols next to a players work out.
class Emoticons {
    private $emoticons = array();

    function __construct() {
        $conn = new mysqli(db_host, db_user, db_password, db_name);
        $queryResult = $conn->query("SELECT * FROM EMOTICON");
        while ($row = $queryResult->fetch_assoc()) {
            $this->emoticons[$row["ID"]] = "emoticons/".$row["IMAGE"];
        }
    }


    function updateIcon($emoticonId, $actionId, $userId, $emoticonType) {
        $conn = new mysqli(db_host, db_user, db_password, db_name);
        $check = $conn->query("SELECT * FROM EMOTICON_JT WHERE EMOTICON_ID=$emoticonId AND ".$emoticonType."_ID=$actionId AND USER_ID=$userId");
        if ($check->num_rows == 0) {
            $conn->query("INSERT INTO EMOTICON_JT (EMOTICON_ID, ".$emoticonType."_ID, USER_ID) VALUES ($emoticonId, $actionId, $userId)");
        }
    }

    //actionType = TEAM_MOVE OR PUSHUP
    function getIcons($actionId, $emoticonType, $updateURL) {
        $result = "";
        $emoticonName = array();
        $emoticonCount = array();
        $conn = new mysqli(db_host, db_user, db_password, db_name);
        $queryResult = $conn->query("SELECT EMOTICON_ID, NAME FROM EMOTICON_JT LEFT JOIN USER ON EMOTICON_JT.USER_ID = USER.ID WHERE ".$emoticonType."_ID=$actionId");
        while ($row = $queryResult->fetch_assoc()) {
            if (array_key_exists($row["EMOTICON_ID"], $emoticonName)) {
                $emoticonName[$row["EMOTICON_ID"]] .= $row["NAME"].", ";
                $emoticonCount[$row["EMOTICON_ID"]]++;
            }
            else {
                $emoticonName[$row["EMOTICON_ID"]] = $row["NAME"].", ";
                $emoticonCount[$row["EMOTICON_ID"]] = 1;
            }
        }
        foreach ($this->emoticons as $id => $emoticon) {
            $result .= "<a href='$updateURL?emoticon_id=$id&action_id=$actionId&emoticon_type=$emoticonType'>";
            if (array_key_exists($id, $emoticonName)) {
                $title = substr($emoticonName[$id], 0, -2);
                $result .= "<img src='$emoticon' title='$title'></a>";
                $result .= "<small class='small'> x".$emoticonCount[$id]."</small> ";
            }
            else {
                $result .= "<img src='$emoticon' class='faded'></a> ";
            }
        }
        return $result;
    }


}