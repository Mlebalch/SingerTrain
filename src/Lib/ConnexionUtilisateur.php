<?php

namespace App\Lib;

use App\Modele\DataObject\Utilisateur;
use App\Modele\HTTP\Session;
use App\Modele\Repository\UtilisateurRepository;

class ConnexionUtilisateur
{
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(Utilisateur $utilisateur): void
    {
        $session = Session::getInstance();
        $session->ecrire(self::$cleConnexion, $utilisateur);
    }

    public static function estConnecte(): bool
    {
        $session = Session::getInstance();
        return $session->contient(self::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        $session = Session::getInstance();
        $session->supprimer(self::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        $session = Session::getInstance();
        $utilisateur = $session->lire(self::$cleConnexion);
        return $utilisateur->getLogin();
    }

    public static function estUtilisateur($login): bool
    {
        return $login === self::getLoginUtilisateurConnecte();
    }

    public static function estAdmin(): bool
    {
        if (!self::estConnecte()) return false;
        $session = Session::getInstance();
        $utilisateur = $session->lire(self::$cleConnexion);
        if ($utilisateur == null) return false;
        return $utilisateur->getRole() == 'admin';
    }

    public static function getUtilisateurConnecte(): ?Utilisateur
    {
        return Session::getInstance()->lire(self::$cleConnexion);
    }
}