<?php


namespace application\models;

use application\core\Model;

class Cart extends Model
{
    public function checkArray($array_big, $array2) //проверка дубликата масивов array_big - сессия, $array - масив добавления -_О_-
    {
        foreach ($array_big as $array_small){
            if ($array_small === $array2){
                return false;
            }
        }
    }
    public function checkCartProduct($id_product, $id_category)
    {
        $user_id = $_SESSION['account']['id'];
        if ($this->db->column("SELECT id_product_cart  FROM cart WHERE id_product_in_cart = $id_product and id_user = $user_id and id_category_product = $id_category"))
        {
            $this->error = 'Этот товар уже в корзине';
            return false;
        }
        else
        {
            return true;
        }
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
    public function addToCart($category, $product) // Добавление в корзину нового товара (+ проверка на дубликат)
    {

        if(isset($_SESSION['account'])){
            if(!$this->checkCartProduct($_POST['id_product'], $_POST['category_id']))
            {

            }
            else
            {
                $user_id = $_SESSION['account']['id'];
                $this->db->query("INSERT INTO `cart`(`id_user`, `id_product_in_cart`, `id_category_product`) VALUES ($user_id, $product, $category)");
                $this->error = 'Товар добавлен в корзину';
            }
        }
        else {
            $result = Array();
            $product_for_cart = Array
            (
                Array('category_id' => $category, 'product_id' => $product)
            );
            if (session_status() == PHP_SESSION_NONE)
            {
                session_start();
            }

            if (!isset($_SESSION['cart']))
            {
                $_SESSION['cart'] = $product_for_cart;
            }
            else
            {
                if($this->checkArray($_SESSION['cart'], $product_for_cart[0]) === false)
                {

                }
                else
                {
                    $_SESSION['cart'] = array_merge($_SESSION['cart'], $product_for_cart);
                }
            }
        }

    }
    public function cURL($city){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.novaposhta.ua/v2.0/json/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{\n    \"apiKey\": \"aa9f1dde3fc96b2ab8242d0179220c9f\",\n    \"modelName\": \"Address\",\n    \"calledMethod\": \"searchSettlements\",\n    \"methodProperties\": {\n        \"CityName\": \"$city\",\n        \"Limit\": 5\n    }\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Type: application/json",
                "Host: api.novaposhta.ua",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo ($response);
        }
    }
    public function pURL($Ref){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.novaposhta.ua/v2.0/json/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{\r\n    \"modelName\": \"AddressGeneral\",\r\n    \"calledMethod\": \"getWarehouses\",\r\n    \"methodProperties\": {\r\n         \"CityRef\": \"$Ref\"\r\n    },\r\n    \"apiKey\": \"aa9f1dde3fc96b2ab8242d0179220c9f\"\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Type: application/json",
                "Host: api.novaposhta.ua",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
    public function delFromCart($category, $product)
    {
        $product_del_cart = Array('category_id' => $category, 'product_id' => $product);
        if (isset($_SESSION['cart']))
        {
            $i = 0;
            foreach ($_SESSION['cart'] as $product_cart)
            {
                if($product_cart === $product_del_cart)
                {
                    unset($_SESSION['cart'][$i]);
                    $new = array_values($_SESSION['cart']);
                    $_SESSION['cart'] = $new;
                }
                $i=$i+1;
            }
        }
    }

    public function getAmountPrice($array){
        $amount_price = 0;
        foreach ($array as $value){
            $category_id =  $value['category_id'];
            $product_id = $value['product_id'];
            $table_cat = $this->db->column("SELECT `name` FROM `category` WHERE `id_category` = $category_id ");
            $table_cat = transliterate($table_cat);
            $product = $this->db->row("SELECT * FROM $table_cat WHERE id_product = '$product_id'");
            $amount_price = $amount_price + $product[0]['product_price'];
        }
        return $amount_price;
    }

    public function getCartProducts($array){ // Изымает из сессии все товары которые были добавлены в корзину
        $products = Array();
        foreach ($array as $value){
            $category_id =  $value['category_id'];
            $product_id = $value['product_id'];
            $table_cat = $this->db->column("SELECT `name` FROM `category` WHERE `id_category` = $category_id ");
            $table_cat = transliterate($table_cat);
            $product = $this->db->row("SELECT * FROM $table_cat WHERE id_product = '$product_id'");
            array_push($products, $product);

        }
        return $products;
    }

    public function getPostAddresses($city)
    {
        $postsArray = Array();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.novaposhta.ua/v2.0/json/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n\"apiKey\": \"aa9f1dde3fc96b2ab8242d0179220c9f\",\r\n\"modelName\": \"AddressGeneral\",\r\n\"calledMethod\": \"getWarehouses\",\r\n\"methodProperties\": {\r\n\"CityName\":\"$city\"\r\n}\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err)
        {
            echo "cURL Error #:" . $err;
        }
        else
        {
            $response = json_decode($response);
            $response = $response->{'data'};
            foreach ($response as $key => $value)
            {
                array_push($postsArray, $value->{'Description'});
            }
        }
        return $postsArray;
    }

    public function getCities()
    {
        $citiesArray = Array();
        $curl = curl_init();
        curl_setopt_array($curl, array
        (
            CURLOPT_URL => "https://api.novaposhta.ua/v2.0/json/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n\"apiKey\": \"aa9f1dde3fc96b2ab8242d0179220c9f\",\r\n\"modelName\": \"Address\",\r\n\"calledMethod\": \"getCities\",\r\n\"methodProperties\": {\r\n}\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err)
        {
            echo "cURL Error #:" . $err;
        }
        else
        {
            $response = json_decode($response);
            $response = $response->{'data'};
            foreach ($response as $key => $value)
            {
                array_push($citiesArray, $value->{'Description'});
            }
        }
        return $citiesArray;
    }
    public function  sendOrder($post)
    {

        unset($_SESSION["cart"]);
        $products = '';
        for($i=1; $i <= 100; $i++){
            $name = 'product_'.$i;
            if(isset($post[$name])){
                $product_name = $post[$name];
                $product_amount = $post[translit($product_name)];
                $products = $products .' '. $product_name .' ('.$product_amount.'), ';
            }
        }
        $first_name = $post['first_name'];
        $last_name = $post['last_name'];
        $phone_number = $post['phone_number'];
        $city = $post['city_addr'];
        $post_address = $post['address_post_department'];
        $amount_price = $post['amount_price'];
        $pay_type = $post['payment'];
        $products = substr($products, 0, -2);
        $this->db->query("INSERT INTO `orders`(`first_name`, `last_name`, `phone_number`, `city`, `post_address`, `amount_price`, `pay_type`, `products`)
                                VALUES ( '$first_name', '$last_name', '$phone_number', '$city', '$post_address', '$amount_price', '$pay_type', '$products')");
    }
}