<?php

namespace App\Controleur;

use App\Lib\DeezerApi;
use App\Lib\MessageFlash;
use App\Modele\DataObject\Artiste;
use App\Modele\Repository\AppartientRepository;
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
        if ($artisteid ["id"] != null) {
            $artiste = $_REQUEST['aritste'];
            $artisteModifie = '';
            foreach (str_split($artiste) as $char) {
                if ($char === '/') {
                    $artisteModifie .= '-';
                } else {
                    $artisteModifie .= $char;
                }
            }
            (new ArtisteRepository())->add(new Artiste($_REQUEST['aritste'], $_REQUEST['prenom'],$_REQUEST['nom'], $artisteid["id"], "https://www.nautiljon.com/people/".$artisteModifie.".html", $artisteid["image"]));
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
        $artiste = (new ArtisteRepository())->getByPrimaryKeys([$_REQUEST['artiste']]);
        if ($_REQUEST['lien_deezer'] != null) {
            $artiste->setLienDeezer($_REQUEST['lien_deezer']);
        }
        if ($_REQUEST['lien_nautijon'] != null) {
            $artiste->setLienNautijon($_REQUEST['lien_nautijon']);
        }
        if ($_REQUEST['prenom'] != null) {
            $artiste->setPrenom($_REQUEST['prenom']);
        }
        if ($_REQUEST['nom'] != null) {
            $artiste->setNom($_REQUEST['nom']);

        }
        if($_REQUEST['role'] != null){
            $artiste2 = (new ArtisteRepository())->getByPrimaryKeys([$_REQUEST['groupArtist']]);
            (new AppartientRepository())->addRole($artiste->getNomDeScene(),$artiste2->getNomDeScene(), $_REQUEST['role']);
        }
        (new ArtisteRepository())->update($artiste);
        $artistes = (new ArtisteRepository())->get();
        self::afficherVue("vueGenerale.php", [
            "titre" => "Modification",
            "cheminCorpsVue" => "admin/vueModificationArtiste.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
            "artistes" => $artistes
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


    public static function afficherVueModificationArtiste()
    {
        $artistes = (new ArtisteRepository())->get();
        self::afficherVue("vueGenerale.php", [
            "titre" => "Modification",
            "cheminCorpsVue" => "admin/vueModificationArtiste.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
            "artistes" => $artistes
        ]);

    }
}