<?php
// vueAccueil.php
?>

<div class="main-content home-container">
    <div class="neon-box hero-section">
        <h1 class="game-title flicker">SingerTrain</h1>
        <p class="subtitle neon-text"></p>

        <a href="?controleur=utilisateur&action=afficherChoixLangue" class="btn-neon pulse-start">
            <span class="glow-text">🎤 Commencer l'entraînement</span>
        </a>
    </div>

</div>

<style>
    /* Nouveaux styles */
    .home-container {
        text-align: center;
        padding: 2rem;
    }

    .hero-section {
        max-width: 800px;
        margin: 2rem auto;
        padding: 3rem;
    }

    .subtitle {
        font-size: 1.5rem;
        margin: 1.5rem 0;
    }

    .pulse-start {
        animation: bigPulse 2s infinite;
        display: inline-block;
        margin: 2rem auto;
        padding: 1.5rem 3rem;
        font-size: 1.5rem;
    }

    @keyframes bigPulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(78, 204, 198, 0.5); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); box-shadow: 0 0 0 25px rgba(78, 204, 198, 0); }
    }

    .info-cards {
        margin-top: 3rem;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .info-cards h3 {
        color: var(--accent-color);
        margin-bottom: 1rem;
    }
</style>