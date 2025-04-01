<?php
/** @var array $langues */
echo "
        <table>
            <thead>
                <tr>
                    <th>Ajout d'artistes</th>
                </tr>
        </thead>
        </table>
    ";
echo "<form method=\"post\" action=\"\">";
echo "<table>";
echo "<tr>";
echo "<td><label >Recherche</label> :</td>";
echo "<td><input type=\"text\" name=\"recherche\" required/></td>";
echo "</tr>";
echo "<tr>";
echo "<td><label for=\"langues\">Langues</label> :</td>";
echo "<td><input type=\"text\" name=\"langue\" list=\"langues\" required/></td>";
echo "<td>
        <datalist id=\"langues\">";

// Assuming $langues is an array containing all possible languages
foreach ($langues as $langue) {
    echo "<option value=\"{$langue->getLangue()}\">";
}

echo "  </datalist>
      </td>";
echo "</tr>";
echo "</table>";
echo "<td colspan='2'><input type=\"submit\" value=\"Envoyer\" /></td>";
echo "<input type='hidden' name='action' value='ajoutArtistes'>";
echo "<input type='hidden' name='controleur' value='admin'>";
echo "</form>";
?>