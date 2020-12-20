<?php

namespace application\models;

use application\core\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class Account extends Model {

    public function validate($input, $post)
    {
        $rules =
            [
            'email' =>
                [
                'pattern' => '#^[a-z0-9]{1,30}@[a-z0-9.]{1,30}$#',
                'message' => 'E-mail адрес указан неверно',
                ],
            'login' =>
                [
                'pattern' => '#^[a-zA-Z0-9]{3,15}$#',
                'message' => 'Логин указан неверно (разрешены только латинские буквы и цифры (a-z, A-Z, 0-9) от 3 до 15 символов',
                ],
            'password' =>
                [
                'pattern' => '#^[A-Za-z0-9]{8,20}$#',
                'message' => 'Пароль указан неверно (разрешены только латинские буквы и цифры (a-z, A-Z, 0-9) от 8 до 20 символов',
                ],
        ];
        foreach ($input as $val)
        {
            if (!isset($post[$val]) or !preg_match($rules[$val]['pattern'], $post[$val]))
            {
                $this->error = $rules[$val]['message'];
                return false;
            }
        }
        return true;
    }


    public function checkEmailExists($email)
    {
        $params =
            [
            'email' => $email,
            ];
        return $this->db->column('SELECT id FROM users WHERE email = :email', $params);
    }

    public function checkLoginExists($login)
    {
        $params = [
            'login' => $login,
        ];
        if ($this->db->column('SELECT id FROM users WHERE login = :login', $params))
        {
            $this->error = 'Этот логин уже используется';
            return false;
        }
        return true;
    }

    public function checkTokenExists($token)
    {
        $params = [
            'token' => $token,
        ];
        return $this->db->column('SELECT id FROM users WHERE token = :token', $params);
    }

    public function activate($token)
    {
        $params = [
            'token' => $token,
        ];
        $this->db->query('UPDATE users SET status = 1, token = "" WHERE token = :token', $params);
    }

    public function checkRefExists($login)
    {
        $params = [
            'login' => $login,
        ];
        return $this->db->column('SELECT id FROM ausers WHERE login = :login', $params);
    }

    public function createToken()
    {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 30)), 0, 30);
    }

    public function register($post)
    {

        $token = $this->createToken();
        if(!isset($post['reg_address_apartment']))
        {
            $address = 'Город: '. $post['reg_address_city'] .', Улица:  '. $post['reg_address_street'] .', Дом № '. $post['reg_address_house'] .', Кв. № ';
        }
        else
            {
                $address = 'Город: '. $post['reg_address_city'] .', Улица:  '. $post['reg_address_street'] .', Дом № '. $post['reg_address_house'] .', Кв. № ' .$post['reg_address_apartment'];
            }
        $address = 'Город: '. $post['reg_address_city'] .', Улица:  '. $post['reg_address_street'] .', Дом № '. $post['reg_address_house'] .', Кв. № ' .$post['reg_address_apartment'];

        $id = '';
        $email = $post['email'];
        $login = $post['login'];
        $first_name = $post['reg_first_name'];
        $last_name = $post['reg_last_name'];
        $phone = $post['phone'];
        $years_old = $post['years_old'];
        $city = $post['reg_address_city'];
        $gender = $post['gender'];
        $password = password_hash($post['password'], PASSWORD_BCRYPT);
        $status = '1';
        $params = [
            'id' => '',
            'email' => $post['email'],
            'login' => $post['login'],
            'first_name' => $post['reg_first_name'],
            'last_name' => $post['reg_last_name'],
            'phone' => $post['phone'],
            'years_old' => $post['years_old'],
            'gender' => $post['gender'],
            'city' => $post['reg_address_city'],
            'address' => $address,
            'password' => password_hash($post['password'], PASSWORD_BCRYPT),
            'token' => $token,
            'status' => 0,
        ];
        $this->db->query('INSERT INTO users VALUES (:id, :email, :login, :first_name, :last_name, :phone, :years_old, :gender, :city, :address, :password, :token, :status)', $params);


        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->CharSet="UTF-8";
            //$mail->SMTPDebug = 1;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->IsHTML(true);
            $mail->Username = 'email.checkshop@gmail.com';
            $mail->Password = '0978210894Shop';
            $mail->setFrom('email.checkshop@gmail.com'); // Ваш Email
            $mail->Subject = "Test";
            if(isset($_SESSION['check_email_code'])){
                unset($_SESSION['check_email_code']);
                $bytes = random_bytes(3);
                $code = bin2hex($bytes);
                $_SESSION['check_email_code'] = $code;
                $_SESSION['login_reg'] = $post['login'];
            }
            else{
                $bytes = random_bytes(3);
                $code = bin2hex($bytes);
                $_SESSION['check_email_code'] = $code;
                $_SESSION['login_reg'] = $post['login'];
            }
            $html_code = "<h1 class='h1'></h1>";
            $mail->Body = '<span style="color: black">Привет '.$post['reg_first_name'].'! </span><br/><span style="color: black">Подтвердите свою регистацию.</span><br/><br/><span style="">Код для подтверждения: <span style="font-weight: bold;">'.$code.'</span></span>'; // Текст письма
            $mail->AddAddress('dexter1998123@gmail.com'); // Email получателя
            //$mail->addAddress(‘example@gmail.com’); // Еще один email, если нужно.
            $mail->isHTML(true);


            $mail->Subject = "Код подтверждения регистрации | ".shop_name(); // Заголовок письма
            //smtp.gmail.com
            //0978210894Shop
            //email.checkshop
            if(!$mail->send()) {
                //echo 'Ошибка: ' . $mail->ErrorInfo;
            }
            else
                {
                    //echo 'каво';
                }
            } catch (Exception $e) {
            //echo  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function checkActivationCode($code)
    {
        if(isset($_SESSION['check_email_code']))
        {
            if($_SESSION['check_email_code'] === $code){
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    public function activateProfile($login)
    {

        $this->db->query("UPDATE users SET status = '1' WHERE login ='$login'");
    }

    public function checkData($login, $password)
    {
        $params = [
            'login' => $login,
        ];
        $hash = $this->db->column('SELECT password FROM users WHERE login = :login', $params);
        if (!$hash or !password_verify($password, $hash))
        {
            return false;
        }
        return true;
    }

    public function checkStatus($type, $data)
    {
        $params = [
            $type => $data,
        ];
        $status = $this->db->column('SELECT status FROM users WHERE '.$type.' = :'.$type, $params);
        if ($status != 1) {
            $this->error = 'Аккаунт ожидает подтверждения по E-mail';
            return false;
        }
        return true;
    }

    public function login($login)
    {
        $params = [
            'login' => $login,
        ];
        $data = $this->db->row('SELECT * FROM users WHERE login = :login', $params);
        $id_user = $data[0]['id'];
        $_SESSION['account'] = $data[0];
        //add products from session
        if(isset($_SESSION['cart'])){
            foreach ($_SESSION['cart'] as $product_to_cart){
                $id_product_in_cart = $product_to_cart['product_id'];
                $category_id = $product_to_cart['category_id'];
                if(!$this->checkCartProduct($id_product_in_cart, $category_id))
                {

                }
                else
                {
                    $user_id = $_SESSION['account']['id'];
                    $this->db->query("INSERT INTO `cart`(`id_user`, `id_product_in_cart`, `id_category_product`) VALUES ($user_id, $id_product_in_cart, $category_id)");
                }
                //$this->db->query("INSERT INTO `cart`(`id_user`, `id_product_in_cart`, `id_category_product`) VALUES ($id_user, $id_product_in_cart, $category_id)");
            }
        }
    }

    public function recovery($post)
    {
        $token = $this->createToken();
        $params = [
            'email' => $post['email'],
            'token' => $token,
        ];
        $this->db->query('UPDATE users SET token = :token WHERE email = :email', $params);
        mail($post['email'], 'Recovery', 'Confirm: '.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/account/reset/'.$token);
    }

    public function reset($token)
    {
        $new_password = $this->createToken();
        $params = [
            'token' => $token,
            'password' => password_hash($new_password, PASSWORD_BCRYPT),
        ];
        $this->db->query('UPDATE users SET status = 1, token = "", password = :password WHERE token = :token', $params);
        return $new_password;
    }

    public function save($post)
    {
        $params = [
            'id' => $_SESSION['account']['id'],
            'email' => $post['email'],
        ];
        if (!empty($post['password']))
        {
            $params['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
            $sql = ',password = :password';
        }
        else
            {
                $sql = ' ';
            }
        foreach ($params as $key => $val)
        {
            $_SESSION['account'][$key] = $val;
        }
        $this->db->query('UPDATE users SET email = :email '.$sql.' WHERE id = :id', $params);
    }

    public function checkCartProduct($id_product, $id_category)
    {
        $user_id = $_SESSION['account']['id'];
        if ($this->db->column("SELECT id_product_cart  FROM cart WHERE id_product_in_cart = $id_product and id_user = $user_id"))
        {
            $this->error = 'Этот товар уже в корзине';
            return false;
        }
        else
            {
            return true;
            }
    }
    public function deleteProductFromCart($id_product)
    {
        $this->db->query("DELETE FROM `cart` WHERE id_product_in_cart  = $id_product");
    }
    public function getCartProducts($id_user)
    {
        $data = $this->db->row("SELECT * FROM cart where id_user = '$id_user'");
        $products = Array();
        foreach ($data as $datum)
        {
            $id_category = $datum['id_category_product'];
            $category = $this->db->column("SELECT name FROM category where id_category = '$id_category'");
            $category = transliterate($category);
            $id_product = $datum['id_product_in_cart'];
            $product = $this->db->row("SELECT * FROM $category where id_product = '$id_product'  ");
            array_push($products, $product);
        }
        return $products;
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
     public function addToCart($id_product, $id_category)
     {
         $user_id = $_SESSION['account']['id'];
         $this->db->query("INSERT INTO `cart`(`id_user`, `id_product_in_cart`, `id_category_product`) VALUES ($user_id, $id_product, $id_category)");
         $this->error = 'Товар добавлен в корзину';
     }

     public function getAmount ($id_user)
     {
         $data = $this->db->row("SELECT * FROM cart where id_user = '$id_user'");
         $prices = Array();
         $amount = 0;
         foreach ($data as $datum)
         {
             $id_category = $datum['id_category_product'];
             $category = $this->db->column("SELECT name FROM category where id_category = '$id_category'");
             $category = transliterate($category);
             $id_product = $datum['id_product_in_cart'];
             $price = $this->db->column("SELECT product_price FROM $category where id_product = '$id_product'  ");
             $amount = $amount + $price;
         }
         return $amount;
     }
     public function waitList($id_user)
     {
         $data = $this->db->row("SELECT * FROM orders where id_user = '$id_user'");
         return $data;
     }
     public function  sendOrder($post)
     {
         $products = '';
         for($i=1; $i <= 100; $i++){
             $name = 'product_'.$i;
             if(isset($post[$name])){
                 $product_name = $post[$name];
                 $product_amount = $post[translit($product_name)];
                 $products = $products .' '. $product_name .' ('.$product_amount.'), ';
             }
         }
         $id_user = $post['id_user'];
         $first_name = $post['first_name'];
         $last_name = $post['last_name'];
         $phone_number = $post['phone_number'];
         $city = $post['city_addr'];
         $post_address = $post['address_post_department'];
         $amount_price = $post['amount_price'];
         $pay_type = $post['payment'];
         $products = substr($products, 0, -2);
         $this->db->query("INSERT INTO `orders`(`id_user`, `first_name`, `last_name`, `phone_number`, `city`, `post_address`, `amount_price`, `pay_type`, `products`)
                                VALUES ($id_user, '$first_name', '$last_name', '$phone_number', '$city', '$post_address', '$amount_price', '$pay_type', '$products')");
         $this->db->query("DELETE FROM `cart` WHERE `cart`.`id_user` = $id_user;");
         unset($_SESSION["cart"]);
    }

    public function getProfileTitle($account)
    {
        $name = $account['first_name'].' '.$account['last_name'];
        $title = 'Личный кабинет '.$name;
        return $title;
    }

    public function getProfile($login)
    {
        if($this->isLoggedIn())
        {
            $data = $this->db->row("SELECT * FROM users where login = '$login'");
            return $data;
        }
        return false;

    }

    public function isLoggedIn()
    {
        if(isset($_SESSION['account']))
        {
            return true;
        }
        else
            {
                return false;
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
}