<?php 
session_start();
if (!$_SESSION['login']) {
    header("Location:livre-or.php");
} 

$message = "";

$connectDatabase = mysqli_connect("localhost", "root", "", "livreor",3307);
$request = $connectDatabase->query('SELECT * FROM commentaires');
$data = $request->fetch_all();

    //var_dump($data);
    
    if (isset($_POST['submit'])) {
        $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES);
        $send_comment = false;
        $userId = $_SESSION['id'];

        if (isset($comment) && !empty($comment)) {
            $send_comment = true;

        } else {
            $message = "le champ est vide, veuillez écrire votre commentaire";
        }

        if ($send_comment) {
            $request = $connectDatabase->query("INSERT INTO commentaires(commentaire,id_utilisateur,date) VALUES ('$comment', '$userId', NOW())");
            header("Location:livre-or.php");
        }

    }

    

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Commentaire</title>
</head>
<body>
    <main> 
        <?php include("header.php");  ?>
        <section>
            <form class="container-form" method="post">
                <p style="color:red"><?= $message ?></p>
                <label for="fcomment">connecté en tant que :<?= $_SESSION['login']; ?></label>
                <textarea name="comment" id="comment" cols="62" rows="10"></textarea>
                <input type="submit" name="submit" value="envoyer">
            </form>
        </section>
    </main>
</body>
<?php include("footer.php"); ?>
</html>