<header>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="livre-or.php">Livre d'or</a></li>
            <li><a href="commentaire.php">Commentaire</a></li>
            <?php if (!empty($_SESSION['login'])): ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
            <?php else: ?>
                <li><a href="inscription.php">Inscription</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
            <?php endif; ?>                  
        </ul>
    </nav>
</header>