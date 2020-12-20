
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/public/styles/main_adaptivity.css">
<link rel="stylesheet" href="/public/styles/select2.min.css" />
<script src="/public/scripts/select2.min.js"></script>
<link rel="stylesheet" href="/public/styles/cart_unregistered.css">
<script src="/public/scripts/cart_unregistered_adaptivity.js"></script>

<div class="container">
    <div id="cart_form" class="form_container">
        <div class="block">
            <form action="/cart/send" id="unregistered_cart_form" method="post" class="form_style">
                <h2>Оформление заказа</h2>
                <div id="container_flex_cart_box">
                    <div  class="form_style" id="left_cart_block">
                        <ul>
                            <input style="display: none" name="amount_price"  class="form_input" value="<?php
                            if (isset($vars['amount_price'])){
                                echo $vars['amount_price'];
                            }
                            ?>" id="amount_price_invisible" type="text" required="">
                            <input style="display: none" name="products"  class="form_input" value="<?php
                            if(isset($vars['cart'][0]) ){
                                if($vars['cart'][0]=== 'nothing'){

                                }
                                else{
                                    foreach ($vars['cart'] as $product){
                                        $name = $product[0]['product_name'];
                                        echo $name.', ';
                                    }
                                }
                            }


                            ?>" id="products" type="text" required="">
                            <li><label for="first_name">Имя: </label><input  name="first_name" class="form_input" value="" id="first_name" type="text" required=""></li>
                            <li><label for="last_name">Фамилия: </label><input name="last_name"  class="form_input" value="" id="last_name" type="text" required=""></li>
                            <li><label for="phone_number">Номер телефона: </label><input placeholder="Пример: +380666666666"  name="phone_number"  class="form_input" value="" id="phone_number" type="text" required=""></li>
                            <li class="label_city_input"><label for="city_select">Город: </label><div id="city_cont"><input autocomplete="off" class="form_input" url="/cart/cURL" name="city_addr" type="text" id="city_select" list="city"><div id="city"></div></div></li>
                            <li><label for="post_addr">Отделение: </label><select url="/cart/pURL" name="address_post_department" id="post_addr"></select></li>
                            <!--
<li><label for="city_addr">Город</label>-->
<!--                                --><?php
//                                ksort($vars['cities']);
//                                echo '<select  name="city_addr" id="city_addr_unregistered" >';
//                                foreach($vars['cities'] as $post){
//                                    if ($post == $vars['user']['city']){
//                                        echo '<option selected value="'. $post . '">'. $post . '</option> ' , "\r\n";
//                                    }
//                                    else {
//                                        echo '<option value="'. $post . '">'. $post . '</option> ' , "\r\n";
//                                    }
//                                }
//                                echo '</select>';
//                                ?>
<!---->
<!--                            </li>-->
<!--                            <li id="address_post_department_unregistered"><label for="address_post_department_unregistered">Адрес отдела "Новой почты":</label>-->
<!--                                --><?php
//                                ksort($vars['posts']);
//                                echo '<select name=" address_post_department" id="post_addr" class="livesearch" >';
//                                foreach($vars['posts'] as $post){
//                                    echo '<option value="'. $post . '">'. $post . '</option> ' , "\r\n";
//                                }
//                                echo '</select>';
//                                ?>
<!---->
<!--                            </li>-->
                            <li><label for="payment">Тип оплаты: </label><select name="payment"  class="form_input" id="payment" required="">
                                    <option value="Наложенный платёж">Наложенный платёж</option>
                                </select></li>
                            <p class="help-block"></p>
                        </ul>
                    </div>
                    <div id="right_cart_block" >
                        <div id="cart_products_block">
                            <?php

                            if (isset($vars['cart'][0])){
                                if ($vars['cart'][0] != 'nothing'){
                                    $i = 1;
                                    foreach ($vars['cart'] as $product){
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
                                }
                            }
                            else{
                                echo '<div class="cart_is_empty"><span>Корзина пуста</span></div>';



                            }


                            ?>

                        </div>



                </div>

                </div>
                <div class="form_bottom_buttons">
                    <div id="amount_block"><div id="amount_name">Сумма: &nbsp;</div><div id="amount_number"> <?php if (isset($vars['amount_price'])){
                                echo $vars['amount_price'];
                            } ?> </div><span class="currency">Грн</span></div>
                </div>
                <div class="form_buttons">
                    <a  class="close_button">Назад</a>
                    <button type="submit" class="button">Подтвердить</button>

                </div>
            </form>
        </div>
    </div>

    <div class="loader">
        <img alt="" src="/public/images/cart/Rolling-0.8s-221px.svg">
    </div>
    <main  class="content" style="margin: 0 0 0 0;">
        <div id="cart_list_info">
            <h3 id="header_cart">Товары в корзине: </h3>

        </div>
        <div>

            <div class="cat_container">
                <?php
                if(isset($vars['cart'][0]) ){
                    if($vars['cart'][0]=== 'nothing'){

                    }
                    else{
                        foreach ($vars['cart'] as $product){
                            $name = $product[0]['product_name'];
                            $product= $product[0];
                            echo '<div class="product_container">';
                            echo '<div class="product_image"><a href="/product/'.translit($name).'/'.$product['product_category_id'].'/'.$product['id_product'].'"><img class="p_m" alt="" src="/public/images/products_images/'.$product['product_image'].'"></a> </div>';
                            echo '<div class="product_name"><a href="/product/'.translit($name).'/'.$product['product_category_id'].'/'.$product['id_product'].'">'.$name.'</a> </div>';
                            echo '<div class="price_button_container">';
                            echo'<div class="product_price">'.$product['product_price'].' грн</div>';
                            echo'<div class="product_buy_button"><a class="del_button delete_session_cart" title="Удалить из корзины" category="'.$product['product_category_id'].'" id="'.$product['id_product'].'"><img class="buy_cart" src="/public/images/cart/cart_del.png"></a></div>';
                            echo'</div>';
                            echo '<div class="product_characteristics">'.$product['product_description'].'</div>';
                            echo '</div>';
                        }
                    }
                }


                ?>

            </div>

        </div>
    </main><!-- .content -->
</div><!-- .container-->


    <div id="fixed_button_container">

        <div id="summ_plus_button_container">
            <div id="summ_container">
                <div id="amount_button_name">
                    Сума:  
                </div>
                <div id="amount_button_number">
                     <?php
                     if (isset($vars['amount_price'])){
                         echo $vars['amount_price'];
                     }
                        else {
                            echo '0';
                        }
                     ?>  грн
                </div>
            </div>
            <button id="zakaz_button">
                Оформить заказ
            </button>
        </div>
    </div>


<script>
    $("#city_addr_unregistered").select2( {
        placeholder: "Виберите город",
        allowClear: true
    } );
</script>


