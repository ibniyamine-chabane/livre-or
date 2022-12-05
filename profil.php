<?php
        session_start();
        if (empty($_SESSION['login'])){ // si l'utilisateur est déja connecté il est rediriger vers la page d'accueil.php
            header("Location:index.php");
            exit;
        }

        $message = ""; // variable d'affichage de message d'erreur à déclarer pour éviter un message  d'erreur.


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
        var_dump($user_info);
        $login_prefilled = $user_info[0][0];
        $password_prefilled = $user_info[0][1];
        //echo $user_info[0][0];

        
        if (isset($_POST["submit"])) { // si j'appuie sur le boutton submit
                
                    
            if ($_POST['login'] && $_POST['password'] && $_POST['password_confirm']) { // si tous les champs sont remplis

                $login      = $_POST['login'];
                $password   = $_POST['password'];
                $password_confirm = $_POST['password_confirm'];

                if ($password == $password_confirm) {// si password et password_confirm sont identique

                        $loginTaken = true;
                        
                        foreach ($data as $user) { // Je lis dans le tableau de la base de donées avec une boucle

                            //echo $user[0].'</br>'; //test sur l'index $user
                                   
                            if ( $login == $user[0] ) { //une condition dans le cas ou le login existe déja 

                                $message = "le login est déja pris";
                                $loginTaken = true;
                                break;
                            } else {
                                $loginTaken = false;
                            }
                            //echo 'post : '. $_POST['login']; // echo utiliser pour afficher les tests
                            //var_dump($loginOk); //
                            //var_dump($data); 
                        }

                        if ( $loginTaken == false) { // on insert l'user dans la bdd et on fait une redirection vers la page connexion
                            $update = "UPDATE `utilisateurs` SET `login` = '$login', `password` = '$password' WHERE `utilisateurs`.`login` = '$filled'";
                            $request_info = $connectDatabase2->query($update);
                            $_SESSION['login'] = $login;
                            $message = "Votre login et mot de passe a bien été modifier"; 
                            header("Location:profil.php");    
                        }

                } else {
                    $message = "le mot de passe de confirmation n'est pas identique!";
                }

            } else {
                $message= "vous devez remplir tous les champs !";
            }

        }    


       //echo $user[0];


//var_dump($data);
//var_dump($_POST);
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
                    <label for="fpassword">Mot de Passe</label>
                    <input type="password" value=<?= $password_prefilled ?> name="password" placeholder="Mot de Passe">
                    <input type="password" name="password_confirm" placeholder="Confirmer le mot de Passe">
                    <input type="submit" name="submit" value="valider">
                </form>
            </div>
        </section> 
    </main>
</body>
</html>