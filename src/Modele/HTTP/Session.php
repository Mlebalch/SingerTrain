<?php
namespace App\Modele\HTTP;

use Exception;

class Session
{
    private static ?Session $instance = null;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        if (session_start() === false) {
            throw new Exception("La session n'a pas réussi à démarrer.");
        }
    }

    public static function getInstance(): Session
    {
        if (is_null(Session::$instance))
            Session::$instance = new Session();
        return Session::$instance;
    }

    public function contient($nom): bool
    {
        return isset($_SESSION[$nom]);
    }

    public function ecrire(string $nom, mixed $valeur): void
    {
        $_SESSION[$nom] = $valeur;
    }

    public function lire(string $nom): mixed
    {
        if (!$this->contient($nom)) return "";
        return $_SESSION[$nom];
    }

    public function supprimer($nom): void
    {
        unset($_SESSION[$nom]);
    }

    public function detruire() : void
    {
        session_unset();
        session_destroy();
        Cookie::supprimer(session_name());
        Session::$instance = null;
    }
}
