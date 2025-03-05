<h3>Créer un utilisateur</h3>
<form method="get" action="" class="">
    <label>
        Login :
        <input type="text" name="login" required/>
    </label>
    <label>
        Mail :
        <input type="email" name="mail" required/>
    </label>
    <label>
        Mot de passe&#42; :
        <input type="password" name="mdp" required/>
    </label>
    <label>
        Mot de passe&#42; :
        <input type="password" name="mdp2" required/>
    </label>

    <input type="submit" value="Envoyer" />
    <input type='hidden' name='action' value='creerUtilisateurDepuisFormulaire'>
    <input type='hidden' name='controleur' value='utilisateur'>
</form>