<?php

    require_once('db_conn.php');

    class Transaction
    {

        private $dbh = null;

        public function __construct($dbh){
            $this->dbh = $dbh;
        }

        public function addTransaction($date, $client, $total, $service_id, $type){
            $query = "INSERT INTO `transaction` (`date`, `client`, `total`, `service_id`, `type`) VALUES (?, ?, ?, ?, ?);";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$date, $client, $total, $service_id, $type]);
        }

        public function getTransactionInTimePeriod($date1, $date2){
            $stmt = $this->dbh->prepare("SELECT * FROM `transaction` WHERE `date` BETWEEN ? AND ?;");
            $stmt->execute([$date1, $date2]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getTransactionsMadeThisMonth(){
            $stmt = $this->dbh->prepare("SELECT * FROM `transaction` WHERE `date` > date_sub(now(), interval 1 month );");
            $stmt->execute([]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getTransactionsMadeToday(){
            $stmt = $this->dbh->prepare("SELECT * FROM `transaction` WHERE `date` = curdate();");
            $stmt->execute([]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_DailyTransactionValue(){
            $stmt = $this->dbh->prepare("SELECT SUM(`total`) AS sum FROM `transaction` WHERE `date` = curdate() AND type='income';");
            $stmt->execute([]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function get_MonthlyTransactionValue(){
            $stmt = $this->dbh->prepare("SELECT SUM(`total`) AS sum FROM `transaction` WHERE `date` > (CURDATE()-INTERVAL 1 MONTH) AND type='income';");
            $stmt->execute([]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function get_ValueSpent(){
            $stmt = $this->dbh->prepare("SELECT SUM(`total`) AS sum FROM `transaction` WHERE `date` = curdate() AND type='expenditure';");
            $stmt->execute([]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }