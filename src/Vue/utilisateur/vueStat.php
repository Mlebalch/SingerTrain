<?php

/**
 *@var array $stat \App\Modele\DataObject\Stat

 */

use App\Modele\Repository\ArtisteRepository;

?>
<div class="stats-grid">
    <?php foreach ($stat as $index => $artistStat): ?>
        <?php
        $artiste = (new ArtisteRepository())->getByPrimaryKeys([$artistStat->getNomDeScene()]);
        $image = $artiste->getImage();
        if ($image == null) {
            $image = "resources/Unknown.png";
        } else {
            $image = $artiste->getImage();
        }
        ?>
        <div class="stat-card">
            <img src="<?=  $image ?>" class="stat-image">
            <div class="stat-content">
                <h3 class="neon-text"><?= $artistStat->getNomDeScene() ?></h3>
                <div class="stat-meter">
                    <div class="meter-bar" style="width: <?= ($artistStat->getNbrArtisteTrouver()/$artistStat->getNbrTentative())*100 ?>%"></div>
                </div>
                <p>Tentatives : <?= $artistStat->getNbrTentative() ?></p>
                <p>Réussites : <?= $artistStat->getNbrArtisteTrouver() ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>