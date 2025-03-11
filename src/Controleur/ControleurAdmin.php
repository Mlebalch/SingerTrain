<?php

namespace App\Controleur;

use App\Lib\DeezerApi;
use App\Lib\MessageFlash;
use App\Modele\DataObject\Artiste;
use App\Modele\Repository\ArtisteRepository;

class ControleurAdmin extends ControleurGenerique
{

    public static function afficherVueFormulaireAjoutArtiste(){
        self::afficherVue("vueGenerale.php", [
            "titre" => "Ajouter un artiste",
            "cheminCorpsVue" => "admin/vueFormulaireAjoutArtiste.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
        ]);
    }

    public static function enregistrerArtiste()
    {
        $artisteid = (new DeezerApi())->add($_REQUEST['recherche']);
        if ($artisteid != 0) {
            $artiste = $_REQUEST['aritste'];
            $artisteModifie = '';
            foreach (str_split($artiste) as $char) {
                if ($char === '/') {
                    $artisteModifie .= '-';
                } else {
                    $artisteModifie .= $char;
                }
            }
            (new ArtisteRepository())->add(new Artiste($_REQUEST['aritste'], $_REQUEST['prenom'],$_REQUEST['nom'], $artisteid, "https://www.nautiljon.com/people/".$artisteModifie.".html"));
            self::afficherVue("vueGenerale.php", [
                "titre" => "Ajouter un artiste",
                "cheminCorpsVue" => "admin/vueFormulaireAjoutArtiste.php",
                "messagesFlash" => MessageFlash::lireTousMessages(),
            ]);
        } else {
            var_dump("erreur");
            self::afficherVue("vueGenerale.php", [
                "titre" => "Ajouter un artiste",
                "cheminCorpsVue" => "admin/vueFormulaireAjoutArtiste.php",
                "messagesFlash" => MessageFlash::lireTousMessages(),
            ]);
        }

    }

    public static function afficherFormulaireModification(){
        self::afficherVue("vueGenerale.php", [
            "titre" => "Modification",
            "cheminCorpsVue" => "utilisateur/vueFormulaireModification.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
        ]);
    }

    public static function modifierArtiste(){
        $artiste = (new ArtisteRepository())->getByPrimaryKeys([$_REQUEST['id']]);
        $artiste->setNomDeScene($_REQUEST['nom_de_scene']);
        $artiste->setPrenom($_REQUEST['prenom']);
        $artiste->setNom($_REQUEST['nom']);
        $artiste->setLienDeezer($_REQUEST['lien_deezer']);
        $artiste->setLienNautijon($_REQUEST['lien_nautijon']);
        (new ArtisteRepository())->update($artiste);
        self::afficherVue("vueGenerale.php", [
            "titre" => "Modification",
            "cheminCorpsVue" => "utilisateur/vueFormulaireModification.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
        ]);
    }

    public static function supprimerArtiste(){
        (new ArtisteRepository())->delete($_REQUEST['id']);
        self::afficherVue("vueGenerale.php", [
            "titre" => "Modification",
            "cheminCorpsVue" => "utilisateur/vueFormulaireModification.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
        ]);
    }

    public static function afficherVueFormulaireUtilisateurAdmin(){
        self::afficherVue("vueGenerale.php", [
            "titre" => "Utilisateur",
            "cheminCorpsVue" => "admin/vueFormulaireCreationUtilisateurAdmin.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
        ]);
    }
}