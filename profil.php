<?php
        session_start();
        if (empty($_SESSION['login'])){ // si l'utilisateur est déja connecté il est rediriger vers la page d'accueil.php
            header("Location:index.php");
            exit;
        }

        $message = ""; // variable d'affichage de message d'erreur à déclarer pour éviter un message  d'erreur.
        $already_exist_login = "";
        $message_password_display = "";
        $display_msg = "";

                //je me connecte à la base de donnée livreor et je récupère les donnée de la table avec $data.
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

            // formulaire de changement de login
        if (isset($_POST['submit_login'])) {

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
            } else {
                $message = "vous devez remplir tous les champ !";
            }
        }

            // formulaire de changement de mot de passe
        if (isset($_POST['submit_pass'])) {

            if ( $_POST['current_password2'] && $_POST['new_password'] && $_POST['password_confirm'] ) {
                
                $current_password = trim($_POST['current_password2']); 
                $new_password   = trim($_POST['new_password']);
                $password_confirm = trim($_POST['password_confirm']);
                $change_password_ok = "non";
                $current_password_check = "non";


                foreach ($user_info as $user_password_db) {
                    //var_dump($user_password_db);
                    if ( $current_password != $user_password_db[1] ) {
                        $display_msg = '<p style ="color:red; text-align:center">mot de passe actuel invalid!</p>';
                        $current_password_check = "non";
                        break;
                    } else {
                        //$display_msg = '<p style ="color:green; text-align:center; font-weight:bold">mot de passe actuel ok</p>';
                        $current_password_check = "oui"; 
                    }

                    if ( $new_password == $password_confirm ) {
                        $message_password_display = '<p style ="color:green; text-align:center; font-weight:bold">les mdp correpond</p>';
                        $change_password_ok = "oui";
                        $send = $new_password;
                    } else {
                        $change_password_ok = "non";
                        $message_password_display = '<p style="color: red; text-align: center">la confirmation du nouveau mot de passe ne correspond pas!!</p>';
                    }        

                }

                
                    if ( $change_password_ok === "oui" && $current_password_check === "oui" ) {
                        $update = "UPDATE `utilisateurs` SET `password` = '$send' WHERE `utilisateurs`.`login` = '$filled'";
                        $request_change_password = $connectDatabase->query($update);
                        //header("Location:profil.php");
                        $display_msg = '<p style ="color:green; text-align:center; font-weight:bold">changement validé</p>';

                    }

            } else {
                $message_password_display = '<p style="color: red; text-align: center">vous devez remplir tous les champ mot de passe !</p>';
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
            <div class="container_profil">
                <h1 class="profil_title">Profil</h1>
                <div class="form_flex">
                    <div class="container-form">
                        <h2>changer de login</h2>
                        <p class="msg-error"><?= $message ?></p>
                        <form method="post">

                            <label for="flogin">Login</label>
                                <input type="text" name="login" value=<?= $login_prefilled ?> placeholder="Choisissez votre login">
                            <label for="">renseigner votre mot de passe actuel pour tout changement</label>
                                <input type="password" name="current_password" placeholder="votre mot de passe actuel">
                                <input type="submit" name="submit_login" value="valider">

                        </form> 
                    </div>   

                    <div class="container-form">        
                        <form method='post'>

                            <h2>changer de mot de passe</h2>
                            <?= $message_password_display ?><?= $display_msg ?>
                            <label for="">renseigner votre mot de passe actuel pour tout changement</label>
                            
                                <input type="password" name="current_password2" placeholder="votre mot de passe actuel">
                            <label for="fpassword">Mot de Passe</label>
                                <input type="password" value="" name="new_password" placeholder="Nouveau mot de Passe">
                                <input type="password" name="password_confirm" placeholder="Confirmer le mot de Passe">
                                <input type="submit" name="submit_pass" value="valider">

                        </form>
                    </div>    
                </div>
            </div>    
        </section> 
    </main>
</body>
</html>