<?php

use App\Lib\MessageFlash;
use App\Modele\HTTP\Session;

if (isset($_COOKIE["volume"])) {
    $volume = $_COOKIE["volume"]; // Récupération du volume
    echo '<script>
        const audiocookie = document.getElementById("audio");
        if (audiocookie) {
            audiocookie.volume = ' . json_encode($volume) . ';
        }
            console.log('.json_encode($volume).')
    </script>';
}

$songs = isset($_SESSION['songs']) ? $_SESSION['songs'] : [];
$artistes = isset($_SESSION['artistes']) ? $_SESSION['artistes'] : []; // Assurez-vous de définir cette variable ou de la récupérer d'une autre manière

echo "<h1>Guess the artist</h1>";
echo "<p>Score: {".$_SESSION['score']."}</p>";

if (is_array($songs) && !empty($songs)) {
    $index = rand(0, count($songs) - 1);
    $song = $songs[$index];
    $artiste =  $artistes[array_search($song, $songs)] ?? '';
    echo "<audio id='audio' autoplay loop>";
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
     <input type="hidden" name="correct_artist" value="' . htmlspecialchars($artiste, ENT_QUOTES) . '">
     <input type="hidden" name="index" value="' . $index . '">
     <input type="submit">
     <input type="hidden" name="action" value="reponse">
     <input type="hidden" name="controleur" value="utilisateur">
 </form>

 <input type="range" id="volumeSlider" min="0" max="0.8" step="0.05" value="0.4">

 <script>
     const audio = document.getElementById("audio");
     const volumeSlider = document.getElementById("volumeSlider");

     volumeSlider.addEventListener("input", function () {
         audio.volume = this.value;
     });
     document.cookie = "volume="+audio.volume+"; path=/;"
 </script>';     
} else {
    echo "No songs available.";
}

