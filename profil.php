<?php
        session_start();
        if (empty($_SESSION['login'])){ // si l'utilisateur est déja connecté il est rediriger vers la page d'accueil.php
            header("Location:index.php");
            exit;
        }

        $message = ""; // variable d'affichage de message d'erreur à déclarer pour éviter un message  d'erreur.
        $already_exist_login = "";

                //je me connecte à la base de donnée moduleconnexion et je récupère les donnée de la table avec $data.
        $connectDatabase = mysqli_connect("localhost", "root", "", "livreor",3307);

                //$connectDatabase = mysqli_connect("localhost", "root", "", "livreor",3307);
        $request = $connectDatabase->query('SELECT login , password FROM utilisateurs');
        $data = $request->fetch_all();  //je recupere tous les donné en une fois avec fetch_all.
        
                // nouvelle requete pour avoir le pré-remplis de l'utilisateur connecté
        $connectDatabase2 = mysqli_connect("localhost", "root", "", "livreor",3307);
        $filled = $_SESSION['login'];
        $sql_select = "SELECT `login` , `password` FROM utilisateurs WHERE login = '$filled'";
        $request_info = $connectDatabase2->query($sql_select);
        $user_info = $request_info->fetch_all();
        //var_dump($user_info);
        $login_prefilled = $user_info[0][0];

        if (isset($_POST['submit'])) {

            if ( $_POST['current_password'] && $_POST['new_password'] && $_POST['password_confirm']) {

                $current_password = trim($_POST['current_password']); 
                $new_password   = trim($_POST['new_password']);
                $password_confirm = trim($_POST['password_confirm']);
                $change_password_ok = false;
                $current_password_check = false;
                
                foreach ($data as $user_password_db) {

                    if ( $current_password != $user_password_db[1] ) {
                        $message = "le mot de passe actuel ne correspond pas";
                    } else {
                        $message = "Correspond!";
                        $current_password_check = true; 
                    }

                    if ( $new_password == $password_confirm ) {
                        $message = "les mdp correpond!!";
                        $change_password_ok = true;
                    } else {
                        $message = "les nouveau mot de passe ne correspond !!";
                    }

                    if ( $change_password_ok = true && $current_password_check = true ) {
                        $update = "UPDATE `utilisateurs` SET `password` = '$new_password' WHERE `utilisateurs`.`login` = '$filled'";
                        $request_change_password = $connectDatabase->query($update);
                        header("Location:profil.php");
                    }

                }
                
            } else {
                $message = "vous devez remplir tous les champ mot de passe !";
            }


            if ( $_POST['login'] && $_POST['current_password'] ) {
                
                $new_login = htmlspecialchars(trim($_POST['login']));   
                $current_password = htmlspecialchars(trim($_POST['current_password'])); 

                foreach ($data as $user_login_db) {
                    
                    $user_password_db = $user_login_db[1];
                    $user_login_ok = false;
                          // condition pour changer le login avec validation du mdp actuel 
                    if ( $filled == $user_login_db[0] && !empty($new_login) && 
                    $current_password == $user_password_db ) {
        
                        $update = "UPDATE `utilisateurs` SET `login` = '$new_login'  WHERE `utilisateurs`.`login` = '$filled'";
                        $request_change_password = $connectDatabase->query($update);
                        $message = "Succes !!";
                        $_SESSION['login'] = $new_login;
                        header("Location:profil.php");

                    } else {
                        $message = "erreur sur le mot de passe actuel";
                    }    
                        // condition si le login existe déjà dans la bdd
                    if ( $new_login == $user_login_db[0] && $new_login != $filled ) {
                        $message = "le login est déjà pris";
                        break;
                    } 
                    
                }
            }
        }

                    


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="widthfr, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Profil</title>
</head>
<body>
    <?php include("header.php"); ?>
    <main>
        <section>
            <div class="container-form">
                <h1>Votre profil</h1>
                <p class="msg-error"><?= $message ?></p>
                <form method="post">
                    <label for="flogin">Login</label>
                        <input type="text" name="login" value=<?= $login_prefilled ?> placeholder="Choisissez votre login">
                    <label for="fcurrentpassword">renseigner votre mot de passe actuel pour tout changement</label>
                        <input type="password" name="current_password" placeholder="votre mot de passe actuel">
                    <label for="fpassword">Mot de Passe</label>
                        <input type="password" value="" name="new_password" placeholder="Mot de Passe">
                        <input type="password" name="password_confirm" placeholder="Confirmer le mot de Passe">
                        <input type="submit" name="submit" value="valider">
                </form>
            </div>
        </section> 
    </main>
</body>
</html>