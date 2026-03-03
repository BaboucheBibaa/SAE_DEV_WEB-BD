<?php
class Utils
{
    public static function generatePassword(int $length = 10): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $out = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $out .= $chars[random_int(0, $max)];
        }
        return $out;
    }

    public static function hashPassword(string $plain): string
    {
        // Retourne un hash du mdp (on fait une fonction afin de pouvoir maintenir + facilement le type de hashage utilisé)
        return password_hash($plain, PASSWORD_DEFAULT);
    }

    public static function verifyPassword(string $saisie, string $hash): bool
    {
        return password_verify($saisie, $hash);
    }

    public static function oracleToHtml(?string $oracleDate): ?string
    {
        if (empty($oracleDate)) {
            return null;
        }
        $d = DateTime::createFromFormat('d-M-y', $oracleDate);
        return $d ? $d->format('Y-m-d') : null;
    }

    public static function htmlToOracle(?string $htmlDate): ?string
    {
        if (empty($htmlDate)) {
            return null;
        }
        $d = DateTime::createFromFormat('Y-m-d', $htmlDate);
        return $d ? $d->format('d-M-y') : null;
    }
}