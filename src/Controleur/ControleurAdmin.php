<?php

namespace App\Controleur;

use App\Lib\DeezerApi;
use App\Lib\MessageFlash;
use App\Lib\SpotifyApi;
use App\Modele\DataObject\Artiste;
use App\Modele\DataObject\Categorie;
use App\Modele\DataObject\compose;
use App\Modele\Repository\AppartientRepository;
use App\Modele\Repository\ArtisteRepository;
use App\Modele\Repository\CategorieRepository;
use App\Modele\Repository\composeRepository;
use App\Modele\Repository\LangueRepository;
use function Sodium\add;

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

public static function afficherVueFormulaireAjoutArtistes()
{
    $langues = (new LangueRepository())->get();
    self::afficherVue("vueGenerale.php", [
        "titre" => "Ajouter plusieurs artistes",
        "cheminCorpsVue" => "admin/vueFormulaireAjoutArtistes.php",
        "messagesFlash" => MessageFlash::lireTousMessages(),
        "langues" => $langues
    ]);
}

public static function ajoutArtistes (){
        var_dump($_REQUEST['langue']);
        $langues = (new LangueRepository())->getByPrimaryKeys([$_REQUEST['langue']]);
    $spotify = SpotifyApi::getInstance();
    $playlist = $spotify->searchPlaylists($_REQUEST['recherche'], $langues->getXRegion());
    $dezeer = new DeezerApi();

    if ($playlist) {
        echo "🔹 Playlist : " . $playlist['name'] . "<br>";
        echo "🔗 Lien : <a href='" . $playlist['external_urls']['spotify'] . "' target='_blank'>Écouter</a><br><br>";

        $tracks = $spotify->getPlaylistTracks($playlist['id']);

        echo "🎵 **Liste des morceaux avec genres** :<br>";
        $artistes = [];
        $compose = [];
        foreach ($tracks['items'] as $index => $track) {
            $track_name = $track['track']['name'] ?? "Nom inconnu";
            $artist = $track['track']['artists'][0] ?? null;
            $artist_name = $artist['name'];
            $artist_id = $artist['id'] ?? null;

            $genres = $artist_id ? $spotify->getArtistGenres($artist_id) : [];
            $genres_text = !empty($genres) ? implode(", ", $genres) : "Genres inconnus";
            $resulte = $dezeer->add($artist_name . " " . $track_name);
            if ($resulte['id'] != null && $genres != null) {
                $artistes[] = new Artiste($artist_name, '', '', $resulte['id'], "https://en.wikipedia.org/wiki/" . urldecode($artist_name), $resulte['image']);

                foreach ($genres as $genre) {
                    if ((new CategorieRepository())->getByPrimaryKeys([$genre]) == null) {
                        (new CategorieRepository())->add(new Categorie($genre, null));
                    }
                    $compose[] = new compose($artist_name, $langues->getLangue(), $genre);
                }
            }

            echo ($index + 1) . ". **$track_name** - $artist_name <br>";
            echo "   🎭 Genres : $genres_text <br><br>";
        }
        (new ArtisteRepository())->addAll($artistes);
        var_dump($compose);
        (new composeRepository())->addAll($compose);
    } else {
        echo "Aucune playlist trouvée.";
    }
    $langues = (new LangueRepository())->get();
    self::afficherVue("vueGenerale.php", [
        "titre" => "Ajouter plusieurs artistes",
        "cheminCorpsVue" => "admin/vueFormulaireAjoutArtistes.php",
        "messagesFlash" => MessageFlash::lireTousMessages(),
        "langues" => $langues
    ]);
}






}