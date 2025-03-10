<?php

namespace App\Controleur;

use App\Lib\DeezerApi;
use App\Lib\Mail;
use App\Lib\MotDePasse;
use App\Lib\MessageFlash;
use App\Lib\ConnexionUtilisateur;
use App\Modele\HTTP\Session;
use App\Modele\Repository\ArtisteRepository;
use App\Modele\Repository\UtilisateurRepository;
use App\Modele\DataObject\Utilisateur;
use App\Modele\DataObject\Artiste;
use Random\Randomizer;

Session::getInstance();
class ControleurUtilisateur extends ControleurGenerique
{
    public static function afficherAccueil(): void
    {
        self::afficherVue("vueGenerale.php", [
            "titre" => "Accueil",
            "cheminCorpsVue" => "utilisateur/vueAccueil.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
        ]);
    }
    public static function launch()
    {

        $_SESSION['score'] = 0;
        $_SESSION['tentative'] = 0;
       $lienDeezer =  (new ArtisteRepository())->getRand();
       $resulte = [];
       foreach ($lienDeezer as $row) {
            $resulte[] = $row->getLienDeezer();
       }
      (new DeezerApi)->get($resulte);

       self::afficherVue("vueGenerale.php", [
            "titre" => "Game",
            "cheminCorpsVue" => "utilisateur/vueGame.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),

        ]);
    }

    public static function next(){

        if ($_SESSION['songs'] == null){
            self::afficherVue("vueGenerale.php", [
                "titre" => "Game",
                "cheminCorpsVue" => "utilisateur/vueScoreFinal.php",
                "messagesFlash" => MessageFlash::lireTousMessages(),
            ]);
        }
        else{
            self::afficherVue("vueGenerale.php", [
                "titre" => "Game",
                "cheminCorpsVue" => "utilisateur/vueGame.php",
                "messagesFlash" => MessageFlash::lireTousMessages(),
            ]);

        }
    }


    public static function reponse()
    {

        $reponse = $_REQUEST['artist'];
        $artiste = $_REQUEST['correct_artist'];
        $index = $_REQUEST['index'];
        var_dump($reponse);
        var_dump($artiste);
        $_SESSION['tentative'] = $_SESSION['tentative'] + 1;
        $singer = (new ArtisteRepository())->getByPrimaryKeys([$artiste]);
        if(strtolower($reponse) === strtolower($artiste))
        {

            var_dump("oui");
            $_SESSION['score'] = $_SESSION['score'] + 1;

            // Remove the song and artist from the session
            array_splice($_SESSION['songs'], $index, 1);
            array_splice($_SESSION['artistes'], $index, 1);

            self::afficherVue("vueGenerale.php", [
                "titre" => "Reponse",
                "cheminCorpsVue" => "utilisateur/vueReponse.php",
                "artiste" => $singer,
                "reponse" => true,
            ]);
        }
        else
        {
            var_dump("non");
            self::afficherVue("vueGenerale.php", [
                "titre" => "Reponse",
                "cheminCorpsVue" => "utilisateur/vueReponse.php",
                "artiste" => $singer,
                "reponse" => false,
            ]);
        }

    }


    public static function afficherFormulaireModification()
    {
        self::afficherVue("vueGenerale.php", [
            "titre" => "Modification",
            "cheminCorpsVue" => "utilisateur/vueFormulaireModification.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
            "utilisateur" => ConnexionUtilisateur::getUtilisateurConnecte(),

        ]);

    }

    public static function afficherFormulaireConnexion(): void
    {
        self::afficherVue("vueGenerale.php", [
            "titre" => "Connexion",
            "cheminCorpsVue" => "utilisateur/vueFormulaireConnexion.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
        ]);
    }
    public static function afficherFormulaireCreationUtilisateur()
    {
        self::afficherVue("vueGenerale.php", [
            "titre" => "Création d'un utilisateur",
            "cheminCorpsVue" => "utilisateur/vueFormulaireCreationUtilisateur.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
        ]);

    }

