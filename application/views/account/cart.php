
<link rel="stylesheet" href="/public/styles/select2.min.css" />
<script src="/public/scripts/select2.min.js"></script>
<link rel="stylesheet" href="/public/styles/profile_adaptivity.css">
<script src="/public/scripts/profile_adaptivity.js"></script>
<div class="container">

    <div id="cart_form" class="form_container">
        <div class="block">
            <form action="/account/send" id="registered_cart_form" method="post" class="form_style">
                <h2>Оформление заказа</h2>
                <div id="container_flex_cart_box">
                <div  class="form_style" id="left_cart_block">
                    <ul>
                        <input style="display: none" name="amount_price"  class="form_input" value="<?php echo $vars['amount'];?>" id="amount_price_invisible" type="text" required="">
                        <input style="display: none" name="id_user"  class="form_input" value="<?php echo $vars['user']['id'];?>" id="id_user" type="text" required="">
                        <input style="display: none" name="products"  class="form_input" value="<?php foreach ($vars['products'] as $product){echo $product[0]['product_name'].', ';};?>" id="products" type="text" required="">
                        <li><label for="first_name">Имя: </label><input  name="first_name" class="form_input" value="<?php echo $vars['user']['first_name'];?>" id="first_name" type="text" required=""></li>
                        <li><label for="last_name">Фамилия: </label><input name="last_name"  class="form_input" value="<?php echo $vars['user']['last_name'];?>" id="last_name" type="text" required=""></li>
                        <li><label for="phone_number">Номер телефона: </label><input name="phone_number"  class="form_input" value="<?php echo $vars['user']['phone'];?>" id="phone_number" type="text" required=""></li>
                        <li class="label_city_input"><label for="city_select">Город: </label><div id="city_cont"><input autocomplete="off" class="form_input" url="/account/cURL" name="city_addr" type="text" id="city_select" list="city"><div id="city"></div></div></li>
                        <li><label for="post_addr">Отделение: </label><select url="/account/pURL" name="address_post_department" id="post_addr"></select></li>
                        <!--
 <li><label for="city_addr">Город</label>-->
