<?php
//https://stackoverflow.com/questions/14752470/creating-a-config-file-in-php
$config = parse_ini_file('config.ini.php');  // Update this location if config.ini.php is moved to another folder.

foreach ($config as $key => $value) {
    define($key,$value);
}

?>