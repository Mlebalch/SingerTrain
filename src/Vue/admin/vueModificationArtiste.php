<?php
use App\Modele\DataObject\Artiste;
/** @var array $artistes */
?>

<div class="admin-container">
    <div class="neon-box">
        <h1 class="game-title">Modification d'artiste</h1>

        <form method="post" action="" class="artist-form">
            <div class="input-group">
                <label class="neon-label">Rechercher l'artiste</label>
                <div class="search-container">
                    <input list="artistList"
                           name="artiste"
                           id="artistSelect"
                           class="neon-input"
                           placeholder="Commencez à taper..."
                           required>
                    <datalist id="artistList">
                        <?php foreach ($artistes as $user): ?>
                        <option value="<?= htmlspecialchars($user->getNomDeScene()) ?>"
                                data-prenom="<?= htmlspecialchars($user->getPrenom()) ?>"
                                data-nom="<?= htmlspecialchars($user->getNom()) ?>"
                                data-lien-deezer="<?= htmlspecialchars($user->getLienDeezer()) ?>"
                                data-lien-nautijon="<?= htmlspecialchars($user->getLienNautijon()) ?>">
                            <?php endforeach; ?>
                    </datalist>
                </div>
            </div>

            <div class="form-grid">
                <div class="input-group">
                    <label for="prenom" class="neon-label">Prénom</label>
                    <input type="text"
                           id="prenom"
                           name="prenom"
                           class="neon-input">
                </div>

                <div class="input-group">
                    <label for="nom" class="neon-label">Nom</label>
                    <input type="text"
                           id="nom"
                           name="nom"
                           class="neon-input">
                </div>

                <div class="input-group">
                    <label for="lien_deezer" class="neon-label">Lien Deezer</label>
                    <input type="text"
                           id="lien_deezer"
                           name="lien_deezer"
                           class="neon-input">
                </div>

                <div class="input-group">
                    <label for="lien_nautijon" class="neon-label">Lien Nautijon</label>
                    <input type="text"
                           id="lien_nautijon"
                           name="lien_nautijon"
                           class="neon-input">
                </div>
            </div>

            <button type="button" id="addGroupButton" class="btn-neon">
                <span class="glow-text">➕ Ajouter au groupe</span>
            </button>

            <div id="groupForm" class="hidden-section">
                <div class="input-group">
                    <label for="groupArtist" class="neon-label">Artiste du groupe</label>
                    <select id="groupArtist"
                            name="groupArtist"
                            class="neon-input">
                        <option value="" selected disabled>Choisir un artiste...</option>
                        <?php foreach ($artistes as $user): ?>
                            <option value="<?= htmlspecialchars($user->getNomDeScene()) ?>">
                                <?= htmlspecialchars($user->getNomDeScene()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="input-group">
                    <label for="role" class="neon-label">Rôle</label>
                    <input type="text"
                           id="role"
                           name="role"
                           class="neon-input"
                           required>
                </div>
            </div>

            <button type="submit" class="btn-neon pulse">
                <span class="glow-text">💾 Enregistrer modifications</span>
            </button>

            <input type="hidden" name="action" value="modifierArtiste">
            <input type="hidden" name="controleur" value="admin">
        </form>
    </div>
</div>

<style>
    /* Ajouts CSS */
    .artist-form {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin: 1rem 0;
    }

    .hidden-section {
        display: none;
        padding: 1.5rem;
        background: rgba(42, 35, 86, 0.3);
        border: 1px solid var(--accent-color);
        border-radius: 8px;
        margin: 1rem 0;
        animation: sectionAppear 0.5s ease-out;
    }

    .search-container {
        position: relative;
    }

    .neon-input::placeholder {
        color: rgba(230, 241, 247, 0.5);
    }

    @keyframes sectionAppear {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    select.neon-input {
        appearance: none;
        background: url("data:image/svg+xml;utf8,<svg fill='%234eccc6' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>")
        no-repeat right 0.8rem center/1.2rem;
    }

    .glow-text {
        position: relative;
        z-index: 1;
    }
</style>

<script>
    // Animation améliorée
    document.getElementById('addGroupButton').addEventListener('click', function() {
        const groupForm = document.getElementById('groupForm');
        groupForm.style.display = 'block';
        groupForm.scrollIntoView({ behavior: 'smooth' });
    });

    // Auto-remplissage stylisé
    document.getElementById('artistSelect').addEventListener('input', function() {
        const selectedOption = document.querySelector(`#artistList option[value="${this.value}"]`);
        if(selectedOption) {
            ['prenom', 'nom', 'lien_deezer', 'lien_nautijon'].forEach(id => {
                const field = document.getElementById(id);
                if(field) {
                    field.value = selectedOption.getAttribute(`data-${id.replace('_', '-')}`);
                    field.parentElement.classList.add('field-highlight');
                    setTimeout(() => field.parentElement.classList.remove('field-highlight'), 1000);
                }
            });
        }
    });
</script>