<?php

class Database {
    const HOST = "localhost";
    const USER ="root";
    const PASSWORD ="";
    const DB_NAME ="eye_clinic";

    public static function get_connection() {
        $dsn = 'mysql:host=' . Database::HOST . ';dbname=' . Database::DB_NAME;

        try {
            $pdo = new PDO($dsn, Database::USER, Database::PASSWORD);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }
}