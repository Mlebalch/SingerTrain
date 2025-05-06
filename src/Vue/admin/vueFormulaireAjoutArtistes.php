<?php
// vueFormulaireAjoutArtistes.php
/** @var array $langues */
?>

<div class="admin-container">
    <div class="neon-box">
        <h1 class="game-title">Ajout multiple d'artistes</h1>

        <form method="post" class="auth-form" enctype="multipart/form-data">
            <div class="input-group">
                <label class="neon-label">Recherche d'artistes</label>
                <div class="search-container">
                    <input type="text"
                           name="recherche"
                           class="neon-input"
                           placeholder="Nom d'artiste, groupe..."
                           required>
                    <span class="search-icon">🔍</span>
                </div>
            </div>

            <div class="input-group">
                <label class="neon-label">Langues associées</label>
                <div class="tags-container">
                    <input type="text"
                           name="langue"
                           list="langues"
                           class="neon-input"
                           placeholder="Sélectionnez une langue..."
                           required>
                    <datalist id="langues">
                        <?php foreach ($langues as $langue): ?>
                        <option value="<?= htmlspecialchars($langue->getLangue()) ?>">
                            <?php endforeach; ?>
                    </datalist>
                </div>
            </div>

            <button type="submit" class="btn-neon pulse">
                <span class="glow-text">Lancer la recherche</span>
            </button>

            <input type="hidden" name="action" value="ajoutArtistes">
            <input type="hidden" name="controleur" value="admin">
        </form>
    </div>
</div>