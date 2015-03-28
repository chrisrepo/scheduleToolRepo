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
                <div class='col-lg-3'></div>
                <div class='col-lg-6'>
                    <h1 class='satelliteFontHeader'>Class Schedule Tool</h1>
                </div>
                <div class='col-lg-3'></div>
            </div>
            <div class='row'>
                <div class='col-lg-2'></div>
                <div class='search col-lg-8'>
                    <form action="" class='centerfy' method="get" autocomplete="off">
                        <input type="text" name="myClass" id="myClasses" value="<?php echo $value ?>"> 
                        <input type="submit" name="send" class="button" value="Go">
                    </form>
                </div>
                <div class='col-lg-2'></div>
            </div>
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
                echo "<div class='col-lg-1'></div>";
                echo "<div class='col-lg-2'><div class='row'> <div class='col-lg-8'>Course</div>"
                        ."<div class='col-lg-4'>Units</div></div></div>";
                echo "<div class='col-lg-1'>Section</div>";
                echo "<div class='col-lg-1'>Code</div>";
                echo "<div class='col-lg-1'>Type</div>";
                echo "<div class='col-lg-2'><div class='row'> <div class='col-lg-4'>Day(s)</div>"
                    ."<div class='col-lg-8'>Time</div></div></div>";
                echo "<div class='col-lg-1'>Location</div>";
                echo "<div class='col-lg-1'>Teacher</div>";
                echo "<div class='col-lg-1'>Availability</div>";
                echo "<div class='col-lg-1'></div>";
                echo "</div><br>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='row classListing'>";
                    echo "<div class='col-lg-1'></div>";
                    echo "<div class='col-lg-2'><div class='row'><div class='col-lg-8'>".$row['courseCode']."</div>";
                    echo "<div class='col-lg-4'>".$row['units']."</div></div></div>";
                    echo "<div class='col-lg-1'>".$row['offeringSection']."</div>";
                    echo "<div class='col-lg-1'>".$row['offeringCode']."</div>";
                    echo "<div class='col-lg-1'>".$row['offeringType']."</div>";
                    echo "<div class='col-lg-2'><div class='row'> <div class='col-lg-4'>".$row['offeringDays']."</div>";
                    echo "<div class='col-lg-8'>".$row['offeringTime']."</div></div></div>";
                    echo "<div class='col-lg-1'>".$row['offeringLocation']."</div>";
                    echo "<div class='col-lg-1'>".$row['offeringTeacher']."</div>";
                    if (strcmp($row['openSeat'],"Yes")===0){
                        //available seats
                        echo "<div class='col-lg-1'><span class='label label-success'>Open Seats</span></div>";
                    } else {
                        //unavailable or N/A
                        echo "<div class='col-lg-1'><span class='label label-danger'>Unavailable</span></div>";
                    }
                    echo "<div class='col-lg-1'></div>";
                    echo "</div><br>";
                }
            }   
            ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/typeahead.js"></script>
        <script src="js/global.js"></script>
    </body>
</html>
