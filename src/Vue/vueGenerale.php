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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../ressources/style.css">
</head>

<body>

<script src="../ressources/script.js"></script>
    <header>

    <nav>
        <ul>
            <li><a href="?controleur=utilisateur&action=afficherAccueil">Accueil</a></li>
            <li><a href="?controleur=utilisateur&action=launch">Game</a></li>

            <?php
            if (ConnexionUtilisateur::estConnecte() && ConnexionUtilisateur::getUtilisateurConnecte() != null) {
               if (ConnexionUtilisateur::estAdmin()) {

                   echo "<li>";
                   echo "<a href=''> <img src='../ressources/icons/setting.svg' alt='' class='icon'> Setting</a>";
                   echo "<ul><li><a href='?controleur=admin&action=afficherVueFormulaireUtilisateurAdmin'>Crées un admin</a></li> ";
                   echo "<li><a href='?controleur=admin&action=afficherVueFormulaireAjoutArtiste'>Ajout d'Artiste</a></li> ";
                     echo "<li><a href='?controleur=admin&action=afficherVueFormulaireAjoutArtistes'>Ajout plusieur Artiste</a></li> ";
                   echo "<li><a href='?controleur=admin&action=afficherVueModificationArtiste'>Modification d'Artiste</a></li> </ul>";

                     echo "</li>";
               }
                echo "<li><a href='?controleur=utilisateur&action=afficherVueStat'>Stat</a></li>";
                echo "<li>";
                echo "<a href=''> <img src='../ressources/icons/user.svg' alt='' class='icon'> ". ConnexionUtilisateur::getUtilisateurConnecte()->getLogin() ."</a>";
                echo "<ul><li><a href='?controleur=utilisateur&action=afficherFormulaireModification'>Modification</a></li> ";
                echo "<li><a href='?controleur=utilisateur&action=deconnexion'>Déconnexion</a></li></ul>";

                echo "</li>";
            }
            else{
                echo "<li> <a href='?controleur=utilisateur&action=afficherFormulaireConnexion'> <img src='../ressources/icons/user.svg' alt='' class='icon'> Connexion</a></li>";
            }
            ?>


        </ul>
    </nav>
        <?php

            /** @var string[][] $messagesFlash */
            if (isset($messagesFlash))
            {
                foreach ($messagesFlash as $type => $messagesFlashPourUnType) {
                    // $type est l'une des valeurs suivantes : "success", "info", "warning", "danger"
                    // $messagesFlashPourUnType est la liste des messages flash d'un type
                    foreach ($messagesFlashPourUnType as $messageFlash) {
                        echo "<script> displayFlashMessage(\"$messageFlash\", \"$type\"); </script>";
                    }
                }
            }
            ?>
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