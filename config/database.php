<?php
require_once("myparams.inc.php");
class Database
{

    private static $conn = null;

    public static function getConnection()
    {
        // connexion à la base oracle
        $conn = oci_connect(USERNAME, MYPASS, CONNEX);
        
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        return $conn;
    }
}
