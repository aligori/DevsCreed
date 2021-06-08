<?php

    require_once('db_conn.php');

    class Transaction
    {

        private $dbh = null;

        public function __construct($dbh){
            $this->dbh = $dbh;
        }

        public function addTransaction($date, $client, $total, $service_id){
            $query = "INSERT INTO `transaction` (`date`, `client`, `total`, `service_id`) VALUES (?, ?, ?, ?);";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$date, $client, $total, $service_id]);
        }

        public function getLatestTransactions($date){
            $stmt = $this->dbh->prepare("SELECT * FROM `transaction` WHERE `date` = ?");
            $stmt->execute([$date]);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$arr) exit('No rows');

            /*
            What will be returned:
                                   `date`
                                   `client`
                                   `total`
                                   `transaction_id`
                                   `service_id`
            */

            $stmt = null;
            var_export($arr);

        }

        public function getTransactionInTimePeriod($date1, $date2){
            $stmt = $this->dbh->prepare("SELECT * FROM `transaction` WHERE `date` >= ? AND `date` < ?");
            $stmt->execute([$date1, $date2]);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$arr) exit('No rows');

            /*
            What will be returned:
                                   `date`
                                   `client`
                                   `total`
                                   `transaction_id`
                                   `service_id`
            */

            $stmt = null;
            var_export($arr);
        }
    }