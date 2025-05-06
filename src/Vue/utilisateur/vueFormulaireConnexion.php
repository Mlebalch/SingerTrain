<section class="auth-container">
    <div class="neon-box">
        <h1 class="game-title">Connexion</h1>
        <form method="post" class="auth-form">
            <div class="input-group">
                <label class="neon-label" for="login_id">Identifiant</label>
                <input type="text" name="login" id="login_id" class="neon-input">
            </div>

            <div class="input-group">
                <label class="neon-label" for="mdp_id">Mot de passe</label>
                <input type="password" name="mdp" id="mdp_id" class="neon-input">
            </div>

            <button type="submit" class="btn-neon">Se connecter</button>
            <input type="hidden" name='action' value='connexion'>
            <input type='hidden' name='controleur' value='utilisateur'>
        </form>

        <div class="auth-links">
            <a href="?controleur=utilisateur&action=afficherFormulaireCreationUtilisateur" class="neon-link">
                Créer un compte
            </a>
        </div>
    </div>
</section>