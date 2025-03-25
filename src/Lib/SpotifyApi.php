<?php

namespace App\Lib;

use App\Configuration\ConfigurationSpotify;
use App\Modele\HTTP\Session;

class SpotifyApi
{


    private static ?SpotifyApi $instance = null;
    private string $access_token;

    private function __construct()
    {
        $url = "https://accounts.spotify.com/api/token";

        $headers = [
            "Authorization: Basic " . base64_encode(ConfigurationSpotify::getClientId() . ":" . ConfigurationSpotify::getClientSecret()),
            "Content-Type: application/x-www-form-urlencoded"
        ];

        $data = "grant_type=client_credentials";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $response_data = json_decode($response, true);
        $this->access_token = $response_data['access_token'] ?? null;
    }

    public static function getInstance(): SpotifyApi
    {
        if (is_null(self::$instance)) {
            self::$instance = new SpotifyApi();
        }
        return self::$instance;
    }

    public function searchPlaylists(string $query, int $limit = 3): array
    {
        $url = "https://api.spotify.com/v1/search?q=" . urlencode($query) . "&type=playlist&market=FR&limit=$limit";

        $headers = [
            "Authorization: Bearer " . $this->access_token
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}

// Exécution du test
$spotify = SpotifyApi::getInstance();
$playlists = $spotify->searchPlaylists("rap français");

echo "<pre>";
print_r($playlists);
echo "</pre>";
?>

}