<?php
    //demarrage d'une session
    session_start();
    //la database est requis
    require('db.php');
    //si validate (nom du bouton) apparait alors on fait le programme suivant
    if(isset($_POST['validate'])) {
        
        //verifies si les inputs ne sont pas vide et si le confirm mdp = mdp
        if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['password']) AND !empty($_POST['username']) AND $_POST['password'] == $_POST['passconfirm']) {
            //on recup les informations du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $user = $_POST['username'];
            //on crypte le mdp en md5
            $psw = password_hash($_POST['password'], PASSWORD_BCRYPT);

            //on va check si le user et le mail existe ou pas 1er temps on prepare la requete SELECT
            $chekUser = $bdd->prepare('SELECT username FROM users WHERE username = ?');
            

            //2e temps on execute avec les variables qui contiennent les informations user et mail de l'utilisateur
            $chekUser->execute(array($user));
            

            //si le mail et le username n'existe pas dans la bdd alors on fait le programme suivant
            if ($chekUser->rowCount() == 0) {

                //on prepare l'insertion dans la bdd
                $insertUser = $bdd->prepare("INSERT INTO users(nom, prenom, username, password)VALUES(?, ?, ?, ?)");

                //on execute l'insertion
                $insertUser->execute(array($nom, $prenom, $user, $psw));
                

                //on va recup les informations pour la session donc on prepare le select et on l'execute
                $getInfo = $bdd->prepare('SELECT * FROM users WHERE username = ?');
                $getInfo->execute(array($user));

                $userInfos = $getInfo->fetch();

                //on donne les infos à la session
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $userInfos["id"];
                $_SESSION['nom'] = $userInfos["nom"];
                $_SESSION['nom'] = $userInfos["prenom"];
                $_SESSION['username'] = $userInfos["username"];
                

                //on redirige vers le home
                header('Location: ../../homepage/');
            } else {
                //si le username et/ou le mail existe une popup alert apparaitra
                $errorMsg = "<script>alert('Username allready exist or mail allready exist..')</script>";
            }
        } else {
            //si le formulaire n'est pas rempli ou si il manque des choses alors une popup alert apparaitra
            $errorMsg = "<script>alert('Please complete all fields...')</script>";
        }
    }

?>