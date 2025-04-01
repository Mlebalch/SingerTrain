<?php
/** @var Utilisateur $utilisateur */
use App\Modele\DataObject\Utilisateur;

    echo "
        <table>
            <thead>
                <tr>
                    <th>Mettre à jour l'utilisateur</th>
                </tr>
        </thead>
        </table>
    ";
    echo "<form method=\"post\" action=\"\">";
    echo "<table>";
    echo "<tr>";
    echo "<td><label for=\"login_id\">Login</label> :</td>";
    echo "<td><input readonly value=\"" . htmlspecialchars($utilisateur->getLogin()) . "\" type=\"text\" placeholder=\"leblancj\" name=\"login\" id=\"login_id\" required/></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><label for=\"mdp_id3\">Mot de passe&#42;</label></td>";
    echo "<td><input type=\"password\" value=\"\" placeholder=\"\" name=\"mdpHache\" id=\"mdp_id3\" required></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><label for=\"mdp_id\">Nouveau mot de passe&#42;</label></td>";
    echo "<td><input type=\"password\" value=\"\" placeholder=\"\" name=\"mdp\" id=\"mdp_id\" required></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><label for=\"mdp2_id\">Vérification du mot de passe&#42;</label></td>";
    echo "<td><input type=\"password\" value=\"\" placeholder=\"\" name=\"mdp2\" id=\"mdp2_id\" required></td>";
    echo "</tr>";
    echo "</table>";
    echo "<td colspan='2'><input type=\"submit\" value=\"Envoyer\" /></td>";
    echo "<input type='hidden' name='action' value='modifierUtilisateurDepuisFormulaire'>";
    echo "<input type='hidden' name='controleur' value='utilisateur'>";
    echo "</form>";


?>