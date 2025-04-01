<?php
/**
 * @var \App\Modele\DataObject\Artiste $artiste
 * @var  bool $reponse
 * @var  string $title
 * @var  string $image
 * @var  array $anime
 */


if ($reponse) {
    echo "<h1>Correct!</h1>";
} else {
    echo "<h1>Incorrect!</h1>";
}

echo "<img src=".$image.">";
echo "<h2>Artist : {$artiste->getNomDeScene()}</h2>";
echo "<h2>Real name : {$artiste->getNom()} {$artiste->getPrenom()}</h2>";
echo "<h2>Titre : ".$title."</h2>";
echo "<a href='{$artiste->getLienNautijon()}'>Nautijon</a>";

if (isset($anime['songs']) && is_array($anime['songs'])) {
        foreach ($anime['songs'] as $song) {
            if ($song['version'] == null) {
            echo "<h2>Anime : " . $song['anime'][0]['name'] . "</h2><br>";
            break;
            }
        }
    }
else {
    echo "<h2>Aucune chanson trouvée</h2>";
}
echo "<h2>Score: {$_SESSION['score']}</h2>";
echo "<h2>Tentative: {$_SESSION['tentative']}</h2>";
echo "<br>
<br>
    <form method=\"post\" action=\"\">
        <input type=\"submit\" value=\"Next\" name='next'>
        <input type=\"submit\" value=\"Stop\" name='stop'>
        <input type='hidden' name='controleur' value='utilisateur'>
        <input type='hidden' name='action' value='next'>
<br><br>
<br><br>";