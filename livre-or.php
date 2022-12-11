<?php 
session_start();

$database_Host = 'localhost';
$database_User = 'root';
$database_Pass = '';
$database_Name = 'livreor';

$con = mysqli_connect($database_Host, $database_User, $database_Pass, $database_Name, 3307);
$request = $con->query('SELECT `date` , `login` , `commentaire` FROM utilisateurs INNER JOIN commentaires ON utilisateurs.id = commentaires.id_utilisateur ORDER BY `date` DESC ');
$data = $request->fetch_All();
 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>livre d'or</title>
</head>
<body>
<?php include("header.php");?>
    <main>
        <section>
        <h1 class="golden_book_title">Livre d'or</h1>    

            <?php foreach ($data as $info) {
                $dateold = $info[0];
                $date = date('d-m-Y H:i:s', strtotime($dateold));
                $pseudo = $info[1]; 
                $comment = $info[2];   
                
                echo '<div class="comment_box">
                        <div class="user_info_box">
                            <img src="import/profil-vide.png" class="profil_picture" alt="image de profil">
                            <div>
                                <h3>'.$pseudo.'</h3>
                                <p>posté le '.$date.' </p>
                            </div>
                        </div>
                        <div class="comment_display">
                            <p>'.$comment.'</p>
                        </div>
                      </div>';      
            }
            ?>
            
            

        </section>    
    </main>
</body>
</html>