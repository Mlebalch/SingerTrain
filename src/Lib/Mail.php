<?php

namespace App\Lib;

use App\Modele\DataObject\Utilisateur;

class Mail
{
    public static function envoyerMail(Utilisateur $utilisateur, string $sujet, string $message): void
    {
        $destinataire = $utilisateur->getMail();;
        $enTete = "MIME-Version: 1.0\r\n";
        $enTete .= "Content-type:text/html;charset=UTF-8\r\n";

        $corpsEmailHTML = $message;

        // Temporairement avant d'envoyer un vrai mail
        //echo "Simulation d'envoi d'un mail<br> Destinataire : $destinataire<br> Sujet : $sujet<br> Corps : <br>$corpsEmailHTML";

        // Quand vous aurez configué l'envoi de mail via PHP
        mail($destinataire, $sujet, $corpsEmailHTML, $enTete);
    }
}