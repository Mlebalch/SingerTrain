<?php

namespace App\Lib;

class animeSongsApi
{
    public  function fetchAnimeSongs($music, $artist)
    {

        $baseUrl = "https://animesongs.org/api/songs/search";
        $query = http_build_query([
            'q' => "$artist $music",
            'expand' => 'anime,artists',
            'per-page' => 10
        ]);

        $url = "$baseUrl?$query";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ["error" => "cURL Error: $error"];
        }
        curl_close($ch);
        if ($httpCode !== 200) {
            return ["error" => "HTTP Error: $httpCode"];
        }
        return json_decode($response, true);
    }
}