<?php

/**
 *@var array $stat \App\Modele\DataObject\Stat
 */

foreach ($stat as $stats) {
    echo $stats->getNomDeScene() . " " . $stats->getNbrTentative() . " " . $stats->getNbrArtisteTrouver() . "<br>";
}