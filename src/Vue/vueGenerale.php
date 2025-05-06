<?php
/** @var string $titre */
/** @var string $cheminCorpsVue */
/** @var array $messagesFlash */

use App\Lib\MessageFlash;
use App\Lib\ConnexionUtilisateur;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titre) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../ressources/style.css">
    <link rel="stylesheet" href="../ressources/animations.css">
    <script src="../ressources/script.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css">
</head>
<body>
<!-- Menu latéral -->
<nav class="sidebar-nav">
    <div class="menu-header">
        <h2 class="neon-text">SingerTrain</h2>
    </div>
    <a href="?controleur=utilisateur&action=afficherAccueil" class="nav-link">🏠 Accueil</a>
    <a href="?controleur=utilisateur&action=afficherChoixLangue" class="nav-link">🎮 Nouvelle Partie</a>

    <?php if(ConnexionUtilisateur::estConnecte()): ?>
        <a href="?controleur=utilisateur&action=afficherVueStat" class="nav-link">📊 Statistiques</a>
        <?php if(ConnexionUtilisateur::estAdmin()): ?>
            <div class="admin-menu">
                <p class="menu-subtitle">Administration</p>
                <a href="?controleur=admin&action=afficherVueFormulaireAjoutArtiste" class="nav-link">➕ Ajout Artiste</a>
                <a href="?controleur=admin&action=afficherVueFormulaireAjoutArtistes" class="nav-link">➕ Ajout Multiple</a>
                <a href="?controleur=admin&action=afficherVueModificationArtiste" class="nav-link">✏️ Modification</a>
            </div>
        <?php endif; ?>
        <div class="user-menu">
            <p class="menu-subtitle">Compte</p>
            <a href="?controleur=utilisateur&action=afficherFormulaireModification" class="nav-link">🔧 Profil</a>
            <a href="?controleur=utilisateur&action=deconnexion" class="nav-link">🚪 Déconnexion</a>
        </div>
    <?php else: ?>
        <a href="?controleur=utilisateur&action=afficherFormulaireConnexion" class="nav-link">🔑 Connexion</a>
    <?php endif; ?>
</nav>

<!-- Contenu principal -->
<main class="main-content">

    <header class="game-header">
        <button class="menu-toggle btn-neon mobile-only" onclick="toggleMenu()">☰</button>
    </header>

    <!-- Messages Flash -->
    <div id="flash-messages"></div>

    <!-- Contenu dynamique -->
    <?php require __DIR__ . "/{$cheminCorpsVue}"; ?>
</main>

<footer class="game-footer">
    <div class="footer-content">
        <p class="neon-text">SingerTrain © 2024</p>
        <div class="footer-links">
            <a href="/mentions-legales" class="neon-link">Mentions légales</a>
            <span class="separator">|</span>
            <a href="/contact" class="neon-link">Contact</a>
        </div>
    </div>
</footer>
</body>
</html>