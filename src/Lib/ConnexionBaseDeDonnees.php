<?php

namespace App\Lib;
use App\Configuration\ConfigurationBaseDeDonnees;

use PDO;

class ConnexionBaseDeDonnees
{
    private static ?ConnexionBaseDeDonnees $instance = null;
    private PDO $pdo;


    public static function getPdo(): PDO
    {
        return ConnexionBaseDeDonnees::getInstance()->pdo;
    }

    private function __construct()
    {
        // Code du constructeur
        $login = ConfigurationBaseDeDonnees::getLogin();
        $motDePasse = ConfigurationBaseDeDonnees::getMotDePasse();
        $nomBaseDeDonnees = ConfigurationBaseDeDonnees::getNomBaseDeDonnees();
        $nomHote = ConfigurationBaseDeDonnees::getNomHote();
        $port = ConfigurationBaseDeDonnees::getPort();
        // Connexion à la base de données
        // Le dernier argument sert à ce que toutes les chaines de caractères
        // en entrée et sortie de MySql soient dans le codage UTF-8
        $this->pdo = new PDO("mysql:host=$nomHote;port=$port;dbname=$nomBaseDeDonnees", $login, $motDePasse,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        // On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // getInstance s'assure que le constructeur ne sera
    // appelé qu'une seule fois.
    // L'unique instance crée est stockée dans l'attribut $instance
    private static function getInstance(): ConnexionBaseDeDonnees
    {
        // L'attribut statique $instance s'obtient avec la syntaxe ConnexionBaseDeDonnees::$instance
        if (is_null(ConnexionBaseDeDonnees::$instance))
            // Appel du constructeur
            ConnexionBaseDeDonnees::$instance = new ConnexionBaseDeDonnees();
        return ConnexionBaseDeDonnees::$instance;
    }

}
