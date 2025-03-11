<?php

/**
 *@var array $stat \App\Modele\DataObject\Stat
 */

foreach ($stat as $stat) {
    echo $stat->getNomDeScene() . " " . $stat->getNbrTentative() . " " . $stat->getNbrArtisteTrouver() . "<br>";
}