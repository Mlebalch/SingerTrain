<?php

namespace App\Controleur;

use App\Lib\animeSongsApi;
use App\Lib\DeezerApi;
use App\Lib\Mail;
use App\Lib\MotDePasse;
use App\Lib\MessageFlash;
use App\Lib\ConnexionUtilisateur;
use App\Modele\HTTP\Session;
use App\Modele\Repository\ArtisteRepository;
use App\Modele\Repository\CategorieRepository;
use App\Modele\Repository\composeRepository;
use App\Modele\Repository\LangueRepository;
use App\Modele\Repository\StatRepository;
use App\Modele\Repository\UtilisateurRepository;
use App\Modele\DataObject\Utilisateur;
use App\Modele\DataObject\Artiste;
use Random\Randomizer;
use App\Modele\DataObject\Stat;


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

    public static function afficherChoixLangue(): void
    {
        $langues = (new LangueRepository())->get();
        self::afficherVue("vueGenerale.php", [
            "titre" => "Choix du jeu",
            "cheminCorpsVue" => "utilisateur/vueChoixLangue.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
            "langues" => $langues,
        ]);
    }

public static function launch()
{
    $langue = $_REQUEST['langue'];
    $categorie = $_REQUEST['categorie'];
    $_SESSION['score'] = 0;
    $_SESSION['tentative'] = 0;
    $_SESSION['x_Region'] = (new LangueRepository())->getByPrimaryKeys([$langue])->getXRegion();
    $_SESSION['accept_Language'] = (new LangueRepository())->getByPrimaryKeys([$langue])->getAcceptLanguage();
    if ($categorie == "tous") {
        $artiste = (new composeRepository())->getByRand($langue);
    }
    else{
        $artiste = (new composeRepository())->getByRand($langue, $categorie);
    }
    Session::getInstance()->ecrire('lien', []);
    foreach ($artiste as $row) {
        $lienDeezer = (new ArtisteRepository())->getByPrimaryKeys([$row->getNomDeScene()])->getLienDeezer();
        if (!isset($_SESSION['lien']) || !is_array($_SESSION['lien'])) {
            $_SESSION['lien'] = [];
        }
        $_SESSION['lien'][] = $lienDeezer;
    }

    (new DeezerApi)->get($_SESSION['lien'], 3, $_SESSION['accept_Language'], $_SESSION['x_Region']);

    self::afficherVue("vueGenerale.php", [
        "titre" => "Game",
        "cheminCorpsVue" => "utilisateur/vueGame.php",
        "messagesFlash" => MessageFlash::lireTousMessages(),
        "artiste" => $artiste,
    ]);

}
  public static function next()
{
    if (isset($_REQUEST['stop'])) {
        self::afficherVue("vueGenerale.php", [
            "titre" => "Game",
            "cheminCorpsVue" => "utilisateur/vueScoreFinal.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
        ]);
    } else {
        if (empty($_SESSION['lien'])) {
            self::afficherVue("vueGenerale.php", [
                "titre" => "Game",
                "cheminCorpsVue" => "utilisateur/vueScoreFinal.php",
                "messagesFlash" => MessageFlash::lireTousMessages(),
            ]);
        } else {
            (new DeezerApi)->get($_SESSION['lien'], 3, $_SESSION['accept_Language'], $_SESSION['x_Region']);
            self::afficherVue("vueGenerale.php", [
                "titre" => "Game",
                "cheminCorpsVue" => "utilisateur/vueGame.php",
                "messagesFlash" => MessageFlash::lireTousMessages(),
            ]);
        }
    }
}


    public static function reponse()
    {

        $reponse = $_REQUEST['artist'];
        $artiste = $_REQUEST['correct_artist'];
        $index = $_REQUEST['index'];
        $titre = $_SESSION['dico'][$index]['titre'] ?? null;
        $img = $_SESSION['dico'][$index]['img'] ?? null;
        var_dump($reponse);
        var_dump($artiste);
        $title = preg_replace('/\([^)]*\)/', '', $titre);
        $title = preg_replace('/\s?-\s?.*/', '', $title);


        $artistname = $artiste;
        if ($artistname == "Queen Bee") {
            $artistname = "Ziyoou-vachi";
        }
        if ($artistname == "TK from Ling tosite sigure") {
            $artistname = "TK";
        }
        $anime = new animeSongsApi();
        $anime = $anime->fetchAnimeSongs($title, $artistname);


        if ($titre === null || $img === null) {
            echo "Error: Missing title or image.";
            return;
        }

        $_SESSION['dico'][$index]['tentative'] = ($_SESSION['dico'][$index]['tentative'] ?? 0) + 1;
        $_SESSION['tentative'] = ($_SESSION['tentative'] ?? 0) + 1;
        $singer = (new ArtisteRepository())->getByPrimaryKeys([$artiste]);

        $statRepository = new StatRepository();
        if (ConnexionUtilisateur::estConnecte()) {
            $stat [] = $statRepository->getByPrimaryKeys([$artiste, ConnexionUtilisateur::getUtilisateurConnecte()->getLogin(), 1]);
        }




        if (strtolower($reponse) === strtolower($artiste)) {
            var_dump("oui");
            $_SESSION['score'] = ($_SESSION['score'] ?? 0) + 1;
            if (ConnexionUtilisateur::estConnecte()) {
                if (isset($stat[0])) {
                    $stat[0]->incrementTentative();
                    $stat[0]->incrementCorrect();
                    $statRepository->addAll($stat);
                } else {
                    $statRepository->add(new Stat($artiste, ConnexionUtilisateur::getUtilisateurConnecte()->getLogin(), 1, $_SESSION['dico'][$index]['tentative'], 1));

                }
            }
                // Remove the correct answer from the session and shift the remaining elements
                array_splice($_SESSION['dico'], $index, 1);




            self::afficherVue("vueGenerale.php", [
                    "titre" => "Reponse",
                    "cheminCorpsVue" => "utilisateur/vueReponse.php",
                    "artiste" => $singer,
                    "reponse" => true,
                    "title" => $titre,
                    "image" => $img,
                "anime" => $anime,
                ]);
        }
        else {
                var_dump("non");
                if (ConnexionUtilisateur::estConnecte()) {
                    if (isset($stat[0])) {
                        $stat[0]->incrementTentative();
                        $statRepository->addAll($stat);
                    } else {
                        $statRepository->add(new Stat($artiste, ConnexionUtilisateur::getUtilisateurConnecte()->getLogin(), 1, $_SESSION['dico'][$index]['tentative'], 0));
                    }
                }
                self::afficherVue("vueGenerale.php", [
                    "titre" => "Reponse",
                    "cheminCorpsVue" => "utilisateur/vueReponse.php",
                    "artiste" => $singer,
                    "reponse" => false,
                    "title" => $titre,
                    "image" => $img,
                    "anime" => $anime,
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

    public static function afficherVueStat()
    {
        $stat = (new StatRepository())->getbylogin(ConnexionUtilisateur::getUtilisateurConnecte()->getLogin());
        self::afficherVue("vueGenerale.php", [
            "titre" => "Stat",
            "cheminCorpsVue" => "utilisateur/vueStat.php",
            "messagesFlash" => MessageFlash::lireTousMessages(),
            "stat" => $stat,
        ]);

    }


}