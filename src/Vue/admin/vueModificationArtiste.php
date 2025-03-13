<?php
use App\Modele\DataObject\Artiste;
/* @var array $artistes */
?>
<form method="post" action="">
    <h3>Modifier un Artiste</h3>
    <div>
        <select name="artiste" id="artistSelect" required>
            <option value=""  selected disabled>Selectionner un Artiste</option>
            <?php
            foreach ($artistes as $user) {
                /** @var Artiste $user */
                echo "<option value=\"{$user->getNomDeScene()}\" data-prenom=\"{$user->getPrenom()}\" data-nom=\"{$user->getNom()}\" data-lien-deezer=\"{$user->getLienDeezer()}\" data-lien-nautijon=\"{$user->getLienNautijon()}\">{$user->getNomDeScene()}</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label for="prenom">Prenom:</label>
        <input type="text" id="prenom" name="prenom" >
    </div>
    <div>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" >
    </div>
    <div>
        <label for="lien_deezer">Lien Deezer:</label>
        <input type="text" id="lien_deezer" name="lien_deezer" >
    </div>
    <div>
        <label for="lien_nautijon">Lien Nautijon:</label>
        <input type="text" id="lien_nautijon" name="lien_nautijon" >
    </div>
    <div>
        <button type="button" id="addGroupButton">Appartient à un groupe</button>
    </div>
    <div id="groupForm" style="display: none;">
        <div>
            <label for="groupArtist">Selectionner un Artiste:</label>
            <select id="groupArtist" name="groupArtist">
                <option value="" selected disabled>Selectionner un Artiste</option>
                <?php
                foreach ($artistes as $user) {
                    /** @var Artiste $user */
                    echo "<option value=\"{$user->getNomDeScene()}\">{$user->getNomDeScene()}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="role">Role:</label>
            <input type="text" id="role" name="role" required>
        </div>
    </div>
    <input type="submit" value="Envoyer" />
    <input type='hidden' name='action' value='modifierArtiste'>
    <input type="hidden" name="controleur" value="admin">
</form>

<script>
document.getElementById('artistSelect').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    document.getElementById('prenom').value = selectedOption.getAttribute('data-prenom');
    document.getElementById('nom').value = selectedOption.getAttribute('data-nom');
    document.getElementById('lien_deezer').value = selectedOption.getAttribute('data-lien-deezer');
    document.getElementById('lien_nautijon').value = selectedOption.getAttribute('data-lien-nautijon');
});

document.getElementById('addGroupButton').addEventListener('click', function() {
    document.getElementById('groupForm').style.display = 'block';
});
</script>