<?php


namespace application\models;


use application\core\Model;

class Product extends Model
{
    public function getProduct($category,$id,$name){
        $table_cat = $this->db->column("SELECT `name` FROM `category` WHERE `id_category` = $category ");
        $table_cat = transliterate($table_cat);
        $product = $this->db->row("SELECT * FROM $table_cat WHERE id_product = '$id'");
        $product['is_in_cart'] = $this->isInCartSession($category,$id);
        $product['is_in_cart_database'] = $this->isInCartDatabase($category,$id);
        return $product;
    }
    public function getAmountInCartSession()
    {
        if(!isset($_SESSION['cart']))
        {
            return 0;
        }
        else
        {
            return count($_SESSION['cart']);
        }
    }
    public function getAmountInCartDatabase($user_id)
    {
        $result = $this->db->row("SELECT * FROM cart WHERE id_user = $user_id");
        return count($result);
    }
    public function getChars($category,$id){
        $product_chars = Array();
        $product = Array();
        $table_cat = $this->db->column("SELECT `name` FROM `category` WHERE `id_category` = $category ");
        $table_cat = transliterate($table_cat);
        $products = $this->db->row("SELECT * FROM $table_cat WHERE id_product = '$id'");
        foreach ($products as $product){
            unset($product['id_product']);
            unset($product['product_name']);
            unset($product['product_description']);
            unset($product['product_category_id']);
            unset($product['product_image']);
            unset($product['product_price']);
        }
        foreach ($product as $key => $value){

            $types = $this->db->row("SELECT * FROM `type_harac` WHERE `id_type` = $value");
            foreach ($types as $value2){
                $id_har = $value2['id_har'];
                $chars = $this->db->row("SELECT * FROM `haracter_name` WHERE `id_har` = $id_har");
                foreach ($chars as $char){
                    $product_chars[$char['name_haracter']] = $value2['harac'];
                }

            }
        }
        return $product_chars;
    }
    public function getProductKeywords($category,$id){
        $table_cat = $this->db->column("SELECT `name` FROM `category` WHERE `id_category` = $category ");
        $table_cat = transliterate($table_cat);
        $product = $this->db->row("SELECT product_name FROM $table_cat WHERE id_product = '$id'");
        $product = explode(' ', $product[0]['product_name']);
        return $product;
    }
    public function getProductTitle($category,$id){
        $table_cat = $this->db->column("SELECT `name` FROM `category` WHERE `id_category` = $category ");
        $table_cat = transliterate($table_cat);
        $product = $this->db->row("SELECT product_name FROM $table_cat WHERE id_product = '$id'");
        $product =  $product[0]['product_name'].' - купить в нашем интернет-магазине '.shop_name().' | Описание и характеристики';
        return $product;
    }
    public function getProductDescription($category,$id){
        $table_cat = $this->db->column("SELECT `name` FROM `category` WHERE `id_category` = $category ");
        $table_cat = transliterate($table_cat);
        $product_description = $this->db->row("SELECT product_name, product_description FROM $table_cat WHERE id_product = '$id'");
        $description = str_replace('"','', $product_description[0]['product_description']);
        $product_description = 'Купить '. $product_description[0]['product_name'].' в интернет-магазине '.shop_name().'. Цена, описание, характеристики. '.$description;
        return $product_description;
    }
    public function isInCartSession($product_category, $product_id){
        if (isset($_SESSION['cart']))
        {

            foreach ($_SESSION['cart'] as $value)
            {
                if ($product_category == $value['category_id'] and $product_id == $value['product_id'])
                {
                    return true;
                }

            }
        }
        else {
            return false;
        }

    }
    public function isInCartDatabase($product_category, $product_id){
        if (isset($_SESSION['account'])){
            $id_user = $_SESSION['account']['id'];
            $product = $this->db->row("SELECT * FROM cart WHERE id_user = $id_user and id_category_product = $product_category and id_product_in_cart  = $product_id");
            if(!isset($product[0])){
                return false;
            }
            else {
                return true;
            }
        }
    }

}