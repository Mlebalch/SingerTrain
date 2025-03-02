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
            $url = "https://deezerdevs-deezer.p.rapidapi.com/playlist/" . $artistId;

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: deezerdevs-deezer.p.rapidapi.com",
                    "x-rapidapi-key: 86585156a1msh5cad0a711131aeap1bbbf9jsn0bcfd2596e1e"
                ],
            ]);

            $result = curl_exec($curl);
            $err = curl_error($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $data = json_decode($result, true);
                if (isset($data['tracks']['data']) && is_array($data['tracks']['data'])) {
                    $i = 0;
                    while (!isset($data['tracks']['data'][$i]['preview'])) {
                        $i++;
                        if ($i == count($data['tracks']['data'])) {
                            break;
                        }
                    }
                    if (isset($data['tracks']['data'][$i]['preview'])) {
                        $resulte = $data['tracks']['data'];
                        $resulta = $resulte[rand(0, count($resulte) - 1)];

                        // Enregistrer la chanson dans la session
                        $_SESSION['songs'][] = $resulta['preview'];
                        $_SESSION['artistes'][] = $resulta['artist']['name'];
                    } else {
                        echo "No preview available.";
                    }
                } else {
                    echo "No tracks data available.";
                }
            }
            curl_close($curl);
        }

}
}