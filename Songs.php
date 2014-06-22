<!DOCTYPE html>
<html lang="en">
    
<head>
	<meta charset="utf-8" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>MasterCJG</title>
	
        <link href="layout-styles.css" rel="stylesheet" type="text/css" media="screen" />
        
          <!-- Javascript functions -->
        <script type="text/javascript">
            
            function checkKey()
            {
                if (window.event.keyCode == 13)
                {
                    GotoTheFile();
                }
            }
            
            // Clears text box with ID of searchField and sets the FreeTextRadio buttont to true when onfocus event occurs
            function ClearTextBox()
            {
                //window.alert("clear text box");
                document.getElementById('searchField').value = "";
                document.getElementById('FreeTextRadio').checked = "true";
            }
            
            function SelectBandList()
            {
                document.getElementById('BandRadio').checked = "true";
            }
            
            function SelectSongList()
            {
                document.getElementById('SongsRadio').checked = "true";
            }


            // This function builds a link to the PHP file and goes to that file; this would normally be executed in a HTTP $_GET
            function GotoTheFile()
            {
                if(document.getElementById('FreeTextRadio').checked) 
                {
                    var searchValue = document.getElementById('searchField').value;
                    var lyricsCheckBoxValue = document.getElementById('LyricsCheckBox').checked;
                    var projectListValue = document.getElementById('projectList').value;
                    
                    var phpString1 = 'SongsFreeSearch.php?searchField=';
                    //var phpString2 = '&Search=Search';
                    var phpString2 = '&LyricsCheckBox=';
                    var phpString3 = '&projectList='
                    var phpStringFinal = phpString1 + searchValue + phpString2 + lyricsCheckBoxValue + phpString3 + projectListValue;
                    //window.alert(phpString2);
                }
                else if (document.getElementById('BandRadio').checked) {
                    
                    var searchValue = document.getElementById("bandList").value;

                    var phpString1 = 'BandQuery.php?bandList=';
                    //var phpString2 = 79CJ'&Run+Query=Search+Band+List';
                    var phpStringFinal = phpString1 + searchValue; // + phpString2;
                }
                else if (document.getElementById('SongsRadio').checked)
                {
                    var searchValue = document.getElementById("songList").value;
                    var lyricsCheckBoxValue = document.getElementById('LyricsCheckBox').checked;
                    
                    var phpString1 = 'SongsQuery.php?songList=';
                    //var phpString2 = '&Run+Query=Search+Song+List';
                    var phpString2 = '&LyricsCheckBox=';
                    var phpStringFinal = phpString1 + searchValue + phpString2 + lyricsCheckBoxValue;
                }
                
                //window.alert(phpStringFinal); 
                window.open(phpStringFinal, "_self");
                
            }
        
        </script>
</head>

