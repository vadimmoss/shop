<link rel="stylesheet" href="/public/styles/profile_adaptivity.css">
<script src="/public/scripts/profile_adaptivity.js"></script>
<div class="container">
    <main class="content">
        <div id="settings_profile_container"><a id="settings_button"><img alt="" title="Настройки профиля" id="settings_profile" src="/public/images/185095.png"></a></div>
        <div id="profile_list_info">
            <div id="user_img_block">
                <div id="user_img_contaimer"><img alt="" id="user_image" src="/public/images/user.png"></div>
            </div>
        <table id="user_info">
            <tr>
                <td>Логин: </td>
                <td><?php echo $vars['login'];?></td>
            </tr>
            <tr>
                <td>E-mail: </td>
                <td><?php echo $vars['email'];?></td>
            </tr>
            <tr>
                <td>Номер телефона: </td>
                <td><?php echo $vars['phone'];?></td>
            </tr>
            <tr>
                <td>Город: </td>
                <td><?php echo $vars['address'];?></td>
            </tr>
            <tr>
                <td>Пол: </td>
                <td>Мужской</td>
            </tr>
        </table>
        </div>
    </main><!-- .content -->
</div><!-- .container-->

<aside id="side" class="left-sidebar">
    <ul  id="left-profile-sidebar">
        <li id="profile-left-button"><a href="profile">Профиль</a></li>
        <li id="buy-left-button"><a href="buylist">Мои покупки</a></li>
        <li id="wait-left-button"><a href="waitlist">Список ожидания</a></li>
        <li id="cart-left-button"><a href="cart">Корзина</a></li>
    </ul>
</aside><!-- .left-sidebar -->

