<?php

    require_once('../db_conn.php');

    class Transaction
    {

        public static function getLatestTransactions($date){
            $dbh = (new Database())->get_connection();
            $stmt = $dbh->prepare("SELECT * FROM `transaction` WHERE `date` = ?");
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

        public static function getTransactionInTimePeriod($date1, $date2){
            $dbh = (new Database())->get_connection();

            $stmt = $dbh->prepare("SELECT * FROM `transaction` WHERE `date` >= ? AND `date` < ?");
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