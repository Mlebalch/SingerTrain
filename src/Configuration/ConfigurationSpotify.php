<?php

namespace App\Configuration;

class ConfigurationSpotify
{

    static private array $configurationSpotify = [

// Informations d'identification Spotify
    'client_id' => "",  // Remplace par ton Client ID
    'client_secret' => ""  // Remplace par ton Client Secret
    ];

    static public function getClientId(): string
    {
        return ConfigurationSpotify::$configurationSpotify['client_id'];
    }

    static public function getClientSecret(): string
    {
        return ConfigurationSpotify::$configurationSpotify['client_secret'];
    }
}