<?php

namespace App\Controleur;

class ControleurGenerique
{
    protected static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres);
        require __DIR__ . "/../Vue/$cheminVue";
    }
}