<?php
/** @var array $langues */

use App\Modele\Repository\CategorieRepository;

if (!isset($_REQUEST['langue'])){
    foreach ($langues as $langue) {
        echo "<a href='?controleur=utilisateur&action=afficherChoixLangue&langue=" . $langue->getLangue() . "'>" . $langue->getLangue() . "</a><br>";
    }
}else{
    echo "Vous avez choisi la langue " . $_REQUEST['langue'] . "<br>";
    $categorie = (new CategorieRepository())->getByLangue($_REQUEST['langue']);
  foreach ($categorie as $cat){
    echo "<a href='?controleur=utilisateur&action=launch&langue=" . $_REQUEST['langue'] . "&categorie=".$cat->getType()."'>" . $cat->getType() . "</a><br>";
    }
  echo "<a href='?controleur=utilisateur&action=launch&langue=" . $_REQUEST['langue'] ."&categorie=tous"."'>Toutes les catégories</a><br>";
  echo "<a href='?controleur=utilisateur&action=afficherChoixLangue'>Retour</a>";
}
?>