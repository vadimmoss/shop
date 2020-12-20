<?php


namespace application\models;

use application\core\Model;


class Menu extends Model
{
    public function viewCategories()
    {
        $categories = $this->db->row("select * from category ");
        return $categories;
    }
    public function viewAllTypes($category_name, $id)
    {
        $types = $this->db->row("select * from type_of_category where id_category = $id");
        return $types;
    }
    public function viewAll()
    {
        $products = $this->db->row("SELECT * FROM Noytbyki");
        $all_products = Array();
        foreach ($products as $product)
        {
            array_push($all_products, $product);
        }
        return $all_products;
    }

    public function viewAllCategories($category_id)
    {
        $all_categories = Array();
        $categories = $this->db->row("select * from category where id_category = $category_id");
        foreach($categories as $category)
        {
            $id_category = $category['id_category'];
            $haracter_names = $this->db->row("select *  from haracter_name where  id_category = '$id_category'");
            $name = $category['name'];
            $names = Array();
            foreach ($haracter_names as $haracter_name)
            {
                $id_harac = $haracter_name['id_har'];
                $haracter_types = $this->db->row("select *  from type_harac where  id_har = '$id_harac'");
                $chars = Array();
                foreach ($haracter_types as $haracter_type)
                {
                    array_push($chars,$haracter_type);
                }
                $names[$haracter_name['name_haracter']] = $chars;
            }
            $all_categories[$name] = $names;
        }
        return $all_categories;
    }

    public function viewFilter($table_name,$filters, $category, $id_category, $type, $id_type)
    {

        $all_products = Array();
        $arr = $filters;
        $max_price = $_POST["maxPrice"];
        $min_price = $_POST['minPrice'];
        array_pop($arr);
        array_pop($arr);
        $id_products_by_type = $this->db->row("SELECT * FROM product_and_type WHERE id_catedory = $id_category and id_type = $id_type");
        foreach ($id_products_by_type as $id) {
            $id = $id['id_product'];
            if (isset($_POST['maxPrice']) and isset($_POST['minPrice'])) {
                $query = "select * from $table_name where id_product = $id and product_price <= $max_price and product_price >= $min_price and";
            } else {
                $query = "select * from $table_name where  id_product = $id AND";

            }
            foreach ($arr as $f) {
                $query .= $f . ' and ';
            };
            $query = substr($query, 0, -4);
            $products = $this->db->row("$query");
            foreach ($products as $product) {
                $is_in_cart_database = $this->isInCartDatabase($product['product_category_id'], $product['id_product']);
                $is_in_cart = $this->isInCartSession($product['product_category_id'], $product['id_product']);
                $product['is_in_cart'] = $is_in_cart;
                $product['is_in_cart_database'] = $is_in_cart_database;
                array_push($all_products, $product);
            }
        }
        return $all_products;
    }
    public function viewFilterall($filters, $category, $id_category, $type, $id_type)
    {
        $max_price = $_POST["maxPrice"];
        $min_price = $_POST['minPrice'];
        $all_products = Array();
        $tables = $this->db->row("SELECT * FROM category where id_category = $id_category");
        foreach ($tables as $table)
        {
            $id_products_by_type = $this->db->row("SELECT * FROM product_and_type WHERE id_catedory = $id_category and id_type = $id_type");
            foreach ($id_products_by_type as $id)
            {
                $id = $id['id_product'];
            $table_name = transliterate($table['name']);
            $products = $this->db->row("SELECT * FROM $table_name where id_product = $id and product_price <= $max_price and product_price >= $min_price");
            foreach ($products as $product)
            {
                $is_in_cart_database = $this->isInCartDatabase($product['product_category_id'], $product['id_product']);
                $is_in_cart = $this->isInCartSession($product['product_category_id'], $product['id_product']);
                $product['is_in_cart'] = $is_in_cart;
                $product['is_in_cart_database'] = $is_in_cart_database;
                array_push($all_products, $product);
            }
            }
        }
        return $all_products;
    }
    public function maxPrice()
    {
        $all_products = Array();
        $tables = $this->db->row("SELECT * FROM category");
        foreach ($tables as $table)
        {
            $table_name = transliterate($table['name']);
            $products = $this->db->row("SELECT MAX(product_price) FROM $table_name");
            foreach ($products as $product)
            {
                array_push($all_products, $product);
            }
        }
        return max($all_products);
    }

    public function search($string, $category, $id_category, $type, $id_type)
    {
        $all_products = Array();
        $tables = $this->db->row("SELECT * FROM category where  id_category = $id_category");
        foreach ($tables as $table)
        {
            $table_name = transliterate($table['name']);
            $id_products_by_type = $this->db->row("SELECT * FROM product_and_type WHERE id_catedory = $id_category and id_type = $id_type");
            foreach ($id_products_by_type as $id){
                $id = $id['id_product'];
                $products = $this->db->row("SELECT * FROM $table_name WHERE id_product = $id and product_name LIKE '%$string%'");
                foreach ($products as $product)
                {
                    $is_in_cart_database = $this->isInCartDatabase($product['product_category_id'], $product['id_product']);
                    $is_in_cart = $this->isInCartSession($product['product_category_id'], $product['id_product']);
                    $product['is_in_cart'] = $is_in_cart;
                    $product['is_in_cart_database'] = $is_in_cart_database;
                    array_push($all_products, $product);
                }
            }


        }
        return $all_products;
    }

    public function isInCartSession($product_category, $product_id){
        if (isset($_SESSION['cart']))
        {
            foreach ($_SESSION['cart'] as $value)
            {
                if ($product_category === $value['category_id'] and $product_id === $value['product_id'])
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



    public function getKeyWords()
    {
        $all_keywords = Array();
        $categories = $this->db->row("SELECT name FROM category");
        foreach ($categories as $category)
        {
            array_push($all_keywords, $category['name']);
        }
        return $all_keywords;
    }
    public function getMainTitle(){
        $title = 'Интернет-магазин '.shop_name().' | Магазин техники, електроники в Украние.';
        return $title;
    }
    public function getDescription()
    {
        $description = 'Купить ';
        $categories = $this->db->row("SELECT name FROM category");
        foreach ($categories as $category)
        {
            $description = $description . $category['name'].', ';
        }
        $description = $description . ' в интеренет магазине техники - '.shop_name().', по низким ценам.';
        return $description;
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
}