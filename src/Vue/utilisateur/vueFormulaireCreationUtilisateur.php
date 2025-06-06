<?php
// vueFormulaireCreationUtilisateur.php
?>

<div class="auth-container">
    <div class="neon-box">
        <h1 class="game-title">Création de compte</h1>

        <form method="post" class="auth-form">
            <div class="input-group">
                <label for="login_id" class="neon-label">Identifiant</label>
                <input type="text"
                       name="login"
                       id="login_id"
                       class="neon-input"
                       required>
            </div>

            <div class="input-group">
                <label for="mail_id" class="neon-label">Adresse email</label>
                <input type="email"
                       name="mail"
                       id="mail_id"
                       class="neon-input"
                       required>
            </div>

            <div class="password-grid">
                <div class="input-group">
                    <label for="mdp_id" class="neon-label">Mot de passe</label>
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
                <span class="glow-text">Créer le compte</span>
            </button>

            <input type="hidden" name="admin" value="user">
            <input type="hidden" name="action" value="creerUtilisateurDepuisFormulaire">
            <input type="hidden" name="controleur" value="utilisateur">
        </form>
    </div>
</div>