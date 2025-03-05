<section class="boiteH loginBox">
    <div class="boiteV grandeMarge">
       <h1> <span>Bienvenue sur </span> SingerTrain</h1>

            <div class="boite">
                <h4>Se connecter</h4>
                <form method="post">
                    <table>
                        <tr>
                            <td><label for="login_id">Login :</label></td>
                            <td><input type="text" name="login" id="login_id" required/></td>
                        </tr>
                        <tr>
                            <td><label for="mdp_id">Mot de passe</label></td>
                            <td><input type="password" value="" name="mdp" id="mdp_id" required></td>
                        </tr>
                    </table>
                    <a href="?controleur=utilisateur&action=afficherFormulaireCreationUtilisateur"> Crée un Compte</a>
                    <input type="submit" value="Envoyer" />
                    <input type='hidden' name='action' value='connexion'>
                    <input type='hidden' name='controleur' value='utilisateur'>
                </form>
            </div>
        </div>
</section>