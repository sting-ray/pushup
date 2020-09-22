<?php

include "header.inc.php";
include "database.inc.php";

$conn = new mysqli(db_host, db_user, db_password, db_name);
$privacy = $conn->query("SELECT PRIVACY FROM USER WHERE ID=".playerId)->fetch_object()->PRIVACY;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE USER SET ";
    if (!empty($_POST["password"])) {
        $password = makePassword($_POST["password"]);
        $sql .= "PASSWORD='$password'";
        echo "Password Updated<br>";
    }
    if(!empty($_POST["privacy"])) {
        $privacy = fixInput($_POST["privacy"]);
        if (!empty($password)) {
            $sql .= ", ";
        }
        $sql .= "PRIVACY='$privacy'";
        echo "Privacy Updated<br>";
    }
    $sql .= "WHERE ID=".playerId;
    $conn->query($sql);
}


?>

<h1>Change your settings</h1><p>
<form action='settings.php' method='post'>
Change password: <input type='password' name='password'><br>
Change privacy setting: <select name='privacy'>
    <option value='1' id='1'>Only you and the admins can see your pushups</option>
    <option value='2' id='2'>Pushups visible to your team leader and admins</option>
    <option value='3' id='3'>Pushups visible to your entire team and admins</option>
    <option value='4' id='4'>Pushups visible to everybody in the competition</option>
</select><br>
<input type='submit'></form><p>

<?php echo "<script>document.getElementById('$privacy').selected = 'true'</script>";