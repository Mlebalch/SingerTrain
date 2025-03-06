<?php

/** @var string $titre */
/** @var string $cheminCorpsVue */
/** @var array $messagesFlash */

use App\Lib\MessageFlash;
use App\Lib\ConnexionUtilisateur;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($titre); ?></title>
    <link rel="stylesheet" href="../ressources/style.css">
</head>

<body>
    <header>

    <nav>
        <ul>
            <li><a href="?controleur=utilisateur&action=afficherAccueil">Accueil</a></li>
            <li><a href="?controleur=utilisateur&action=launch">Game</a></li>

            <?php
            if (ConnexionUtilisateur::estConnecte() && ConnexionUtilisateur::getUtilisateurConnecte() != null) {
                echo "<li><a href='?controleur=utilisateur&action=afficherVueFormulaireAjoutArtiste'>Ajout d'Artiste</a></li>";
                echo "<li><a href='?controleur=utilisateur&action=score'>Score</a></li>";
                echo "<li><a href='?controleur=utilisateur&action=afficherFormulaireModification'>Modification</a></li> ";
                echo "<li><a href='?controleur=utilisateur&action=deconnexion'>Déconnexion</a></li>";

            }
            else{
                echo "<li> <a href='?controleur=utilisateur&action=afficherFormulaireConnexion'> <img src='../ressources/icons/user.svg' alt='' class='icon'> Connexion</a></li>";
            }
            ?>


        </ul>
    </nav>
    </header>
    <main>
        <div class="content">
            <?php
            require __DIR__ . "/{$cheminCorpsVue}";
            ?>
        </div>
    </main>
    <footer>
        <p>Footer - 2024</p>
    </footer>
</body>
</html>