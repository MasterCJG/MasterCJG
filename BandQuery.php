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

<div class="wrap songResultDisplay">


 <?php	
        /* mysql connect (
                host            Optional. Either a host name or an IP address
                username	Optional. The MySQL user name
                password	Optional. The password to log in with
                dbname          Optional. The default database to be used when performing queries, 
        */		

        // MySQL Database Connection Parameters
        require 'server.php';                   // includes server information from specified file
        $searchValue = $_GET["bandList"]; 
        

        // Connect to MySQL
        $connect = mysql_connect($hostName, $userName, $password) or die ("Connect connect to server");
        //echo($connect) . "<br>";

        // Set up query text
        $querySelect = "SELECT $schema.songs.song, songs.SongNotes ";
        $queryFrom = "FROM $schema.songs ";
        $queryWhere = "WHERE  $schema.songs.band = '$searchValue'";

        $query1 = $querySelect . $queryFrom . $queryWhere;

/*
        $query = "select distinct $schema.games.GameName, $schema.company.CompanyName, $schema.games.GameCost " .
                "from $schema.games inner join " .
		"($schema.company inner join $schema.relationship_game_company on $schema.company.CompanyName = $schema.relationship_game_company.CompanyName) " .
		" on $schema.relationship_game_company.GameName = $schema.games.GameName" . 
                "ORDER BY $schema.games.GameName";
*/

        // Execute Query
        echo "SONGS BY: " . $searchValue . "<br><br>";
        $result = mysql_query($query1, $connect);

        // Loop through each row in resulting query; each mysql_fetch_array is called, it goes to the next row, no iterator necessary
        $loopCount = 1;
        if($result)
        {
        while($row = mysql_fetch_array($result))
        {
                $theName = $row["song"];
                $theNotes = $row["SongNotes"];
                
                echo $loopCount . ": <b>" . $theName . "</b><br>";
                $tempString = str_ireplace(" ", "&nbsp", $theNotes);                   // replace space with &nbsp space character
                echo "\t " . str_ireplace(";", "<br>", $tempString) . "<br><hr><br>";  // str_ireplace replaces all values with another value in the string

                //echo "\t " . str_ireplace(";", "<br>", $theNotes) . "<br><hr><br>";  // str_ireplace replaces all values with another value in the string
                
                $loopCount++;
        }
        }
    ?>

</div>

</body>
</html>