<body onkeypress="checkKey()"> 
<?php require 'menu.php'; ?>

    
<div class="background-image-songs searchTable">
	            
        <!--The forms specified use the HTTP method 'get' to pass any variables within the form tag that have the
           'name' property to the <insert_name>.php file.
            
            Note file specified in the 'action' section of the form tag is automatically executed when
            and input type of 'submit' is specified.  
            
            So when someone clicks on the submit button, it opens the Games.php file using an HTTP get call, 
            and passes all names to this file-->
        
        <!-- The 'select' HTML tag is used used to generate a drop-down list (with <option> tag being used to add a value to the list)
             Inside the HTML select tag, PHP code is run to connect to the MySQL database
             Once connected to the MySQL database, a query is run to select all records in the table
                 
            The results of the query of input to the mysql_fetch_array function, which returns a single record in the database
            Each time mysql_fetch_array is called again, it moves/increments to the next record/data item in the array
                  
            A specific field's data of the returned record can be accessed by placing brackets and quotes after the variable
            PHP echo is used with the <OPTION> HTML tag, and therefore outputs the value of the field to a single item of the list box
        -->
        <center>
        <table> 
        
        <tr>
        <td>
        <div class="radioButton">
            <ul>
                <li> <label><input type="radio" name="SearchRadio" id="FreeTextRadio" checked='true' value="Keyword"/> Keyword   </label> </li>
                <li> <label><input type="radio" name="SearchRadio" id="BandRadio" value="Band"/> Bands   </label> </li>
                <li> <label><input type="radio" name="SearchRadio" id="SongsRadio" value="Songs"/> Songs   </label> </li>
                <!--
                <li> 
                    <label> 
                    <form name="CheckBoxes" method="get">
                        <input type="checkbox" name="LyricCheckBox" id="LyricsCheckBox" checked="true" value="LyricsCheck"/> 
                        Display Lyrics If Available
                    </form>
                    </label>
                </li>
                -->
            </ul>
        </div>
        </td>
        </tr>
        
        <tr><td><hr></td></tr>
        
        <tr>
        <td>
            <div class="radioButton">
                <ul>
                    <li> 
                        <label> 
                        <form name="CheckBoxes" method="get">
                            <input type="checkbox" name="LyricCheckBox" id="LyricsCheckBox" checked="true" value="LyricsCheck"/> 
                            Display Lyrics If Available
                        </form>
                        </label>
                    </li>
                </ul>
            </div>
            
        </td>
 
        </tr>
        
        <tr><td><hr></td></tr>
        
        <tr>
        <td>
            Filter by Project:
            
            <form name="projectList" method="GET">
                <SELECT id="projectList" name="projectList" value="Select Project">

                    <option> No Filter
                    <option> BL
                    <option> CGMM
                    <option> DCB
                    <option> EV
                    <option> FCM
                    <option> JAC
                    <option> KAL
                    <option> MB
                    <option> MM
                    <option> NXO
                    <option> SAC
                    <option> TDM
                    <option> TLE
                    <option> UR

                </SELECT>
            </form>      
        </td>
        </tr>
        
        <tr><td><hr></td></tr>
                
        <tr>
            <td>
            <!-- Provides text box to search through text for a band or song title-->            
            Keyword:
                <form name="FreeFormEntry" action="SongsFreeSearch.php" method="get">
                    <input type="text" onfocus="ClearTextBox()" onkeypress="checkKey()" id="searchField" name="searchField" value="Band or Song" size="50"/> <br><br>
                    
                    <!--* using standard submit functionality to pass HTML input variable via HTTP to PHP file --> 
                    <!--<input type="submit" name="Search" value="Search"/> <br> <br>   -->                                             


                </form>
            
            </td>
        </tr>
        
        <!-- Provides a drop-down with populated list of bands from database query -->
        <tr>
        <td>Band:
                <?php
                    echo <<<_END
                    <form name="ComboListForm" action="BandQuery.php" method="get">
                    <SELECT id="bandList" name="bandList" value="Select Band" onclick="SelectBandList()">;
_END;
                    
                    // MySQL Database Connection Parameters
                    require 'server.php';                   // includes server information from specified file
                    $table = "band";
                    $attribute = "band";
                    
                    // Connect to MySQL
                    $connect = mysql_connect($hostName, $userName, $password) or die ("Can't connect to server");
                    $query = "SELECT DISTINCT $schema.$table.$attribute FROM $schema.$table ORDER BY $schema.$table.$attribute";

                    // Execute Query
                    $result = mysql_query ($query, $connect);
                    
                    // Iterate through all records returned from the query results and display as part of HTML select/option drop-down
                    while ($row = mysql_fetch_array($result))
                    {
                       echo "<OPTION>" . $row[$attribute];           
                    }

                    
                    echo <<<_END
                    </SELECT>
                    <br><br>
                    
                    <!-- <input type="submit" name="Run Query" value="Search Band List"><br> -->
                    
                    </form>
_END;

                 ?>
            </td>
            </tr>
            
            <!-- Provides drop down to search through list of songs populated from database query -->
            <tr>
            <td> Song:
                    <?php
                    
                    echo <<<_END
                    <form name="ComboListForm" action="SongsQuery.php" method="get">
                    <SELECT id="songList" name="songList" onclick="SelectSongList()">;
_END;
                                      
                    // MySQL Database Connection Parameters
                    require 'server.php';                   // includes server information from specified file
                    $table = "songs";
                    $attribute = "song";

                    // Connect to MySQL
                    $connect = mysql_connect($hostName, $userName, $password) or die ("Can't connect to server");
                    $query = "SELECT DISTINCT $schema.$table.$attribute FROM $schema.$table ORDER BY $schema.$table.$attribute";

                    $result = mysql_query ($query, $connect);

                    while ($row = mysql_fetch_array($result))
                    {
                        echo "<OPTION>" . $row[$attribute];
                    }
                    
                    echo <<<_END
                    </SELECT>
                    <br><br>
                    
                    <!-- <input type="submit" name="Run Query" value="Search Song List"><br> -->
                    </form>
_END;

                 ?>
            </td>
            </tr>
            
            <!-- Provide button to perform search -->
            <tr>
            <td>    
                 <div id="btn-primary">
                <center>
                    <form name="theButton" color="blue">
                        <!--* using javascript function -->
                        <input type="button" onclick="GotoTheFile()" id="searchButton" name="SearchButton" value="Search"/> <br> 
                    
                    </form>
                </center>
                </div>
            </td>
            </tr>
        </table>
        </center>
</div>
	
</body>

</html>