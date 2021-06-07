<?php

class Database {
    private $host="localhost";
    private $user="root";
    private $password="";
    private $db_name="eye_clinic";
    private $pdo = null;
    private $conn_error;

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->conn_error = $err->getMessage();
        }
    }

    public function get_connection() {
        if ($this->pdo) {
            return $this->pdo;
        } else {
            return $this->conn_error;
        }
    }
}