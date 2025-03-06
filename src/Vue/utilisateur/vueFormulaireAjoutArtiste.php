<h3>Ajouter un artiste</h3>
<form method="post" action="" class="">
    <label>
Recherche :
        <input type="text" name="recherche" required/>
    </label>
    <label>
Nom de Scène :
        <input type="text" name="aritste" required/>
    </label>
    <label>
Nom :
        <input type="text" name="nom" />
    </label>
    <label>
        Prénom :
        <input type="text" name="prenom" />
    </label>

    <input type="submit" value="Envoyer" />
    <input type='hidden' name='action' value='enregistrerArtiste'>
    <input type='hidden' name='controleur' value='utilisateur'>
</form>


