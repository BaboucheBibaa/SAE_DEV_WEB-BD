<?php
class Utils
{
    public function generatePassword($length = 10)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[random_int(0, $max)];
        }
        return $result;
    }

    public function hashPassword($clair)
    {
        // Retourne un hash du mdp (on fait une fonction afin de pouvoir maintenir + facilement le type de hashage utilisé)
        return password_hash($clair, PASSWORD_DEFAULT);
    }

    public function verifyPassword($saisie, $hash)
    {
        return password_verify($saisie, $hash);
    }
}