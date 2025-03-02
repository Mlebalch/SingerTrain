<?php
namespace App\Lib;

class MessageFlash
{
    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    // $type parmi "success", "info", "warning" ou "danger"
    public static function ajouter(string $type, string $message): void
    {
        if (!isset($_SESSION[self::$cleFlash])) {
            $_SESSION[self::$cleFlash] = [];
        }
        $_SESSION[self::$cleFlash][$type][] = $message;
    }

    public static function contientMessage(string $type): bool
    {
        return isset($_SESSION[self::$cleFlash][$type]);
    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array
    {
        if (!isset($_SESSION[self::$cleFlash][$type])) {
            return [];
        }
        $messages = $_SESSION[self::$cleFlash][$type];
        unset($_SESSION[self::$cleFlash][$type]);
        return $messages;
    }

    public static function lireTousMessages(): array
    {
        if (!isset($_SESSION[self::$cleFlash])) {
            return [];
        }
        $messages = $_SESSION[self::$cleFlash];
        unset($_SESSION[self::$cleFlash]);
        return $messages;
    }
}