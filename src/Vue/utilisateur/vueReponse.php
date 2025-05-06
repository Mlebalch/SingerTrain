<?php
/**
 * @var \App\Modele\DataObject\Artiste $artiste
 * @var  bool $reponse
 * @var  string $title
 * @var  string $image
 * @var  array $anime
 */
?>
<div class="result-container <?= $reponse ? 'success' : 'error' ?>">
    <div class="result-card">
        <h1><?= $reponse ? '🌟 Correct !' : '💥 Incorrect !' ?></h1>
        <img src="<?= $image ?>" class="artist-portrait">
        <div class="artist-info">
            <h2><?= $artiste->getNomDeScene() ?></h2>
            <p>Réel nom : <?= $artiste->getNom() ?> <?= $artiste->getPrenom() ?></p>
        </div>
        <div class="action-buttons">
            <form method="post">
                <button type="submit" name="Next" class="btn">Suivant ▶</button>
                <button type="submit" name="Stop" class="btn btn-danger">Arrêter ⏹</button>
                <input type="hidden" name="controleur" value="utilisateur">
                <input type="hidden" name="action" value="next">
            </form>
        </div>
    </div>
</div>
