<?php
// vueFormulaireModification.php
/** @var Utilisateur $utilisateur */
use App\Modele\DataObject\Utilisateur;
?>

<div class="auth-container">
    <div class="neon-box">
        <h1 class="game-title">Modification du profil</h1>

        <form method="post" class="auth-form">
            <div class="input-group">
                <label for="login_id" class="neon-label">Identifiant</label>
                <input type="text"
                       id="login_id"
                       value="<?= htmlspecialchars($utilisateur->getLogin()) ?>"
                       class="neon-input disabled"
                       readonly
                       disabled>
            </div>

            <div class="password-grid">
                <div class="input-group">
                    <label for="mdp_id3" class="neon-label">Mot de passe actuel</label>
                    <input type="password"
                           name="mdpHache"
                           id="mdp_id3"
                           class="neon-input"
                           required>
                </div>

                <div class="input-group">
                    <label for="mdp_id" class="neon-label">Nouveau mot de passe</label>
                    <input type="password"
                           name="mdp"
                           id="mdp_id"
                           class="neon-input"
                           required>
                </div>

                <div class="input-group">
                    <label for="mdp2_id" class="neon-label">Confirmation</label>
                    <input type="password"
                           name="mdp2"
                           id="mdp2_id"
                           class="neon-input"
                           required>
                </div>
            </div>

            <button type="submit" class="btn-neon">
                <span class="glow-text">Mettre à jour</span>
            </button>

            <input type="hidden" name="action" value="modifierUtilisateurDepuisFormulaire">
            <input type="hidden" name="controleur" value="utilisateur">
        </form>
    </div>
</div>