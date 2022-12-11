<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>
<body>
    <?php session_start(); include("header.php");?>
    <main>
        <section>
            <div class="display_container">
                <?php if (!empty($_SESSION['login'])): ?>
                    <h1>Bienvenue <?= $_SESSION['login'] ?></h1>
                <?php else: ?>
                    <h1>Bienvenue</h1>
                <?php endif; ?>     
            </div>
            
        </section>
        
    </main>
    <?php include("footer.php"); ?>
    
</body>
</html>