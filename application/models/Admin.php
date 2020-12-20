<?php


namespace application\models;


use application\core\Model;

class Admin extends Model
{
    public function loginValidate($post)
    {
        $config = require 'application/config/admin.php';
        if ($config['login'] != $post['login'] or $config['password'] != $post['password']) {
            $this->error = 'Логин или пароль указан неверно';
            return false;
        }
        return true;
    }

    public function AddNewCategory($post, $image_name)
    {
        $chars = $post;
        $chars_for_sidebar = $post;
        unset($chars_for_sidebar['name_add']);
        unset($chars_for_sidebar['count_classes_chars']);
        $table_name = $post['name_add'];
        $this->db->query("INSERT INTO `category` (`name`, `category_image`) VALUES ('$table_name', '$image_name')");
        $id = $this->db->column("SELECT `id_category` FROM `category` WHERE name = '$table_name'");
        foreach ($chars_for_sidebar as $char_for_sidebar){
            $this->db->query("INSERT INTO `haracter_name` (`name_haracter`,`id_category`)  VALUES ('$char_for_sidebar','$id')");
        }
        $table_name = transliterate($table_name);
        $table_id = 'id_product';
        unset($chars['name_add']);
        unset($chars['count_classes_chars']);
        $constr = $table_name.'_ibfk_product_category_id';
        $this->db->query("INSERT INTO `product_tables`(`name_table`) VALUES ('$table_name')");
        $this->db->query
        ("
                CREATE TABLE $table_name (
                 $table_id int(11) NOT NULL,
                `product_name` text NOT NULL,
                `product_description` text NOT NULL,
                `product_category_id` int(11) NOT NULL,
                `product_image` text NOT NULL,
                `product_image2` text,
                `product_image3` text,
                `product_image4` text,
                `product_price` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                ALTER TABLE $table_name
                ADD PRIMARY KEY ($table_id),
                ADD KEY `product_category_id` (`product_category_id`);
                ALTER TABLE $table_name
                MODIFY $table_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
                ALTER TABLE $table_name
                ADD CONSTRAINT $constr FOREIGN KEY (`product_category_id`) REFERENCES `category` (`id_category`);
                COMMIT;
        ");
        foreach ($chars as $char)
        {
            $char = transliterate($char);
            $constr = $table_name.'_ibfk_' .$char;
            $this->db->query
            ("
                    ALTER TABLE $table_name ADD $char INT NOT NULL AFTER `product_price`;
                    ALTER TABLE $table_name
                    ADD KEY $char ($char);
                    ALTER TABLE $table_name
                    ADD CONSTRAINT $constr FOREIGN KEY ($char) REFERENCES `type_harac` (`id_type`);
            ");
        }
    }

    public function AddNewClassOfCharacteristics($category, $classes)
    {
        $category_name = $this->db->row("SELECT name FROM `category` WHERE id_category = $category");
        $category_name = transliterate($category_name[0]['name']);
        foreach ($classes as $class)
        {

            $this->db->query("INSERT INTO `haracter_name` (`name_haracter`, `id_category` )  VALUES ('$class','$category')");

            //$this->db->query("ALTER TABLE $category ADD $class text NULL");
        }
        foreach ($classes as $class)
        {
            $char = transliterate($class);
            $this->db->query
            ("
                    ALTER TABLE $category_name ADD $char INT NULL DEFAULT NULL AFTER `product_price`;
                    ALTER TABLE $category_name ADD INDEX($char);
                    ALTER TABLE $category_name ADD FOREIGN KEY ($char) 
                    REFERENCES `type_harac`(`id_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;
            ");
            echo "
                    ALTER TABLE $category_name ADD $char INT NULL DEFAULT NULL AFTER `product_price`;
                    ALTER TABLE $category_name ADD INDEX($char);
                    ALTER TABLE $category_name ADD FOREIGN KEY ($char) 
                    REFERENCES `type_harac`(`id_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;
            ";
        }
    }

    public function AddNewCharacteristic($post)
    {
        $new_parent_name_id = $post['new_parent_name'];
        $chars = $post;
        unset($chars['new_char_parent_cat']);
        unset($chars['new_parent_name']);
        unset($chars['count_chars']);
        foreach ($chars as $char)
        {
            $this->db->query("INSERT INTO `type_harac` (`harac`, `id_har` )  VALUES ('$char','$new_parent_name_id')");
        }
    }
    public function CheckImage($image,$image1,$image2,$image3,$image4)
    {
        $numbers = array("1", "2", "3", "4");

        foreach ($numbers as $number){
            $image_index = 'add_image'.+$number;
            $image_name = "_".$image[$image_index]['name']; // name of image that will be save in database
            $image_size = $image[$image_index]['size']; //size of image
            $image_type = $image[$image_index]['type'];
            $image_tmp = $_FILES[$image_index]['tmp_name'];
            $expentions = array("image/jpeg", "image/jpg", "image/png"); // Допустимые форматы изображения
            if($image_size<7000000) { // проверка размера изображения, если больше 2 Мб выведет ошибку
                if (in_array($image_type, $expentions)) {
                    //echo var_dump($_FILES['add_image1']['tmp_name']);
                    move_uploaded_file($_FILES['add_image1']['tmp_name'] , "public/images/products_images/".$image1);
                    move_uploaded_file($_FILES['add_image2']['tmp_name'] , "public/images/products_images/".$image2);
                    move_uploaded_file($_FILES['add_image3']['tmp_name'] , "public/images/products_images/".$image3);
                    move_uploaded_file($_FILES['add_image4']['tmp_name'] , "public/images/products_images/".$image4);
                    return $image;
                } else {
                    $this->error = 'Не правильный формат изображения!';
                    return false;
                }
            }
            else {
                $this->error = 'Размер избражения больше 2 Мб';
                return false;
            }
        }
    }



    public function download_image($image,$directory,$image_name)
    {
        $bytes = random_bytes(10);
        $image_name = bin2hex($bytes).'_'.$image_name;
        move_uploaded_file($image['tmp_name'],$directory.$image_name);
        return $image_name;
    }





    public function AddNewProduct($id_category, $image, $image2, $image3, $image4, $chars,$product_name,$product_descrioption,$product_price)
    {
        $category = $this->db->column("SELECT name  FROM `category` WHERE id_category = $id_category");
        $category = transliterate($category);
        $values = '';
        $keys = '';
        foreach ($chars as $key => $value){
            $keys = $keys .'`'. $key .'` , ';
            $values = $values ."'". $value ."' , ";
        }
        $values = substr($values, 0, -2);
        $keys = substr($keys, 0, -2);
        $this->db->query("INSERT INTO $category (`product_name`,`product_description`,`product_price`,`product_category_id`, `product_image`,`product_image2`,`product_image3`,`product_image4`,  $keys)  VALUES ('$product_name','$product_descrioption','$product_price','$id_category','$image','$image2','$image3','$image4',$values)");
        echo "INSERT INTO $category (`product_name`,`product_description`,`product_price`,`product_category_id`, `product_image`,`product_image2`,`product_image3`,`product_image4`,  $keys)  VALUES ('$product_name','$product_descrioption','$product_price','$id_category','$image','$image2','$image3','$image4',$values)";
        $last_product = $this->db->row("SELECT MAX(id_product) FROM $category");
        return $last_product[0]['MAX(id_product)'];
    }
    public function viewAll()
    {
        $tables = $this->db->row("SELECT * FROM product_tables");
        $tables_for_query = '';
        foreach ($tables as $table){
            $tables_for_query = $tables_for_query . $table['name_table'] . ',';
        }
        $tables_for_query =  substr($tables_for_query, 0, -1);
        $products = $this->db->row("SELECT * FROM Noytbyki ");
        $all_products = Array();
        foreach ($products as $product){
            array_push($all_products, $product);
        }
        return $all_products;
    }
    public function viewFullCategories()
    {
        $categories = $this->db->row('select * from category');
        return $categories;
    }
    public function viewTypes($id_category)
    {
        if ($id_category === 'all'){
            $types = $this->db->row('select * from type_of_category');
        }
        else{
            $types = $this->db->row("select * from type_of_category where id_category = $id_category");
        }

        return $types;
    }
    public function viewFullClassesChars()
    {
        $ClassesChars = $this->db->row('select * from haracter_name');
        return $ClassesChars;
    }
    public function viewClasses($category_id)
    {
        $ClassesChars = $this->db->row("select * from haracter_name where id_category = $category_id");
        return $ClassesChars;
    }
    public function addType($type,$category_id,$image_name)
    {
        $this->db->query("INSERT INTO type_of_category(`id_category`, `name_type_of_category`, `type_of_category_image`) VALUES ('$category_id','$type','$image_name')");
        echo "INSERT INTO type_of_category(`id_category`, `name_type_of_category`, `type_of_category_image`) VALUES ('$category_id','$type','$image_name')";
    }
    public function addProductType($id_product,$id_type,$id_catedory)
    {
        $this->db->query("INSERT INTO `product_and_type`( `id_product`, `id_type`, `id_catedory`) VALUES ($id_product,$id_type,$id_catedory)");
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
    public function viewFilter($table_name,$filters)
    {

        $all_products = Array();
        $arr = $filters;
        $max_price = $_POST["maxPrice"];
        $min_price = $_POST['minPrice'];
        array_pop($arr);
        array_pop($arr);
        if (isset($_POST['maxPrice']) and isset($_POST['minPrice']))
        {
            $query =  "select * from $table_name where product_price <= $max_price and product_price >= $min_price and";
        }
        else
        {
            $query =  "select * from $table_name where  ";

        }
        foreach ($arr as  $f)
        {
            $query .=    $f . ' and ';
        };
        $query = substr($query, 0, -4);
        $products = $this->db->row("$query");
        foreach ($products as $product)
        {
            $is_in_cart_database = $this->isInCartDatabase($product['product_category_id'], $product['id_product']);
            $is_in_cart = $this->isInCartSession($product['product_category_id'], $product['id_product']);
            $product['is_in_cart'] = $is_in_cart;
            $product['is_in_cart_database'] = $is_in_cart_database;
            array_push($all_products, $product);
        }

        return $all_products;
    }
    public function viewFilterall($filters)
    {
        $max_price = $_POST["maxPrice"];
        $min_price = $_POST['minPrice'];
        $all_products = Array();
        $tables = $this->db->row("SELECT * FROM category");
        foreach ($tables as $table)
        {
            $table_name = transliterate($table['name']);
            $products = $this->db->row("SELECT * FROM $table_name where product_price <= $max_price and product_price >= $min_price");
            foreach ($products as $product)
            {
                $is_in_cart_database = $this->isInCartDatabase($product['product_category_id'], $product['id_product']);
                $is_in_cart = $this->isInCartSession($product['product_category_id'], $product['id_product']);
                $product['is_in_cart'] = $is_in_cart;
                $product['is_in_cart_database'] = $is_in_cart_database;
                array_push($all_products, $product);
            }
        }
        return $all_products;
    }
    public function getProductChars($post)
    {
        $category_id = $post;
        $all_categories = Array();
        $categories = $this->db->row("select * from category where id_category =  $category_id");
        foreach($categories as $category)
        {
            $id_category = $category['id_category'];
            $haracter_names = $this->db->row("select *  from haracter_name where  id_category = '$id_category'");
            $name = $category['name'];
            $names = Array();
            $ids = Array();
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
        foreach ($tables as $table)
        {
            $table_name = transliterate($table['name']);
            $products = $this->db->row("SELECT * FROM $table_name WHERE product_name LIKE '%$string%'");
            foreach ($products as $product)
            {
                $is_in_cart_database = $this->isInCartDatabase($product['product_category_id'], $product['id_product']);
                $is_in_cart = $this->isInCartSession($product['product_category_id'], $product['id_product']);
                $product['is_in_cart'] = $is_in_cart;
                $product['is_in_cart_database'] = $is_in_cart_database;
                array_push($all_products, $product);
            }
        }
        return $all_products;
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
}