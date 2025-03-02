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
        Nom :
        <input type="text" name="nom" required/>
    </label>
    <label>
        Prenom :
        <input type="text" name="prenom" required/>
    </label>
    <label>
        Mot de passe&#42; :
        <input type="password" name="mdp" required/>
    </label>
    <label>
        Mot de passe&#42; :
        <input type="password" name="mdp2" required/>
    </label>
    <label>
        Rôle :
        <select name="status" required>
            <option value="admin">Administrateur</option>
            <option value="client">Professeur</option>
            <option value="vendeur">Université</option>
        </select>
    </label>

    <input type="submit" value="Envoyer" />
    <input type='hidden' name='action' value='creerUtilisateurDepuisFormulaire'>
    <input type='hidden' name='controleur' value='utilisateur'>
</form>