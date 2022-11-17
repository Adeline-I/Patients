<?php

require_once(dirname(__FILE__).'/../config/init.php');

// Créer une instance PDO qui représente une connexion à la base.
// PDO::ATTR_ERRMODE : rapport d'erreurs.
// PDO::ERRMODE_EXCEPTION : émet une exception.
// PDO::ATTR_DEFAULT_FETCH_MODE : définit le mode de récupération par défaut.

class Database {

    public static function dbConnect():object {
        try {
            $pdo = new PDO(DSN, USER, PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
            return $pdo;
        } catch (PDOException $exception) {
            header('location: /controllers/error-db-controller.php?error=1');
            die;
        }
    }
}