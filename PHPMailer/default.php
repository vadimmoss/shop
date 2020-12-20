<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo $title ?></title>
    <meta name="keywords" content="<?php foreach ($keywords as $keyword){echo $keyword.' ';}; ?>" />
    <meta name="description" content="<?php echo $description ?>" />
    <link href="/public/styles/style.css" rel="stylesheet">
    <script src="/public/scripts/jquery-2.0.3.min.js"></script>
    <script src="/public/scripts/js.js"></script>
    <script src="/public/scripts/form.js"></script>
    <script src="/public/scripts/jquery.js"></script>
    <script src="/public/scripts/popper.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="/public/scripts/alertifyjs/css/alertify.rtl.css">
    <link rel="stylesheet" href="/public/scripts/alertifyjs/css/themes/default.rtl.css">
    <script src="/public/scripts/alertifyjs/alertify.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo shop_logo()?>"" type="image/png">
    <script src="/public/scripts/script.js"></script>
</head>
<body>
<script>
    if(!alertify.myAlert){
        //define a new dialog
        alertify.dialog('myAlert',function factory(){
            return{
                main:function(message){
                    this.message = message;
                },
                setup:function(){
                    return {
                        buttons:[{text: "cool!", key:27/*Esc*/}],
                        focus: { element:0 }
                    };
                },
                prepare:function(){
                    this.setContent(this.message);
                }
            }});
    }
