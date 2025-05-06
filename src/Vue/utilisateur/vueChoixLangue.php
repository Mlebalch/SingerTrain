<?php
/** @var array $langues */
use App\Modele\Repository\CategorieRepository;
?>

<div class="main-content language-chooser">
    <?php if(!isset($_REQUEST['langue'])) : ?>

        <!-- Étape 1 : Choix de la langue -->
        <h1 class="game-title neon-text">Sélectionnez votre langue</h1>

        <div class="grid-container">
            <?php foreach ($langues as $langue): ?>
                <?php
                $countryCode = strtolower($langue->getXRegion());
                $languageName = htmlspecialchars($langue->getLangue());
                ?>
                <a href="?controleur=utilisateur&action=afficherChoixLangue&langue=<?= urlencode($langue->getLangue()) ?>"
                   class="choice-card neon-box">
                    <div class="flag-container">
                        <span class="fi fi-<?= $countryCode ?> fis flag-icon"></span>
                        <div class="flag-glow"></div>
                    </div>
                    <h3 class="language-name"><?= $languageName ?></h3>
                </a>
            <?php endforeach; ?>
        </div>

    <?php else: ?>

        <!-- Étape 2 : Choix de la catégorie -->
        <div class="selection-header">
            <?php
            $currentLang = current(array_filter($langues, fn($l) => $l->getLangue() === $_REQUEST['langue']));
            $countryCode = strtolower($currentLang->getXRegion());
            ?>

            <div class="selected-language-banner">
                <span class="fi fi-<?= $countryCode ?> fis flag-pulse"></span>
                <h2 class="neon-text flicker"><?= htmlspecialchars($_REQUEST['langue']) ?></h2>
            </div>

            <div class="category-grid">
                <?php
                $categories = (new CategorieRepository())->getByLangue($_REQUEST['langue']);
                foreach ($categories as $categorie): ?>
                    <a href="?controleur=utilisateur&action=launch&langue=<?= urlencode($_REQUEST['langue']) ?>&categorie=<?= urlencode($categorie->getType()) ?>"
                       class="category-card neon-link">
                        <div class="genre-pattern"></div>
                        <div class="genre-content">
                            <span class="animated-icon">🎵</span>
                            <h3><?= htmlspecialchars($categorie->getType()) ?></h3>
                            <div class="particles">
                                <?php for ($i=0; $i<3; $i++): ?>
                                    <div class="particle" style="
                                            left: <?= rand(10, 90) ?>%;
                                            animation-delay: <?= rand(0, 2000) ?>ms;
                                            "></div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>

                <a href="?controleur=utilisateur&action=launch&langue=<?= urlencode($_REQUEST['langue']) ?>&categorie=tous"
                   class="category-card all-categories neon-link">
                    <div class="galaxy-animation"></div>
                    <span class="icon-globe">🌐</span>
                    <h3>Toutes les catégories</h3>
                </a>
            </div>

            <a href="?controleur=utilisateur&action=afficherChoixLangue"
               class="btn-neon back-button">
                <span class="arrow-icon">◄</span> Retour aux langues
            </a>
        </div>

    <?php endif; ?>
</div>

