<?php
    require_once('db_conn.php');

    class Service {
        private $dbh = null;

        public function __construct($dbh) {
            $this->dbh = $dbh;
        }

        public function getServices() {
            $stmt = $this->dbh->prepare("SELECT * FROM `service`");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }