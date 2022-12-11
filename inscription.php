<?php
        session_start();
        if (!empty($_SESSION['login'])){ // si l'utilisateur est déja connecté il est rediriger vers la page d'accueil.php
            header("Location:index.php");
            exit;
        }

        $message = ""; // variable d'affichage de message d'erreur à déclarer pour éviter un message  d'erreur.


        //je me connecte à la base de donnée moduleconnexion et je récupère les donnée de la table avec $data.
        $connectDatabase = mysqli_connect("localhost", "root", "", "livreor",3307);
        //$connectDatabase = mysqli_connect("localhost:3306", "root", "", "livreor",3307);
        $request = $connectDatabase->query('SELECT login , password FROM utilisateurs');
        $data = $request->fetch_all();  //je recupere tous les donné en une fois avec fetch_all.




        // si j'appuie sur le boutton submit
        if (isset($_POST["submit"])) { 
                
            // si tous les champs sont remplis        
            if ($_POST['login'] && $_POST['password'] && $_POST['password_confirm']) { 

                $login      = htmlspecialchars(trim($_POST['login']));
                $password   = htmlspecialchars(trim($_POST['password']));
                $password_confirm = htmlspecialchars(trim($_POST['password_confirm']));

                
                // si password et password_confirm sont identique
                if ($password == $password_confirm) {
                        $loginOk = false;
                        
                        // Je lis dans le tableau de la base de donées avec une boucle
                        foreach ($data as $user) { 
                            
                            //une condition dans le cas ou le login existe déjà 
                            if ( $login == $user[0] ) { 

                                $message = "le login est déja pris";
                                $loginOk = false;
                                break;
                            } else {
                                $loginOk = true;
                            }
                
                        }

                        // on insert l'user dans la bdd et on fait une redirection vers la page connexion
                        if ( $loginOk ) { 
                            $request = $connectDatabase->query("INSERT INTO utilisateurs(login, password) VALUES ('$login','$password')");
                            header("Location:connexion.php");    
                        }

                } else {
                    $message = "le mot de passe de confirmation n'est pas identique!";
                }

            } else {
                $message= "vous devez remplir tous les champs !";
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
    <title>Inscription</title>
</head>
<body>
    <?php include("header.php"); ?>
    <main>
        <section>
            <div class="container-form">
                <h1>Inscription</h1>
                <p class="msg-error"><?= $message ?></p>
                <form method="post">
                    <label for="flogin">Login</label>
                    <input type="text" name="login" placeholder="Choisissez votre login">
                    <label for="fpassword">Mot de Passe</label>
                    <input type="password" name="password" placeholder="Mot de Passe">
                    <input type="password" name="password_confirm" placeholder="Confirmer le mot de Passe">
                    <input type="submit" name="submit" value="valider">
                </form>
            </div>
        </section> 
    </main>
    <?php include("footer.php"); ?>
</body>
</html>