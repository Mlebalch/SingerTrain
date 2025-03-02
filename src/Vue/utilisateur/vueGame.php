<?php

use App\Lib\MessageFlash;
use App\Modele\HTTP\Session;



$songs = isset($_SESSION['songs']) ? $_SESSION['songs'] : [];
$artistes = isset($_SESSION['artistes']) ? $_SESSION['artistes'] : []; // Assurez-vous de définir cette variable ou de la récupérer d'une autre manière

echo "<h1>Guess the artist</h1>";
echo "<p>Score: {$_SESSION['score']}</p>";

if (is_array($songs) && !empty($songs)) {
    $index = rand(0, count($songs) - 1);
    $song = $songs[$index];
    $artiste =  $artistes[array_search($song, $songs)] ?? '';
    echo "<audio controls>";
    echo "<source src='{$song}' type='audio/mpeg'>";
    echo "</audio>";

   /* foreach ($songs as $song) {
        echo $artiste[array_search($song, $songs)] ?? '';
        echo "<audio controls>";
        echo "<source src='{$song}' type='audio/mpeg'>";
        echo "</audio>";
     }*/
    echo '<form method="post" action="">
            <label for="artist">Guess the artist:</label>
            <input type="text" id="artist" name="artist">
            <input type="hidden" name="correct_artist" value="' . $artiste . '">
            <input type="hidden" name="index" value="' . $index . '">
            <input type="submit">
             <input type="hidden" name="action" value="reponse">
             <input type="hidden" name="controleur" value="utilisateur">
            
          </form>';
} else {
    echo "No songs available.";
}
