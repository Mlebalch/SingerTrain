<?php
use App\Lib\MessageFlash;
use App\Modele\HTTP\Session;

$session = Session::getInstance();
$volume = isset($_COOKIE["volume"]) ? $_COOKIE["volume"] : 0.15;
?>

<div class="game-container">
    <h1 class="game-title neon-text">Devine l'artiste </h1>

    <div class="score-display">
        Score : <?= htmlspecialchars($_SESSION['score'], 0) ?>
    </div>

    <div class="audio-container">
        <?php
        $index = rand(0, count($_SESSION['dico']) - 1);
        $song = $_SESSION['dico'][$index]['song'] ?? null;
        $artiste = $_SESSION['dico'][$index]['artiste'] ?? null;
        ?>
        <audio id="audio" autoplay loop>
            <source src="<?= htmlspecialchars($song) ?>" type="audio/mpeg">
        </audio>
        <div class="audio-visualizer"></div>
    </div>

    <form method="post" action="" class="guess-form">
        <div class="input-group">
            <input type="text"
                   id="artist"
                   name="artist"
                   class="artist-input"
                   placeholder="Entrez le nom de l'artiste..."
                   autocomplete="off">

            <input type="hidden"
                   name="correct_artist"
                   value="<?= htmlspecialchars($artiste, ENT_QUOTES) ?>">
            <input type="hidden"
                   name="index"
                   value="<?= $index ?>">
        </div>

        <button type="submit"
                class="game-submit"
                name="action"
                value="reponse">
            Vérifier la réponse
        </button>
    </form>

    <div class="volume-control">
        <label for="volumeSlider" class="neon-label">Volume :</label>
        <input type="range"
               id="volumeSlider"
               min="0"
               max="0.3"
               step="0.001"
               value="<?= $volume ?>"
               class="volume-slider">
    </div>
</div>

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
</script>
<style>
    .game-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 3rem;
        background: rgba(26, 26, 46, 0.8);
        border-radius: 15px;
        border: 2px solid var(--accent-color);
        box-shadow: 0 0 30px rgba(78, 204, 198, 0.2);
        position: relative;
        animation: containerPulse 4s infinite;
    }

    /* Animation du conteneur */
    @keyframes containerPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.005); }
    }

    /* Affichage du score */
    .score-display {
        position: fixed;
        top: 20px;
        right: 30px;
        font-size: 2rem;
        color: var(--accent-color);
        text-shadow: 0 0 15px rgba(78, 204, 198, 0.7);
        animation: scoreGlow 2s infinite;
    }

    /* Formulaire de devinette */
    .guess-form {
        margin: 3rem 0;
        position: relative;
    }

    .artist-input {
        width: 100%;
        padding: 1.2rem;
        font-size: 1.2rem;
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid var(--primary-color);
        color: var(--text-primary);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .artist-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 20px rgba(78, 204, 198, 0.3);
    }

    /* Contrôle du volume */
    .volume-control {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    #volumeSlider {
        width: 120px;
        height: 6px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
        -webkit-appearance: none;
    }

    #volumeSlider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        background: var(--accent-color);
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 0 10px rgba(78, 204, 198, 0.5);
    }

    /* Bouton de soumission */
    .game-submit {
        display: block;
        width: 100%;
        padding: 1.2rem;
        margin-top: 1.5rem;
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        border: 2px solid var(--accent-color);
        color: var(--text-primary);
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .game-submit:hover {
        background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
        box-shadow: 0 0 25px rgba(78, 204, 198, 0.4);
    }

    /* Animation de l'extrait audio */
    .audio-visualizer {
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 4px;
        background: rgba(78, 204, 198, 0.3);
        border-radius: 2px;
        animation: audioWave 1.5s infinite;
    }

    @keyframes audioWave {
        0%, 100% { height: 4px; }
        50% { height: 8px; }
    }

    /* Mode mobile */
    @media (max-width: 768px) {
        .game-container {
            margin: 1rem;
            padding: 2rem;
        }

        .score-display {
            font-size: 1.5rem;
            right: 15px;
        }
    }
</style>


