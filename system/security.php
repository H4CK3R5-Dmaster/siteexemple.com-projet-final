<?php
    //demarrage d'une session
    session_start();
    //si la session auth n'existe pas alors on redirige vers le login
    if (!isset($_SESSION['auth'])) {
        header('Location: ../auth/login/');
    }


?>