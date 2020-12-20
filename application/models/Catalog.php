<?php


namespace application\models;

use application\core\Model;

class Catalog extends Model
{
    public function AddNewCategory($name){
        $this->db->row("INSERT INTO `category` ( `name`) VALUES ('$name');");
    }

    public function viewAll()
    {
        $products = $this->db->row("SELECT * FROM Noytbyki");
        $all_products = Array();
        foreach ($products as $product){
            array_push($all_products, $product);
        }
        return $all_products;
    }
    public function viewAllCategories()
    {
        $all_categories = Array();
        $categories = $this->db->row('select * from category');
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
    public function viewFilter($table_name,$filters){
        $all_products = Array();
        $arr = $filters;
        $max_price = $_POST["maxPrice"];
        $min_price = $_POST['minPrice'];
        array_pop($arr);
        array_pop($arr);

        if (isset($_POST['maxPrice']) and isset($_POST['minPrice'])){
            $query =  "select * from $table_name where product_price <= $max_price and product_price >= $min_price and";
        }
        else{
            $query =  "select * from $table_name where  ";
        }


        foreach ($arr as  $f){
            $query .=    $f . ' and ';
        };

        $query = substr($query, 0, -4);
        $products = $this->db->row("$query");
        foreach ($products as $product){
            array_push($all_products, $product);
        }
        return $all_products;

    }
    public function maxPrice()
    {
        $all_products = Array();
        $tables = $this->db->row("SELECT * FROM category");
        foreach ($tables as $table){
            $table_name = transliterate($table['name']);
            $products = $this->db->row("SELECT MAX(product_price) FROM $table_name");
            foreach ($products as $product){
                array_push($all_products, $product);
            }
        }
        return max($all_products);
    }

    public function search($string)
    {
        $all_products = Array();
        $tables = $this->db->row("SELECT * FROM category");
        foreach ($tables as $table){
            $table_name = transliterate($table['name']);
            $products = $this->db->row("SELECT * FROM $table_name WHERE product_name LIKE '%$string%'");
            foreach ($products as $product){
                array_push($all_products, $product);
            }
        }
        return $all_products;
    }
}