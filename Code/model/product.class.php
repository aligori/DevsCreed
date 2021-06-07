<?php
    require_once('db_conn.php');

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

        public static function modifyProductPrice($product_id, $change) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/ 
            $dbh = (new Database())->get_connection();
            $query = "UPDATE `product` SET `price` = ? WHERE `product_id` = ?";
            
            $stmt = $dbh->prepare($query);
            $stmt->execute([$change, $product_id]);
            $stmt = null;

        }
        public static function modifyProductSell_Price($product_id, $change) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/
            $dbh = (new Database())->get_connection();
            $query = "UPDATE `product` SET `sell_price` = ? WHERE `product_id` = ?";

            $stmt = $dbh->prepare($query);
            $stmt->execute([$change, $product_id]);
            $stmt = null;
        }
        public static function modifyProductName($product_id, $change) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/
            $dbh = (new Database())->get_connection();
            $query = "UPDATE `product` SET `name` = ? WHERE `product_id` = ?";

            $stmt = $dbh->prepare($query);
            $stmt->execute([$change, $product_id]);
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