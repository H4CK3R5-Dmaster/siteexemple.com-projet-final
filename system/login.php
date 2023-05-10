<?php
    //ouverture d'une session
    session_start();
    //la database est requis
    require('db.php');
    //si l'evenement qui contient validat existe alors on fait le programme
    if(isset($_POST['validate'])) {
        
        //on verifie si les champs ne sont pas vide
        if (!empty($_POST['username']) AND !empty($_POST['passworde'])) {
            //on recupere les champs
            $user = $_POST['username'];
            $psw = $_POST['passworde'];

            //on check si le username existe dans la database
            $checkUserExist = $bdd->prepare('SELECT * FROM users WHERE username = ?');
            $checkUserExist->execute(array($user));

            //si le username existe on continue le programme sinon on renvoie une erreur disant que le username n'existe pas
            if($checkUserExist->rowCount() > 0){

                //on recup les infos du user 
                $userInfos = $checkUserExist->fetch();
                $pass = $userInfos['mdp'];
                $verified = $pass ? password_verify($psw, $pass) : "";
                
                //on verifie si le mdp donner et mdp de la database sont pareil
                if($verified == true) {
                    //on transfert les infos dans une session
                    $_SESSION['auth'] = true;
                    $_SESSION['id'] = $userInfos["id"];
                    $_SESSION['username'] = $userInfos["username"];
                    $_SESSION['nom'] = $userInfos['nom'];
                    $_SESSION['prenom'] = $userInfos['prenom'];
                    //on redirige vers le home
                    
                    header('Location: ../../../homepage/');
                    
                    

                } else {
                    header('HTTP/1.1 401 Unauthorized');
                    error_log($_SERVER['REMOTE_ADDR'] . ' - ' . date('Y-m-d H:i:s') . ' - ' . $_SERVER['REQUEST_URI'] . ' - Connexion échouée: Nom d\'utilisateur ou mot de passe incorrect' . "\n", 3, 'access.log');
                    $errorMsg = "<script>alert('Wrong password...')</script>";
                    
                }

            } else {
                header('HTTP/1.1 401 Unauthorized');
                error_log($_SERVER['REMOTE_ADDR'] . ' - ' . date('Y-m-d H:i:s') . ' - ' . $_SERVER['REQUEST_URI'] . ' - Connexion échouée: Nom d\'utilisateur ou mot de passe incorrect' . "\n", 3, 'access.log');
                $errorMsg = "<script>alert('Username does not exist...')</script>";
            }
           
            
        } else {
            header('HTTP/1.1 401 Unauthorized');
            error_log($_SERVER['REMOTE_ADDR'] . ' - ' . date('Y-m-d H:i:s') . ' - ' . $_SERVER['REQUEST_URI'] . ' - Connexion échouée: Nom d\'utilisateur ou mot de passe incorrect' . "\n", 3, 'access.log');
            $errorMsg = "<script>alert('Please complete all fields...')</script>";
        }
    }
?>
