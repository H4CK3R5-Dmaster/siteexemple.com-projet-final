<?php
    //on start la session
    session_start();
    //session sera un tableau vide
    $_SESSION = [];
    //on detruit la session
    session_destroy();
    //on redirige vers le login
    header("Location: ../index.php");

?>