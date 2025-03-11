<?php

use App\Lib\MessageFlash;
use App\Modele\HTTP\Session;

$volume = isset($_COOKIE["volume"]) ? $_COOKIE["volume"] : 0.15;

$songs = isset($_SESSION['songs']) ? $_SESSION['songs'] : [];
$artistes = isset($_SESSION['artistes']) ? $_SESSION['artistes'] : []; // Assurez-vous de définir cette variable ou de la récupérer d'une autre manière

echo "<h1>Guess the artist</h1>";
echo "<p>Score: {".$_SESSION['score']."}</p>";
$index = rand(0, count($_SESSION['dico']) - 1);
var_dump($index);
var_dump($_SESSION['dico'][$index]['song']);
$song = $_SESSION['dico'][$index]['song'] ?? null;
$artiste = $_SESSION['dico'][$index]['artiste'] ?? null;
    echo "<audio id='audio' autoplay loop>";
    echo "<source src='{$song}' type='audio/mpeg'>";
    echo "</audio>";

     echo '<form method="post" action="">
     <label for="artist">Guess the artist:</label>
     <input type="text" id="artist" name="artist">
     <input type="hidden" name="correct_artist" value="' . htmlspecialchars($artiste, ENT_QUOTES) . '">
     <input type="hidden" name="index" value="' . $index . '">
     <input type="submit">
     <input type="hidden" name="action" value="reponse">
     <input type="hidden" name="controleur" value="utilisateur">
 </form>

<input type="range" id="volumeSlider" min="0" max="0.3" step="0.001" value="'.$volume.'">

<script>
    const audio = document.getElementById("audio");
    const volumeSlider = document.getElementById("volumeSlider");
    
     volumeSlider.addEventListener("input", function () {
         audio.volume = this.value;
         document.cookie = "volume=" + this.value;
     });

     document.addEventListener("DOMContentLoaded", function () {
         audio.volume = volumeSlider.value;
     });

 </script>';


