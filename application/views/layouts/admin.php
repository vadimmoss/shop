<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo $title ?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
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
    <div id="add_form" class="form_container">
        <div class="block">
            <form id="admin_form" action="/admin/category"  method="post" class="form_style">
                <h2>Добавление категoрии</h2>
                <ul>
                    <li><label for="name_add">Имя: </label><input  name="name_add" class="form_input" id="name_add" type="text" required=""></li>
                    <li><label for="img_add">Изображение категории: </label><input  name="img_add" class="form_input" id="img_add" type="file" required=""></li>
                    <li><label for="count_classes_chars">Количество класов характеристик: </label><input name="count_classes_chars"  class="form_input" id="count_classes_chars" type="number" required=""></li>
                    <li>
                        <ul id="classes_chars">

                        </ul>
                    </li>

                    <p class="help-block"></p>
                </ul>
                <div class="form_buttons">
                    <a  class="admin_close_button">Назад</a>
                    <button type="submit" class="button">Добавить</button>
                </div>
            </form>
        </div>
    </div>








    <header class="header">
        <div class="header_container">
            <a class="logo_link" href="/admin/catalog"><img alt="" class="logo" src="/public/images/Wikimedia-logo.png">
                <div class="header_name">Magazin</div></a>
            <div class="top_buttons">
            <?php if (isset($_SESSION['admin'])): ?>
                <?php if ($_SERVER['REQUEST_URI'] === '/account/profile' or $_SERVER['REQUEST_URI'] === '/account/buylist'  or $_SERVER['REQUEST_URI'] === '/account/wishlist' or $_SERVER['REQUEST_URI'] === '/account/cart' or $_SERVER['REQUEST_URI'] === '/account/waitlist'){

                }
                else {
                    echo '<a class="header_left_button" id="profile_button" href="/admin/panel  ">Профиль</a>';
                }?>
                <a class="red_button"  id="login_button" href="http:/admin/logout">Выход</a>
            <?php else: ?>
                <a class="header_left_button" id="registration_button" href="/account/register  ">Регистрация</a>
                <a class="header_left_button"  id="login_button" href="/account/login">Вход</a>
            <?php endif; ?>
            </div>
        </div>




        <div id="profile_list_container">
            <ul  id="profile_list">
                <li id="profile-button"><a href="/admin/panel">Панель администратора<img alt="" class="next" src="/public/images/next.png"></a></li>
                <li id="profile-button"><a href="/admin/catalog">Панель продуктов<img alt="" class="next" src="/public/images/next.png"></a></li>
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
    <a class="logo_link_footer" href="<?php echo shop_link() ?>">
        <img alt="" class="logo" src="<?php echo shop_logo() ?>">
        <div class="header_name"><?php echo shop_name() ?></div>
    </a>
    <div>
        © 2019
    </div>
</footer>
</body>
</html>