    public static function connexion(): void
    {
        if (!isset($_REQUEST['login']) || !$_REQUEST['mdp']) {
            MessageFlash::ajouter("danger", "Veuillez remplir tous les champs");
        } else {
            $login = $_REQUEST['login'];
            $mdp = $_REQUEST['mdp'];
            /** @var Utilisateur $utilisateur **/
            $utilisateur = (new UtilisateurRepository())->getByPrimaryKeys([$login]);
            if ($utilisateur != null && MotDePasse::verifier($mdp, $utilisateur->getMdp())) {
                ConnexionUtilisateur::connecter($utilisateur);
                MessageFlash::ajouter("success", "Connexion réussie");
            } else {
                MessageFlash::ajouter("danger", "Login ou mot de passe incorrect");
            }
        }
        header("Location: ?controleur=utilisateur&action=afficherAccueil");
        exit();
    }

    public static function deconnexion(): void
    {
        ConnexionUtilisateur::deconnecter();
        MessageFlash::ajouter("success", "Déconnexion réussie");
        header("Location: ?controleur=utilisateur&action=afficherAccueil");
        exit();
    }

    public static function creerUtilisateurDepuisFormulaire(): void
    {

        if (!isset($_REQUEST['login']) || !isset($_REQUEST['mdp']) || !isset($_REQUEST['mdp2']) || !isset($_REQUEST['mail'])) {
            MessageFlash::ajouter("danger", "Veuillez remplir tous les champs");
            header("Location: ?controleur=utilisateur&action=afficherFormulaireCreationUtilisateur");
            exit();
        }

        $mdp = $_REQUEST['mdp'];
        $mdp2 = $_REQUEST['mdp2'];

        if ($mdp != $mdp2) {
            MessageFlash::ajouter("danger", "Les mots de passe ne correspondent pas");
            header("Location:  ?controleur=utilisateur&action=afficherFormulaireCreationUtilisateur");
            exit();
        }
        $newutilisateur = ControleurUtilisateur::construireDepuisFormulaire($_REQUEST);

        if (filter_var($newutilisateur->getEmail(), FILTER_VALIDATE_EMAIL) === false) {
            MessageFlash::ajouter("danger", "Adresse mail invalide");
        }
        else if ((new UtilisateurRepository)->add($newutilisateur)) {
            MessageFlash::ajouter("success", "Utilisateur créé avec succès");

            Mail::envoyerMail($newutilisateur, "Compte SingerTrain",
                "Bonjour {$newutilisateur->getLogin()}\n\n
                Merci D'avoir creer votre compte chez nous.\n
            
                ");

        } else {
            MessageFlash::ajouter("danger", "Impossible de créer l'utilisateur");
        }
        header("Location:  ?controleur=utilisateur&action=afficherFormulaireConnexion");
        exit();
    }

    public static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Utilisateur
    {

        if ($tableauDonneesFormulaire['mail'] == null) {
            $tableauDonneesFormulaire['mail'] = "inconnu";
        }

        return new Utilisateur(
            $tableauDonneesFormulaire['login'],
            MotDePasse::hacher($tableauDonneesFormulaire['mdp']),
            $tableauDonneesFormulaire['mail'],
            $tableauDonneesFormulaire['admin'],
        );
    }

    public static function modifierUtilisateurDepuisFormulaire()
    {
        if (!isset($_GET['mdp']) || !isset($_GET['mdp2']) || !isset($_GET['mdpHache'])) {
            MessageFlash::ajouter("danger", "Veuillez remplir tous les champs");
            header("Location: ?controleur=utilisateur&action=afficherFormulaireModification");
            exit();
        }

        $mdp = $_GET['mdp'];
        $mdp2 = $_GET['mdp2'];
        $mdpHache = $_GET['mdpHache'];

        if ($mdp != $mdp2) {
            MessageFlash::ajouter("danger", "Les mots de passe ne correspondent pas");
            header("Location:  ?controleur=utilisateur&action=afficherFormulaireModification");
            exit();
        }

        $utilisateur = ConnexionUtilisateur::getUtilisateurConnecte();
        if (MotDePasse::verifier($mdpHache, $utilisateur->getMdp())) {
            $utilisateur->setMdp(MotDePasse::hacher($mdp));
            if ((new UtilisateurRepository())->update($utilisateur)) {
                MessageFlash::ajouter("success", "Mot de passe modifié avec succès");
            } else {
                MessageFlash::ajouter("danger", "Impossible de modifier le mot de passe");
            }
        } else {
            MessageFlash::ajouter("danger", "Mot de passe incorrect");
        }
        header("Location:  ?controleur=utilisateur&action=afficherFormulaireModification");
        exit();
    }
}