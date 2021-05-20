<?php

include "header.inc.php";
include "database.inc.php";

echo "<h1>Create New Game</h1><br>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = fixInput($_POST["name"])."<br>";
    $start = fixInput($_POST["start"])."<br>";
    $invite = fixInput($_POST["invite"])."<br>";

}
else {
    echo "
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>

        <form action='create_game.php' method='post'>
        <table>
        <tr><th>Game Name:</th><td><input type='text' name='name'></td></tr>
        <tr><th>Start:</th><td><input type='datetime-local' name='start'><i>Format: yyyy-mm-ddThh:mm</i></td></tr>
        <tr><th>Invite:</th><td><select name='invite'>
            <option value='1' disabled>Anybody can join at any time</option>
            <option value='2' disabled>Anybody can join before the competition starts</option>
            <option value='3' selected>Anybody can request to join at any time</option>
            <option value='4' disabled>Anybody can request to join before the competition starts</option>
        </select></td></tr>
        <tr><th>width</th><td><input type='number' name='width' id='width'></td></tr>
        <tr><th>height</th><td><input type='number' name='height' id='height'> <button href='#' id='makeMap'>Make the map</button></td></tr>
        </table>
        <table id='details'>
            <tr><th>x</th><th>y</th><th>status</th><th>image</th><th>to leave</th></tr>
        </table>
        
        <table id='map' class='map'>
        </table>
        <script>
            $('#makeMap').on('click', function(e) {
                e.preventDefault();
                var height = $('#height').val();
                var width = $('#width').val();
                for (var y = 0; y < height; y++) {
                    //$('#map').append('<tr><td>hello</td></tr>');
                    $('#map').append('<tr id=' + y + '></tr>');
                    for (var x = 0; x < width; x++) {
                        var xy = 'x' + x + 'y' + y;
                        $('#map #' + y).append('<td id=\'td'+xy+'\'><img src=\'map_icons/empty.png\'></td>');
                        $('#details').append('<tr id=\'tr'+xy+'\'><td>'+x+'</td><td>'+y+'</td></tr>');
                        $('#tr' + xy).hide();
                    }
                    //$('#map').append('<tr>');
                    //$('#map').append('<td>hello</td>');
                    //$('#map').append('</tr>');
                }
                
            });
            
        </script>
        
        <input type='submit'><p>
    ";
}
