<?php

namespace App\Lib;

class DeezerApi
{
    /**
     * @param array $lienDeezer
     */
    public function get(array $lienDeezer)
    {
        // Clear the session data
        $_SESSION['songs'] = [];
        $_SESSION['artistes'] = [];
        foreach ($lienDeezer as $lien) {
            $curl = curl_init();
            $artistId = $lien;
            $url = "https://api.deezer.com/artist/" . $artistId . "/top?limit=30";

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $data = json_decode($result, true);
                if (isset($data['data']) && count($data['data']) > 0) {
                        $randomTrack = $data['data'][array_rand($data['data'])];
                    
                    // Enregistrer la chanson dans la session   
                    $_SESSION['songs'][] = $randomTrack['preview'];
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
            $_SESSION['artistes'][] = $data['name'];
        }
}

    public function add(string $recherche) : int
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
                return $artistId;
            } else {
                echo "No artist data available.";
            }
        }
        return 0;
    }
}