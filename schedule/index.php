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
                    <form action="index.php" class='centerfy' method="get" autocomplete="off">
                        <input type="text" name="myClass" id="myClasses">
                        <input type="submit" value="Go">
                    </form>
                </div>
                <div class='col-lg-2'></div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/typeahead.js"></script>
        <script src="js/global.js"></script>
    </body>
</html>
