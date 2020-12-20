<?php
$ipUser = $_SERVER['REMOTE_ADDR'];
$ips = return_ip();
if(!in_array($ipUser, $ips)){
    die('Страница 404');
}
?>
<style>
    .middle { background-image: url("/public/images/Lovepik_com-401428794-triangle-geometric-colorful-background.png");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center}
</style>
<div id="admin_login_form" class="form_container">
    <div class="block">
        <form action="/admin/login" method="post" class="form_style">
            <h2>Вход</h2>
            <ul>
                <li><label for="login_login">Логін: </label><input  name="login" class="form_input" id="login_login" type="text" required=""></li>
                <li><label for="login_password">Пароль: </label><input name="password"  class="form_input" id="login_password" type="password" required=""></li>
                <p class="help-block"></p>
            </ul>
            <button type="submit" class="button">Вход</button>
            <a href="/catalog" class="close_button">Назад</a>
        </form>
    </div>
</div>