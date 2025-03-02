<?php
/**
 * @var array $artiste
 * @var  bool $reponse
 */


if ($reponse) {
    echo "<h1>Correct!</h1>";

} else {
    echo "<h1>Incorrect!</h1>";


}

echo "<h2>Artist: {$artiste->getNomDeScene()}</h2>";
echo "<h2>Real name: {$artiste->getNom()} {$artiste->getPrenom()}</h2>";
echo "<a href='{$artiste->getLienNautijon()}'>Nautijon</a>";

echo "<h2>Score: {$_SESSION['score']}</h2>";
echo "<h2>Tentative: {$_SESSION['tentative']}</h2>";

echo "<a href='?controleur=utilisateur&action=next'>Next</a>";