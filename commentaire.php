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
            echo "le champs est vide";
        }

        if ($send_comment) {
            $request = $connectDatabase->query("INSERT INTO commentaires(commentaire,id_utilisateur,date) VALUES ('$comment', '$userId', NOW())");
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
            <form method="post">
                <?= $message ?>
                <label for="fcomment">utilisateur connecté</label>
                <textarea name="comment" id="comment" cols="110" rows="10"></textarea>
                <input type="submit" name="submit" value="envoyer">
            </form>
        </section>
    </main>
</body>
</html>