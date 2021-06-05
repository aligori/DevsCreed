<?php
    require_once('../db_conn.php');

    class Product {

        public static function getProduct($product_id) {
            
            //Prepare query and fetch result
            $dbh = (new Database())->get_connection();
            $stmt = $dbh->prepare("SELECT * FROM `product` WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$arr) exit('No rows');

            /*
            What will be returned: 
                                    `price` 
                                    `sell_price` 
                                    `quantity`
                                    `product_id` 
                                    `name` 
                                    `description` 
                                    `category_id`
            */
            var_export($arr);
            //The stmt = null is a good coding practice.
            $stmt = null;
            
        }

        public static function modifyProducts($product_id, $field, $change) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/ 
            $dbh = (new Database())->get_connection();
            $query = "UPDATE `product` SET ? = ? WHERE `product_id` = ?";
            
            $stmt = $dbh->prepare($query);
            $stmt->execute([$field, $change, $product_id]);
            $stmt = null;

        }

        public static function addToQuantity($product_id, $quantity) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/ 
            $dbh = (new Database())->get_connection();
            $query = "UPDATE `staff` SET `quantity` = `quantity` + ? WHERE `product_id` = ?";
            
            $stmt = $dbh->prepare($query);
            $stmt->execute([$quantity, $product_id]);
            $stmt = null;

        }

    }