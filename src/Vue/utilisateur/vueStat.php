<?php

/**
 *@var array $stat \App\Modele\DataObject\Stat
 * @var array $image
 */

for ($i = 0; $i < count($stat); $i++) {
    echo  "
    <div class='card'>
    <img src='" . $image[$i]->getimage(). "' class='card-img-top' alt='...'>
        <div class='card-body' >
            <h5 class='card-title
            '>" . $stat[$i]->getNomDeScene() . "</h5>
            <p class='card-text'>Nombre de tentative : " . $stat[$i]->getNbrTentative() . "</p>
            <p class='card-text'>Nombre d'artiste trouvé : " . $stat[$i]->getNbrArtisteTrouver() . "</p>
        </div>
<br>";
}