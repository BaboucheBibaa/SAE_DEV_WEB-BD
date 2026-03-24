<?php

class LogWriter
{
    public function writeLog($type, $message, $filename = 'logs.txt')
    {
        /**
         * Écrit un message de log dans un fichier avec un verrouillage pour éviter les conflits d'écriture.
         * @param string $type Le type de log: 'CONNEXION', 'DECONNEXION', 'INSERTION_BD', 'SUPPRESSION_BD', 'UPDATE_BD', 'ERREUR'
         * @param string $message Le message à enregistrer dans le log
         * @param string $filename Le nom du fichier de log (par défaut 'logs.txt')
         */
        if (!is_dir(dirname($filename))) {
            throw new Exception("Le répertoire du fichier de log n'existe pas.");
        }
        $message = str_replace(["\n", "\r"], ' ', $message); // Nettoyer les sauts de ligne pour éviter les problèmes de format
        $id = fopen($filename, 'a');
        if (!$id) {
            throw new Exception("Impossible d'ouvrir le fichier de log.");
        }
        if (!flock($id, LOCK_EX)) {
            throw new Exception("Impossible de verrouiller le fichier de log.");
        }

        $timestamp = date('Y-m-d H:i:s');
        if (!fwrite($id, "[" . $timestamp . "] [" . $type . "] " . $message . "\n")) {
            throw new Exception("Impossible d'écrire dans le fichier de log.");
        }
        if (!flock($id, LOCK_UN)) {
            throw new Exception("Impossible de déverrouiller le fichier de log.");
        }
        if (!fclose($id)) {
            throw new Exception("Impossible de fermer le fichier de log.");
        }
    }
}
