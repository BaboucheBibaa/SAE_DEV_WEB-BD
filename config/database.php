<?php
class Database
{

    //pattern singleton afin de ne pas avoir une connexion qui se fait à chaque fois que l'on appelle la fonction
    //solution à cela: static, attribut de classe donc appelé une seule fois
    private static $conn = null;
    public static function getConnection()
    {

        if (self::$conn !== null) {
            return self::$conn;
        }

        self::$conn = oci_connect(MYUSER, MYPASS, MYHOST);

        if (!self::$conn) {
            $e = oci_error();
            trigger_error(htmlspecialchars($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return self::$conn;
    }
}
