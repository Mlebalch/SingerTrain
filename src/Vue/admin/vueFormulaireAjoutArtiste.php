<?php
// vueFormulaireAjoutArtiste.php
/** @var array $langues */
?>

<div class="admin-container">
    <div class="neon-box">
        <h1 class="game-title">Ajout d'un artiste</h1>

        <form method="post" class="auth-form" enctype="multipart/form-data">
            <div class="input-grid">
                <div class="input-group">
                    <label class="neon-label">Nom de scène</label>
                    <input type="text"
                           name="aritste"
                           class="neon-input"
                           placeholder="Nom d'artiste..."
                           required>
                </div>

                <div class="input-group">
                    <label class="neon-label">Langue principale</label>
                    <select name="langue" class="neon-input" required>
                        <?php foreach ($langues as $langue): ?>
                            <option value="<?= htmlspecialchars($langue->getLangue()) ?>">
                                <?= htmlspecialchars($langue->getLangue()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="input-grid">
                <div class="input-group">
                    <label class="neon-label">Nom réel</label>
                    <input type="text"
                           name="nom"
                           class="neon-input"
                           placeholder="Nom de famille...">
                </div>

                <div class="input-group">
                    <label class="neon-label">Prénom</label>
                    <input type="text"
                           name="prenom"
                           class="neon-input"
                           placeholder="Prénom...">
                </div>
            </div>

            <div class="input-group">
                <label class="neon-label">Image de l'artiste</label>
                <input type="file"
                       name="image"
                       class="neon-input"
                       accept="image/*">
            </div>

            <button type="submit" class="btn-neon pulse">
                <span class="glow-text">Enregistrer l'artiste</span>
            </button>

            <input type="hidden" name="action" value="enregistrerArtiste">
            <input type="hidden" name="controleur" value="admin">
        </form>
    </div>
</div>