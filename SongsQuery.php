<!DOCTYPE html>
<html>
<head>
    <link href="layout-styles.css" 
      rel="stylesheet" 
      type="text/css" 
      media="screen" 
    />
</head>    
    
<body>
<?php require 'menu.php'; ?>

<div class="songResultDisplay">
    <?php require 'menu.php'; ?>

<?php	
    /* mysql connect (
            host            Optional. Either a host name or an IP address
            username        Optional. The MySQL user name
            password        Optional. The password to log in with
            dbname          Optional. The default database to be used when performing queries, 
    */		

    // MySQL Database Connection Parameters
    require 'server.php';                   // includes server information from specified file
    $searchValue = $_GET["songList"]; 
    $lyricsCB = $_GET["LyricsCheckBox"];
    
    // TEST CODE TO PRINT OUT IF LYRICSCHECKBOX VALUE IS PASSED
    //if ($lyricsCB === 'true') 
    //{
    //    echo $lyricsCB . "<br>";
    //    echo "lyrics check box is true! <br> <br> ";
    //}

    // Connect to MySQL
    $connect = mysql_connect($hostName, $userName, $password) or die ("Connect connect to server");

    // Set up query text for song data
    $querySelect = "SELECT $schema.songs.song, songs.band, songs.SongNotes ";
    $queryFrom = "FROM $schema.songs ";
    $queryWhere = "WHERE  $schema.songs.song = '$searchValue'";

    // Query for lyrics... matches song title from lyrics table to search value
    $query2 = "SELECT $schema.lyrics.lyrics, $schema.lyrics.song
               FROM $schema.lyrics, $schema.songs
               WHERE $schema.lyrics.song = '$searchValue'";

    $query1 = $querySelect . $queryFrom . $queryWhere;

    // Execute Query
    echo "SONG: " . $searchValue . "<br><br>";
    $result = mysql_query($query1, $connect);
    $result2 = mysql_query($query2, $connect);

    // Loop through each row in resulting query; each mysql_fetch_array is called, it goes to the next row, no iterator necessary
    $loopCount = 1;
    if($result)
    {
    while($row = mysql_fetch_array($result))
    {
        $theName = $row["song"];
        $theBand = $row["band"];
        $theNotes = $row["SongNotes"];

        
        echo $loopCount . ": <b>" . $theName . " by <i>" . $theBand . "</i></b><br>";
        echo "\t " . str_ireplace(";", "<br>", $theNotes) . "<br><hr><br>";  
                    // str_ireplace replaces all values with another value in the string

        // Get lyrics results and print lyrics if the song result matches the song    
        $row2 = mysql_fetch_array($result2);
        
        if ($lyricsCB === 'true')
        {
            $theLyrics = $row2["lyrics"];
            $lyricTableSong = $row2["song"];

            if ($lyricTableSong === $theName)  
            {
                //echo "<br><br>Has lyrics";
                $tempString = str_ireplace(" ", "&nbsp", $theNotes);                   // replace space with &nbsp space character
                echo "\t " . str_ireplace(";", "<br>", $tempString) . "<br><hr><rr>";  // str_ireplace replaces all values with another value in the string

                //echo "\t " . str_ireplace(";", "<br>", $theLyrics) ."<br><hr><br>";  // str_ireplace replaces all values with another value in the string
            }
        }
        $loopCount++;
    }
    }
?>

</div>

</body>
</html>