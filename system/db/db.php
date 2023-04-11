<?php
    
    try {
        
        $bdd = new PDO('mysql:host=localhost;dbname=siteexemple.com;charset=utf8;', 'root', '');
       
    } catch (Exception $e) {
        
        die('error : '.$e->getMessage());
    }

    

?>