<!--                            --><?php
//                            ksort($vars['cities']);
//                            echo '<select  name="city_addr" id="city_addr" >';
//                            foreach($vars['cities'] as $post){
//                                if ($post == $vars['user']['city']){
//                                    echo '<option selected value="'. $post . '">'. $post . '</option> ' , "\r\n";
//                                }
//                                else {
//                                    echo '<option value="'. $post . '">'. $post . '</option> ' , "\r\n";
//                                }
//                            }
//                            echo '</select>';
//                            ?>
<!---->
<!--                        </li>-->
<!--                        <li id="address_post_department"><label for="address_post_department">Адрес отдела "Новой почты":</label>-->
<!--                            --><?php
//                            ksort($vars['posts']);
//                            echo '<select name=" address_post_department" id="post_addr" class="livesearch" >';
//                            foreach($vars['posts'] as $post){
//                                echo '<option value="'. $post . '">'. $post . '</option> ' , "\r\n";
//                            }
//                            echo '</select>';
//                            ?>
<!---->
<!--                        </li>-->
                        <li><label for="payment">Тип оплаты: </label><select name="payment"  class="form_input" id="payment" required="">
                                <option value="Наложенный платёж">Наложенный платёж</option>
                            </select></li>
                        <p class="help-block"></p>
                    </ul>
                </div>
                <div id="right_cart_block" >
                    <div id="cart_products_block">
                <?php
                $i = 1;
                foreach ($vars['products'] as $product){
                    $name = $product[0]['product_name'];
                    echo '<div class="product_container_form">';
                    echo '<div class="product_amount"><button class="plus_button" type="button">+</button ><input name="'.translit($name).'" value="1" placeholder="1" class="amount_input" readonly><button class="minus_button" type="button">-</button></div>';
                    echo '<div class="product_image_form"><a href="'.shop_link().'/product/'.translit($name).'/'.$product[0]['product_category_id'].'/'.$product[0]['id_product'].'"><img class="p_m_form" alt="" src="/public/images/products_images/'.$product[0]['product_image'].'"></a> </div>';
                    echo '<div class="product_name_form"><a href="'.shop_link().'/product/'.translit($name).'/'.$product[0]['product_category_id'].'/'.$product[0]['id_product'].'">'.$name.'</a> </div>';
                    echo '<div class="price_button_container_form">';
                    echo'<div class="product_price_form" price = "'.$product[0]['product_price'].'">'.$product[0]['product_price'].' </div><span class="currency">грн</span>';
                    echo'</div>';
                    echo '</div>';
                    echo '<input style="display: none" name="product_'.$i.'" value="'.$name.'">';
                    $i = $i + $i;
                }
                ?>

                    </div>


                </div>

                </div>
                <div class="form_bottom_buttons">
                <div id="amount_block"><div id="amount_name">Сумма:  </div><div id="amount_number">&nbsp; <?php echo $vars['amount']?> Грн</div></div>
                <div class="form_buttons">
                    <a  class="close_button">Назад</a>
                    <button type="submit" class="button">Подтвердить</button>
                </div>
                </div>
            </form>
        </div>
    </div>

    <div class="loader">
        <img alt="" src="/public/images/cart/Rolling-0.8s-221px.svg">
    </div>
    <main class="content">
        <div id="cart_list_info">
            <h1 id="header_cart">Товары в корзине: </h1>

        </div>
        <div>
            <div class="cat_container">
            <?php
            foreach ($vars['products'] as $product){
                $name = $product[0]['product_name'];
                echo '<div class="product_container">';
                echo '<div class="product_image"><a href="'.shop_link().'/product/'.translit($name).'/'.$product[0]['product_category_id'].'/'.$product[0]['id_product'].'"><img class="p_m" alt="" src="/public/images/products_images/'.$product[0]['product_image'].'"></a> </div>';
                echo '<div class="product_name"><a href="'.shop_link().'/product/'.translit($name).'/'.$product[0]['product_category_id'].'/'.$product[0]['id_product'].'">'.$name.'</a> </div>';
                echo '<div class="price_button_container">';
                echo'<div class="product_price">'.$product[0]['product_price'].' грн</div>';
                echo'<div class="product_buy_button"><a value="'.$product[0]['id_product'].'" category="'.$product[0]['product_category_id'].'" id="'.$product[0]['id_product'].'" class="del_from_cart_registered delete_session_cart"><img class="buy_cart" src="/public/images/cart/cart_del.png"></a></div>';
                echo'</div>';
                echo '<div class="product_characteristics">'.$product[0]['product_description'].'</div>';
                echo '</div>';
            }
            ?>

            </div>

        </div>
    </main><!-- .content -->
</div><!-- .container-->

<aside id="side"  class="left-sidebar">
    <ul  id="left-profile-sidebar">
        <li id="profile-left-button"><a href="profile">Профиль</a></li>
        <li id="buy-left-button"><a href="buylist">Мои покупки</a></li>
        <li id="wait-left-button"><a href="waitlist">Список ожидания</a></li>
        <li id="cart-left-button"><a href="cart">Корзина</a></li>
    </ul>
    <div id="fixed_button_container">

        <div id="summ_plus_button_container">
        <div id="summ_container">
            <div id="amount_button_name">
                Сума:
            </div>
            <div id="amount_button_number">
                &nbsp; <?php echo $vars['amount']?> грн
            </div>
        </div>
        <button id="zakaz_button">
            Оформить заказ
        </button>
        </div>
    </div>
</aside><!-- .left-sidebar -->

<script>
    $("#city_addr").select2( {
        placeholder: "Виберите город",
        allowClear: true
    } );
</script>