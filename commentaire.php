<?php 

$message = "";

$connectDatabase = mysqli_connect("localhost", "root", "", "livreor",3307);
$request = $connectDatabase->query('SELECT * FROM commentaires');
$data = $request->fetch_all();

    var_dump($data);
    //echo $data[0][2];
    if (isset($_POST['submit'])) {
        $comment = $_POST['comment'];
        $send_comment = false;

        if (isset($comment) && !empty($comment)) {
            $send_comment = true;

        } else {
            echo "le champs est vide";
        }

        if ($send_comment) {
            $request = $connectDatabase->query("INSERT INTO commentaires(commentaire,id_utilisateur,date) VALUES ('$comment', 1, NOW())");
            //header("Location:commentaire.php");
        }

    }

    

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaire</title>
</head>
<body>
    <main> 
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