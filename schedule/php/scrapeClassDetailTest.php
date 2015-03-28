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
            include_once 'simple_html_dom.php';
            set_time_limit(0);
            gc_collect_cycles();

            //declare query array
            $query = array();
            // Load a file
            $html = file_get_html('http://web.csulb.edu/depts/enrollment/registration/class_schedule/Fall_2015/By_Subject');
            
            //find class lists
            $list = $html->find('li');
            $html = null;
            foreach($list as $element){ 
            
            $e = $element->children(0);
            if (strpos($e->href,'html') === false){
                continue 1;
            }
            $innerHtml = file_get_html('http://web.csulb.edu/depts/enrollment/registration/class_schedule/Fall_2015/By_Subject/'.$e->href);
            $blocks = $innerHtml->find('div[class=courseBlock]');
            $innerHtml = NULL;
            //loop through each course block
            foreach($blocks as $courseBlock) {
                # remember comments count as nodes
                $courseCode = $courseBlock->children(0)->children(0)->firstChild()->outertext;
                $courseTitle = $courseBlock->children(0)->children(0)->children(1)->outertext;
                $units = $courseBlock->children(0)->children(1)->outertext;
                $courseInfo = "";
               
                //section table variable (all TRS in the courseBlock should be offerings
                //except first row (display text)
                $sectionTable = $courseBlock->find('tr');
                $sql = "INSERT INTO CourseOffering (`courseCode`,`courseTitle`,`units`,`courseInfo`,`offeringSection`,`offeringCode`,`offeringType`,`offeringDays`,`offeringTime`,`openSeat`,`offeringLocation`,`offeringTeacher`) VALUES ";
                
                //increment on loop so last value appends to sql with ; instead of ,
                $j=0;
                $courseBlock = NULL;
                foreach($sectionTable as $offering){
                    
                    
                    if ($j== 0){
                        $j++;
                        continue 1;
                    }
                    
                    //no class code, not official class at the moment, so skip to prevent err
                    if (strcmp($offering->children(1)->class, 'multiMeeting') === 0){
                        $j++;
                        continue 1;
                    }
                    $section = $offering->children(0)->outertext;
                    $classCode = $offering->children(1)->outertext;
                    $classType = $offering->children(3)->outertext;
                    $classDays = $offering->children(4)->outertext;
                    $classTime = $offering->children(5)->outertext;
                    $openSeat= $offering->children(6)->firstChild()->firstChild()->title;
                    $classLocation = $offering->children(7)->outertext;
                    $teacher = $offering->children(8)->outertext;
                    
                    $j++;
                    
                    if ($j >= sizeof($sectionTable)){
                        $sql = $sql . '("'.$courseCode.'", "'.$courseTitle.'", "'. $units
                         .'", "'.$courseInfo.'", "'.$section.'", "'.$classCode.'", "'. $classType
                          .'", "'.$classDays.'", "'.$classTime.'", "'.$openSeat.'", "'. $classLocation
                            .'", "'.$teacher.'"); <br><br>';
                    } else {
                        $sql = $sql . '("'.$courseCode.'", "'.$courseTitle.'", "'. $units
                         .'", "'.$courseInfo.'", "'.$section.'", "'.$classCode.'", "'. $classType
                          .'", "'.$classDays.'", "'.$classTime.'", "'.$openSeat.'", "'. $classLocation
                            .'", "'.$teacher.'"), ';
                    }
                    
                    
                    $offering = null;
                }//end class offering loops
                $query[] = $sql;
            }//end inner for each
             $innerHtml = null;   
                if (strcmp($e->href,'WGSS.html')===0){
                    break;    
                }
            }//end outer for
            
            /* Begin executing multiple queries.
             * Because this script is used only to update the tables of the 
             * database, it does not matter how efficient/quick it is.
             * This script really only needs to be used when the school updates
             * the class list
             */
        echo "<br>query array length".sizeof($query)."<br>";
        
        foreach ($query as $insert){
            echo $insert;
        }
        ?>
    </body>
</html>
