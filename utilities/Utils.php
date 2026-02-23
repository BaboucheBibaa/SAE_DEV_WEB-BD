<?php
class Utils
{
    public static function generatePassword(int $length = 10): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $out = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $out .= $chars[rand(0, $max)];
        }
        return $out;
    }

    public static function hashPassword(string $plain): string
    {
        return password_hash($plain, PASSWORD_DEFAULT);
    }

    public static function verifyPassword(string $plain, string $hash): bool
    {
        // Si c’est un hash bcrypt, on vérifie; sinon fallback comparaison directe (legacy)
        $isBcrypt = strlen($hash) === 60 && (str_starts_with($hash, '$2y$') || str_starts_with($hash, '$2a$'));
        return $isBcrypt ? password_verify($plain, $hash) : $plain === $hash;
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

    public static function formValue(string $key, $default = '')
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}