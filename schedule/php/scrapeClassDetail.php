<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            include 'simple_html_dom.php';
            $dbhost = "localhost";
            $dbusername = "chrisrep_admin";
            $dbpassword = "Basketball3";
            $dbname = "chrisrep_classDB";
            
            //open connection to server
            $connection = new mysqli($dbhost, $dbusername, $dbpassword) or die('Could not connect');
            $db = mysqli_select_db($connection, $dbname) or die('Couldnt select DB');
            
            //initialize multiquery
            $query = "";
            
            //create html var
            $html = new simple_html_dom();
            // Load a file
            $html->load_file('http://web.csulb.edu/depts/enrollment/registration/class_schedule/Fall_2015/By_Subject');
            
            //find class lists
            $list = $html->find('li');
            foreach($list as $element){
                
            $innerHtml = new simple_html_dom();
            $e = $element->children(0);
            if (strpos($e->href,'html') === false){
                continue 1;
            }
            echo $e->href . "<br>";
            echo number_format(memory_get_usage()) . "<br>";
            
            $innerHtml->load_file('http://web.csulb.edu/depts/enrollment/registration/class_schedule/Fall_2015/By_Subject/'.$e->href);
            
            //find all divs with the class courseBlock (block contains both header, and all of the offerings)
            $shit = $innerHtml->find('div[class=courseBlock]');
            
            //loop through each course block
            foreach($shit as $shits) {
                # remember comments count as nodes
                $courseCode = $shits->children(0)->children(0)->children(0)->outertext;
                $courseTitle = $shits->children(0)->children(0)->children(1)->outertext;
                $units = $shits->children(0)->children(1)->outertext;
                $courseInfo = "";
               
                //section table variable (all TRS in the courseBlock should be offerings
                //except first row (display text)
                $sectionTable = $shits->find('tr');
                $sql = "INSERT INTO CourseOffering (`courseCode`,`courseTitle`,`units`,`courseInfo`,`offeringSection`,`offeringCode`,`offeringType`,`offeringDays`,`offeringTime`,`openSeat`,`offeringLocation`,`offeringTeacher`) VALUES ";
                
                //increment on loop so last value appends to sql with ; instead of ,
                $j=0;
                foreach($sectionTable as $offering){
                    if (strpos($offering->children(0)->outertext, 'SEC') === true){
                        continue 1;
                    }
                    if (strcmp($offering->children(1)->class, 'multiMeeting') === 0){
                        continue 1;
                    }
                    $section = $offering->children(0)->outertext;
                    $classCode = $offering->children(1)->outertext;
                    $classType = $offering->children(3)->outertext;
                    $classDays = $offering->children(4)->outertext;
                    $classTime = $offering->children(5)->outertext;
                    $openSeat = $offering->children(6)->children(0)->children(0)->alt;
                    $classLocation = $offering->children(7)->outertext;
                    $teacher = $offering->children(8)->outertext;
                    
                    $j++;
                    if ($j >= sizeof($sectionTable)){
                        $sql = $sql . "('".$courseCode."', '".$courseTitle."', '". $units
                         ."', '".$courseInfo."', '".$section."', '".$classCode."', '". $classType
                          ."', '".$classDays."', '".$classTime."', '".$openSeat."', '". $classLocation
                            ."', '".$teacher."'); <br>";
                    } else {
                        $sql = $sql . "('".$courseCode."', '".$courseTitle."', '". $units
                         ."', '".$courseInfo."', '".$section."', '".$classCode."', '". $classType
                          ."', '".$classDays."', '".$classTime."', '".$openSeat."', '". $classLocation
                            ."', '".$teacher."'), ";
                    }
                }//end class offering loop
                $query .= $sql;
            }//end inner for each
            
            }//end outer for
            /* execute multi query */
        echo query;
        ?>
    </body>
</html>
