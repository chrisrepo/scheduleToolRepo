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
            
            //create html var
            $html = new simple_html_dom();
            // Load a file
            $html->load_file('http://web.csulb.edu/depts/enrollment/registration/class_schedule/Fall_2015/By_Subject');
            //fill shit with ... shit
            $list = $html->find('li');
            echo 'INSERT INTO Class (courseCode, courseTitle, units, courseInfo) VALUES ';
            foreach($list as $element){
                
            $innerHtml = new simple_html_dom();
            $e = $element->children(0);
            if (strpos($e->href,'html') === false){
                continue 1;
            }
            
            $innerHtml->load_file('http://web.csulb.edu/depts/enrollment/registration/class_schedule/Fall_2015/By_Subject/'.$e->href);
            $shit = $innerHtml->find('div[class=courseHeader]');
            $i=0;
            foreach($shit as $shits) {
                # remember comments count as nodes
                $courseCode = $shits->children(0)->children(0)->outertext;
                $courseTitle = $shits->children(0)->children(1)->outertext;
                $units = $shits->children(1)->outertext;
                $courseInfo = $shits->children(2)->outertext;
                echo ' ("'.$courseCode.'","'.$courseTitle.'","'.$units.'",""), ';
                
                $i++;
            }//end inner for each
            
            }//end outer for
        ?>
    </body>
</html>
