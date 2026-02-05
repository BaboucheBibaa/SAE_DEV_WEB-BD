<?php
require_once("myparams.inc.php");
class Database {

    private static $conn = null;

    public static function getConnection() {
        $base="zoo";
        $dsn="mysql:host=".MYHOST.";dbname=".$base;
        $user=MYUSER;
        $pass=MYPASS;
        try {
            $idcom = new PDO($dsn,$user,$pass);
            return $idcom;
        }
        catch(PDOException $except){
            die('Erreur : ' . $except->getMessage());
        }
    }
}
