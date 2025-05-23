<?php

namespace App\Lib;

use App\Modele\HTTP\Session;
class DeezerApi
{
    /**
     * @param array $lienDeezer
     */
    public function get(array $lienDeezer, int $nbChansons , string $accept_Language , string $x_Region ) : void
    {
        // Clear the session data
        Session::getInstance()->ecrire('dico', []);
        $i = 0;

        while ($i < $nbChansons) {
            if (count($lienDeezer) == 0) {
                break;
            }
            $curl = curl_init();
            $artistId = $lienDeezer[0];
            $url = "https://api.deezer.com/artist/" . $artistId . "/top?limit=30";

            $headers = [
                'Accept-Language: ' . $accept_Language,
                'X-Region: ' . $x_Region
            ];

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);  // Ajouter les en-têtes

            $result = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" .   $err;
            } else {
                $data = json_decode($result, true);
                if (isset($data['data']) && count($data['data']) > 0) {
                    $randomTrack = $data['data'][array_rand($data['data'])];
                    while(count($randomTrack['contributors']) != 1){
                        $randomTrack = $data['data'][array_rand($data['data'])];
                    }
                         
                    // Enregistrer la chanson dans la session
                     } else {
                    echo "No tracks data available.";
                }
            }

            $url = "https://api.deezer.com/artist/" . $artistId;

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $data = json_decode($result, true);
            $_SESSION ['dico'][] = ['song' => $randomTrack['preview'],'titre' => $randomTrack['title'] ,'artiste' => $data['name'], 'img' => $data['picture_medium'], 'tentative' => 0];
            array_splice($_SESSION['lien'], 0, 1);
            $i++;
        }
}

    public function add(string $recherche) : array
    {
        $curl = curl_init();

        $url = "https://api.deezer.com/search?q=" . urlencode($recherche);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120); // Set timeout to 120 seconds

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true);
            if (isset($data['data']) && count($data['data']) > 0) {
                $data = $data['data'][0];
                $artistId = $data['artist']['id'];
                $artistImage = $data['artist']['picture_medium'];
                return ['id' => $artistId, 'image' => $artistImage];
            } else {
                echo "No artist data available.";
            }
        }
        return ['id' => null, 'image' => null];
    }
}