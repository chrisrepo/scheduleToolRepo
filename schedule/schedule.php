<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Schedule Tool</title>
        <link rel="shortcut icon" href="../images/favicon.ico" />
        <link rel='stylesheet' href='../css/bootstrap.min.css'>
        <link rel='stylesheet' href='../css/custom.css'>
        <link rel="stylesheet" href="css/global.css">
    </head>
    <body>
        <div class="container">
                <div class='row'>
                <div class='col-md-3'>
                  <a class="backButton" href="index.html">Back</a>
               </div>
                <div class='col-md-6'>
                    <h1 class='satelliteFontHeader'>Class Schedule Tool</h1>
                </div>
                <div class='col-md-3'></div>
            </div>
            <div class='row'>
                <div class='col-md-2'></div>
                <div class='search col-md-8'>
                    <form action="" class='centerfy' method="get" autocomplete="off">
                        <input type="text" placeholder="Enter a class to search... (Ex: POSC 100)"
                           name="myClass" id="myClasses" 
                            <?php echo (isset($_GET['send'])) ? 'value = "'.$_GET['myClass'].'"' : ''?> >
                        <input type="submit" name="send" class="button" value='Search'>
                    </form>
                </div>
                <div class='col-md-2'></div>
            </div>
            <div class="holdSearchContents">
            <?php
            if(isset($_GET['send']) && !empty($_GET['myClass'])){
                $dbhost = "localhost";
                $dbusername = "chrisrep_admin";
                $dbpassword = "Basketball3";
                $dbname = "chrisrep_classDB";
            
                //open connection to server
                $connection = new mysqli($dbhost, $dbusername, $dbpassword) or die('Could not connect');
                $db = mysqli_select_db($connection, $dbname) or die('Couldnt select DB');
                
                
                $class = explode(" - ", $_GET['myClass']);
                $value = $_GET['myClass'];
                //initialize multiquery
                $query = "SELECT * FROM CourseOffering WHERE courseCode= '".$class[0]."' ORDER BY offeringSection";
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    $message  = 'Invalid query: ' . mysql_error() . "\n";
                    $message .= 'Whole query: ' . $query;
                    die($message);
                }
                
                echo "<br><br>";
                //format output
                echo "<div class='row classListingHeader'>";
                echo "<div class='col-md-2'><div class='row'> <div class='col-md-8'>Course</div>"
                        ."<div class='col-md-4'>Units</div></div></div>";
                echo "<div class='col-md-1'>Section</div>";
                echo "<div class='col-md-1'>Code</div>";
                echo "<div class='col-md-1'>Type</div>";
                echo "<div class='col-md-4'><div class='row'> <div class='col-md-3'>Day(s)</div>"
                    ."<div class='col-md-5'>Time</div>"
                    ."<div class='col-md-4'>Location</div></div></div>";
                echo "<div class='col-md-2'><div class='row'><div class='col-md-8'>Teacher</div>"
                    ."<div class='col-md-4'>Availability</div></div></div>";
                echo "</div><br>";
                $index = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    echo "<div class='row classListing";
                    if($index & 1){
                        //odd
                        echo " readabilityDark'>";
                    } else {
                        //even
                        echo " readabilityLight'>";
                    }
                    echo "<div class='col-md-2'><div class='row'><div class='col-md-8'>".$row['courseCode']."</div>";
                    echo "<div class='col-md-4'>".$row['units']."</div></div></div>";
                    echo "<div class='col-md-1'>".$row['offeringSection']."</div>";
                    echo "<div class='col-md-1'>".$row['offeringCode']."</div>";
                    echo "<div class='col-md-1'>".$row['offeringType']."</div>";
                    echo "<div class='col-md-4'><div class='row'> <div class='col-md-3'>".$row['offeringDays']."</div>";
                    echo "<div class='col-md-5'>".$row['offeringTime']."</div>";
                    echo "<div class='col-md-4'>".$row['offeringLocation']."</div></div></div>";
                    echo "<div class='col-md-2'><div class='row'><div class='col-md-8'>".$row['offeringTeacher']."</div>";
                    if (strcmp($row['openSeat'],"Yes")===0){
                        //available seats
                        echo "<div class='col-md-4'><span class='label label-success'>Open Seats</span></div></div></div>";
                    } else {
                        //unavailable or N/A
                        echo "<div class='col-md-4'><span class='label label-danger'>Unavailable</span></div></div></div>";
                    }
                    echo "<div class='col-md-1'></div>";
                    echo "</div>";
                    $index++;
                }
            }   
            ?>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/typeahead.js"></script>
        <script src="js/global.js"></script>
    </body>
</html>
