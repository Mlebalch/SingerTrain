<?php

echo "<h2>Score: {$_SESSION['score']}</h2>";
echo "<h2>Tentative: {$_SESSION['tentative']}</h2>";

echo "<a href='?controleur=utilisateur&action=launch'>Rejouer ?</a>";