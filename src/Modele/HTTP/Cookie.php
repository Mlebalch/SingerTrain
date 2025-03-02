<?php

namespace App\Modele\HTTP;

class Cookie
{
    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void
    {
        setcookie($cle, serialize($valeur), $dureeExpiration ?? 0);
    }

    public static function lire(string $cle): mixed
    {
        return unserialize($_COOKIE[$cle]);
    }

    public static function contient($cle) : bool
    {
        return isset($_COOKIE[$cle]);
    }

    public static function supprimer(string $cle): void
    {
        unset($_COOKIE[$cle]);
        setcookie ($cle, "", 1);
    }

}