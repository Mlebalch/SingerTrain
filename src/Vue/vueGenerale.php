<?php

/** @var string $titre */
/** @var string $cheminCorpsVue */
/** @var array $messagesFlash */

use App\Lib\MessageFlash;
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
        <h1>Header</h1>

    <nav>
        <ul>
            <li><a href="?controleur=utilisateur&action=afficherAccueil">Accueil</a></li>
            <li><a href="?controleur=utilisateur&action=launch">Game</a></li>
            <li><a href="?controleur=utilisateur&action=score">Score</a></li>
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