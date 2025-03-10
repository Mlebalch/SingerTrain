<?php
namespace App\Configuration;
class ConfigurationBaseDeDonnees
{

    static private array $configurationBaseDeDonnees = array(
        // Le nom d'hote est webinfo a l'IUT
        // ou localhost sur votre machine
        //
        // ou webinfo.iutmontp.univ-montp2.fr
        // pour accéder à webinfo depuis l'extérieur
        'nomHote' => 'webinfo.iutmontp.univ-montp2.fr',
        // A l'IUT, vous avez une base de données nommee comme votre login
        // Sur votre machine, vous devrez creer une base de données
        'nomBaseDeDonnees' => 'lebalchm',
        // À l'IUT, le port de MySQL est particulier : 3316
        // Ailleurs, on utilise le port par défaut : 3306
        'port' => '3316',
        // A l'IUT, c'est votre login
        // Sur votre machine, vous avez surement un compte 'root'
        'login' => 'lebalchm',
        // A l'IUT, c'est le même mdp que PhpMyAdmin
        // Sur votre machine personelle, vous avez creez ce mdp a l'installation
        'motDePasse' => '6XR3k@lDMzhdnOe3'
    );

    static public function getLogin(): string
    {
        // L'attribut statique $configurationBaseDeDonnees
        // s'obtient avec la syntaxe ConfigurationBaseDeDonnees::$configurationBaseDeDonnees
        // au lieu de $this->configurationBaseDeDonnees pour un attribut non statique
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['login'];
    }

    static public function getMotDePasse(): string
    {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['motDePasse'];

    }

    static public function getNomHote(): string
    {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['nomHote'];
    }

    static public function getNomBaseDeDonnees(): string
    {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['nomBaseDeDonnees'];
    }

    static public function getPort(): int
    {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['port'];
    }


}

?>