</script>
<div class="wrapper">




    <div id="login_form" class="form_container">
        <div class="block">
            <form action="/account/login" method="post" class="form_style">
                <h2>Вход</h2>
                <ul>
                    <li><label for="login_login">Логин: </label><input  name="login" class="form_input" id="login_login" type="text" required=""></li>
                    <li><label for="login_password">Пароль: </label><input name="password"  class="form_input" id="login_password" type="password" required=""></li>
                    <p class="help-block"></p>
                </ul>
                <div class="form_buttons">
                    <a  class="reg_close_button">Назад</a>
                    <button type="submit" class="button">Вход</button>
                </div>
            </form>
        </div>
    </div>
    <div id="activate_form" class="form_container">
        <div class="block">
            <form id="activation_form" action="/account/activate" method="post" class="form_style">
                <h2>Введите код отправлен нами на ваш Email</h2>
                <ul>
                    <li><label for="activation_code">Код подтверждения: </label><input  name="activation_code" class="form_input" id="activation_code" type="text" required=""></li>
                </ul>
                <div class="form_buttons">
                    <a  class="reg_close_button">Назад</a>
                    <button type="submit" class="button">Подтвердить</button>
                </div>
            </form>
        </div>
    </div>
    <div id="reg_form" class="form_container">
        <div class="block">
            <form id="register_form" action="/account/register" method="post" class="form_style">
                <h2>Регистрация</h2>
                <div  class="double_form">
                    <ul>
                        <li><label class="left_reg" for="reg_login">Логин: <span class="red_star">*</span></label><input name="login" class="form_input" placeholder="Пример: Ivan98" id="reg_login" type="text" required=""></li>
                        <li><label for="reg_first_name">Имя: <span class="red_star">*</span></label><input name="reg_first_name" class="form_input" placeholder="Пример: Иван" id="reg_first_name" type="text" required=""></li>
                        <li><label for="reg_last_name">Фамилия: <span class="red_star">*</span></label><input name="reg_last_name" class="form_input" placeholder="Пример: Иванов" id="reg_last_name" type="text" required=""></li>
                        <li><label for="reg_email">E-mail: <span class="red_star">*</span></label><input name="email" class="form_input" placeholder="Пример: myemail@gmail.com" id="reg_email" type="email" required=""></li>
                        <li><label for="reg_phone">Номер телефона: <span class="red_star">*</span></label><input name="phone" placeholder="Пример: +380111111111" class="form_input" id="reg_phone" required=""></li>
                        <li><label for="reg_years_old">Возраст: </label><select  name="years_old"  class="form_input" id="reg_years_old" >
                                <option>Выберите возраст</option>
                                <?php
                                for ($i=1; $i<= 101; $i++){
                                    echo "<option name='years_old' value='$i'>$i</option>";
                                }
                                ?>
                            </select></li>
                    </ul>
                    <ul>
                        <li><label for="reg_gender">Пол: </label><select  name="gender"  class="form_input" id="reg_gender" >
                                <option name="gender" value="Мужской">Мужской</option>
                                <option name="gender" value="Женский">Женский</option>
                            </select></li>
                        <li class="label_city_input"><label for="reg_address_city">Город: <span class="red_star">*</span></label><div id="city_cont"><input autocomplete="off" class="form_input" url="/cart/cURL" name="reg_address_city" type="text" id="city_select_reg_form" list="city"><div id="city_reg"></div></div></li>
                        <li><label for="reg_address_street">Улица: </label><input name="reg_address_street" class="form_input" placeholder="Пример: Киевская" id="reg_address_street" type="text"></li>
                        <li><label for="reg_address_house">Дом №: </label><input name="reg_address_house" class="form_input" placeholder="Пример: 30" id="reg_address_house" type="text"></li>
                        <li><label for="reg_address_apartment">Квартира №: </label><input name="reg_address_apartment" class="form_input" placeholder="Пример: 12" id="reg_address_apartment" type="text"></li>
                        <li><label for="reg_password">Пароль: <span class="red_star">*</span></label><input name="password" class="form_input" id="reg_password" type="password" required=""></li>
                        <li><div id="reg_errors"></div></li>
                    </ul>
                </div>
                <div class="form_buttons">
                    <a  class="reg_close_button">Назад</a>
                    <button type="submit" class="button">Регистрация</button>
                </div>
            </form>
        </div>
    </div>


    <header class="header">
        <div class="header_container">
            <button id="menu_button_id" class="menu_button"><img id="menu_button_img" src="/public/images/Hamburger_icon.svg.png"></button>
            <button id="back"><a href="/"><img id="back_img" src="/public/images/16116.png"></a></button>
            <a  id="logo_link" class="logo_link" href="<?php echo shop_link()?>">

                <img alt="" class="logo" src="<?php echo shop_logo() ?>">
                <div class="header_name"><?php echo shop_name() ?></div>
            </a>

            <?php if ($_SERVER['REQUEST_URI'] === '/catalog' or $_SERVER['REQUEST_URI'] === '/') :?>
                <div id="search_container">
                    <img id="search_icon" src="/public/images/kisspng-computer-icons-search-box-web-search-engine-clip-a-identify-5ad8df581a0957.1355996515241623921067.png">
                    <form  action="view" method="post" class="search_form">
                        <input name="search_string" id="search_input_box" type="text" >
                    </form>
                    <button type="submit" id="search_button">Поиск</button>
                </div>
            <?php endif;?>
            <div class="top_buttons">
                <?php if ($_SERVER['REQUEST_URI'] !== '/account/cart'):?>
                    <?php if (isset($_SESSION['account'])):?>
                        <?php if($vars['amount_in_cart'] > 9):?>
                            <a class="cart_button" href="/account/cart" id="cart_button" > <img alt="" src="/public/images/cart/cart_10.png"></a>
                        <?php else:?>
                            <a class="cart_button" href="/account/cart" id="cart_button" > <img alt="" src="/public/images/cart/cart_<?php echo $vars['amount_in_cart']?>.png"></a>
                        <?php endif; ?>
                    <?php else:?>
                        <?php if($vars['amount_in_cart'] > 9):?>
                            <a class="cart_button" href="/cart" id="cart_button" > <img alt="" src="/public/images/cart/cart_10.png"></a>
                        <?php else:?>
                            <a class="cart_button" href="/cart" id="cart_button" > <img alt="" src="/public/images/cart/cart_<?php echo $vars['amount_in_cart']?>.png"></a>
                        <?php endif;?>
                    <?php endif;?>
                <?php endif;?>
                <?php if (isset($_SESSION['account']['id'])): ?>
                    <?php if ($_SERVER['REQUEST_URI'] === '/account/profile' or $_SERVER['REQUEST_URI'] === '/account/buylist'  or $_SERVER['REQUEST_URI'] === '/account/wishlist' or $_SERVER['REQUEST_URI'] === '/account/cart' or $_SERVER['REQUEST_URI'] === '/account/waitlist'){

                    }
                    else {
                        echo '<a class="header_left_button" id="profile_button" href="/account/profile  ">Профиль</a>';
                    }?>
                    <a class="red_button"  id="logout_button" href="/logout">Выход</a>

                <?php else: ?>
                    <a class="header_left_button" id="registration_button" >Регистрация</a>
                    <!--            href="http://oooop/account/register  "-->
                    <a class="header_left_button"  id="login_button" >Вход</a>
                    <!--            href="http://oooop/account/login"-->
                <?php endif; ?>

            </div>
        </div>






        <div id="profile_list_container">
            <ul  id="profile_list">
                <li id="profile-button"><a href="/account/profile">Профиль<img alt="" class="next" src="/public/images/next.png"></a></li>
                <li id="buy-button"><a href="/account/buylist">Мои покупки<img alt="" class="next" src="/public/images/next.png"></a></li>
                <li id="wait-button"><a href="/account/waitlist">Список ожидания<img alt="" class="next" src="/public/images/next.png"></a></li>
                <li id="cart-button"><a href="/account/cart">Корзина<img alt="" class="next" src="/public/images/next.png"></a></li>
            </ul>
        </div>
    </header><!-- .header-->
    <div class="middle">







        <?php echo $content; ?>
    </div><!-- .middle-->
</div><!-- .wrapper -->
<footer class="footer">
    <div id="footer_links">
        <ul>
            <li><a href="#">Обратная связь</a></li>
            <li><a href="#">О нас</a></li>
        </ul>
    </div>
    <a class="logo_link_footer" href="<?php echo shop_link()?>">
        <img alt="" class="logo" src="<?php echo shop_logo() ?>">
        <div class="header_name"><?php echo shop_name() ?></div>
    </a>
    <div>
        © 2019
    </div>
</footer>
</body>
</html>