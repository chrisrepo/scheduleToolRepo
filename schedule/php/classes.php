<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    if (!isset($_GET['query'])){
        echo json_encode([]);
        echo 1;
        exit();
    }
    
    $db = new PDO('mysql:host=localhost;dbname=chrisrep_classDB', 'chrisrep_admin','Basketball3');
    
    $classes = $db->prepare("
            SELECT courseCode, courseTitle
            FROM Class
            WHERE courseCode LIKE :query
            OR courseTitle LIKE :query
    ");
    
    $classes->execute([
        'query' => "%{$_GET['query']}%"
    ]);
    
    echo json_encode($classes->fetchAll());
