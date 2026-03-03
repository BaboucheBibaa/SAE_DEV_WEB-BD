<?php
class Database
{

    private static $conn = null;
    public static function getConnection()
    {

        if (self::$conn !== null) {
            return self::$conn;
        }

        self::$conn = oci_connect(USERNAME, MYPASS, CONNEX);

        if (!self::$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return self::$conn;
    }
}
