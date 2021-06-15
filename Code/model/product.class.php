<?php
    require_once('db_conn.php');

    class Product {

        private $dbh = null;

        public function __construct($dbh){
            $this->dbh = $dbh;
        }

        public function addProduct($price, $sell_price, $quantity, $name, $description, $category_id){
            $query = "INSERT INTO `products` (`price`, `sell_price`, `quantity`, `name`, `description`, `category_id` ) VALUES (?, ?, ?, ?, ?, ?);";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$price, $sell_price, $quantity, $name, $description, $category_id]);
        }

        public function getProduct($product_id) {
            
            //Prepare query and fetch result
            $stmt = $this->dbh->prepare("SELECT * FROM `product` WHERE product_id = ?");
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

            //The stmt = null is a good coding practice.
            $stmt = null;
            return $arr;
            
        }

        public function modifyProductPrice($product_id, $change) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/ 
            $query = "UPDATE `product` SET `price` = ? WHERE `product_id` = ?";
            
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$change, $product_id]);
            $stmt = null;

        }
        public function modifyProductSell_Price($product_id, $change) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/
            $query = "UPDATE `product` SET `sell_price` = ? WHERE `product_id` = ?";

            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$change, $product_id]);
            $stmt = null;
        }
        public function modifyProductName($product_id, $change) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/
            $query = "UPDATE `product` SET `name` = ? WHERE `product_id` = ?";

            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$change, $product_id]);
            $stmt = null;
        }
        public function addToQuantity($product_id, $quantity) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/ 
            $query = "UPDATE `staff` SET `quantity` = `quantity` + ? WHERE `product_id` = ?";
            
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$quantity, $product_id]);
            $stmt = null;

        }

    }