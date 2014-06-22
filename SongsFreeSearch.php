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

 
<?php	
    /* mysql connect (
            host            Optional. Either a host name or an IP address
            username        Optional. The MySQL user name
            password        Optional. The password to log in with
            dbname          Optional. The default database to be used when performing queries, 
    */		

    // MySQL Database Connection Parameters
    require 'server.php';                   // includes server information from specified file
    $searchValue = $_GET["searchField"]; 
    $lyricsCB = $_GET["LyricsCheckBox"];
    $theProject = $_GET["projectList"];
    
    
    // TEST CODE TO PRINT OUT IF LYRICSCHECKBOX VALUE IS PASSED
    //if ($lyricsCB === 'true') 
    //{
    //    echo $lyricsCB . "<br>";
    //    echo "lyrics check box is true! <br> <br> ";
    //}

    // Connect to MySQL
    $connect = mysql_connect($hostName, $userName, $password) or die ("Connect connect to server");


    // Set up query text
    $querySelect = "SELECT $schema.songs.song, $schema.songs.band, $schema.songs.SongNotes ";
    $queryFrom = "FROM $schema.songs ";
    $queryOrder = "ORDER BY $schema.songs.song ";
    
    if ($theProject <> "No Filter")
    {   
        if ($searchValue <> "") 
        {
            $queryWhere = "WHERE  $schema.songs.Project LIKE '%" . $theProject. "%' ";
            //echo "<BR>" . $queryWhere . "<BR>   ";
        }
        else 
        {
            $queryWhere = "WHERE  $schema.songs.Project LIKE '%" . $theProject. "%' ";
            //echo "<BR>" . $queryWhere . "<BR>   ";              
        }
    }   
    else {
        $queryWhere = "WHERE 1 ";
     }
    
    

    $query1 = $querySelect . $queryFrom . $queryWhere . $queryOrder;
    //echo "<BR>" . $query1 . "<BR>  " ;  // DEBUGGING ONLY
        
    $query2 = "SELECT $schema.lyrics.lyrics, $schema.lyrics.song
               FROM $schema.lyrics";


    // Execute Query
    echo "<u><b>SEARCH TEXT:</b></u> " . $searchValue . "<br>";
    
    if ($theProject <> "None") {
        echo "<b><u>SEARCHING FOR THIS PROJECT</b></u>: " . $theProject . "<br><br>";
    }
    $result = mysql_query($query1, $connect);
    //$result2 = mysql_query($query2, $connect);

    // Loop through each row in resulting query; each mysql_fetch_array is called, it goes to the next row, no iterator necessary
    $loopCount = 1;
    if($result)
    {
    while($row = mysql_fetch_array($result))
    {
        $theSong = $row["song"];
        $theBand = $row["band"];
        $theNotes = $row["SongNotes"];

        // Compares the song names in the database to the search values; if there is a match, return all data
        if($searchValue)
        {
            // If the band name or song name are contained within the search value, print everything out
            if (stristr($theSong, $searchValue) or (stristr($theBand, $searchValue)))
            {
                // Call function to print out song notes and pass appropriate variables
               $loopCount =  PrintOutSongNotes($theSong, $theBand, $theNotes, $loopCount, $lyricsCB, $query2, $connect);
            }
        }
        else 
        {
            // Call function to print out song notes and pass appropriate variables
            $loopCount = PrintOutSongNotes($theSong, $theBand, $theNotes, $loopCount, $lyricsCB, $query2, $connect);  
        }
    
    }
    }
    
    //************************************************************************************
    // Function for printing out songs and appropriate lyris. 
    //************************************************************************************
    function    PrintOutSongNotes($theSong, $theBand, $theNotes, $loopCount, $lyricsCB, $query2, $connect) 
    {
        echo $loopCount . ": <b>" . $theSong . " by <i>" . $theBand . "</i></b><br>";
        $tempString = str_ireplace(" ", "&nbsp", $theNotes);                   // replace space with &nbsp space character
        echo "\t " . str_ireplace(";", "<br>", $tempString) . "<br><hr><br>";  // str_ireplace replaces all values with another value in the string

        // Gets lyrics from the lyrics table query and matches against matched in previous step
        if ($lyricsCB === 'true')
        {
            $result2 = mysql_query($query2, $connect);

            while ($row2 = mysql_fetch_array($result2))
            {
                $theSongFromLyricsTable = $row2["song"];

                if (stristr($theSong, $theSongFromLyricsTable))
                {
                    $theLyrics = $row2["lyrics"];

                    // str_ireplace replaces all values with another value in the string
                    echo "\t " . str_ireplace(";", "<br>", $theLyrics) . "<br><hr><br>";  
                }
            }
        }

        $loopCount++;   
        
        return $loopCount;
    }
?>

</div>

</body>
</html>