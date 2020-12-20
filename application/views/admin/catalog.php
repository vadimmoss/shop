<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/public/styles/admin_adaptivity.css">
<div id="add_chars_form" class="form_container">
    <div class="block">
        <form id="add_chars_form_id" action="/admin/characteristic" method="post" class="form_style">
            <h2>Добавление характеристик</h2>
            <ul>
                <li><label for="new_char_parent_cat">Категория: </label>
                    <select class="form_input" name="new_char_parent_cat" id="new_char_parent_cat">
                        <?php
                        $arr = $vars['full_categories'];
                        foreach($arr as $category)
                        {
                            echo '<option value="'.$category['id_category'].'">'.$category['name'].'</option>';
                        }
                        ?>
                    </select></li>
                <li id="li_classes"><label for="new_parent_name">Клас характеристик: </label>
                    <select class="form_input" name="new_parent_name" id="new_parent_name">
                        <?php
                        $arr = $vars['full_classes'];
                        foreach($arr as $row)
                        {
                            echo '<option value="'.$row['id_har'].'">'.$row['name_haracter'].'</option>';
                        }
                        ?>
                    </select>
                </li>
                <li><label for="count_chars">Количество характеристик: </label><input name="count_chars"  class="form_input" id="count_chars" type="number" required=""></li>
                <li>
                    <ul id="chars">

                    </ul>
                </li>
            </ul>
            <div class="form_buttons">
                <a  class="admin_close_button">Назад</a>
                <button type="submit" class="button">Добавить</button>
            </div>
        </form>
    </div>
</div>


<div id="add_type_form" class="form_container">
    <div class="block">
        <form id="add_type_form_id" action="/admin/type" method="post" class="form_style">
            <h2>Добавление типов категории</h2>
            <ul>
                <li><label for="new_type_parent_cat">Категория: </label>
                    <select class="form_input" name="new_type_parent_cat" id="new_type_parent_cat">
                        <?php
                        $arr = $vars['full_categories'];
                        foreach($arr as $category)
                        {
                            echo '<option value="'.$category['id_category'].'">'.$category['name'].'</option>';
                        }
                        ?>
                    </select></li>

                <li><label for="type_name">Название типа: </label><input name="type_name"  class="form_input" id="type_name" type="text" required=""></li>
                <li><label for="type_img">Изображение типа: </label><input name="type_img"  class="form_input" id="type_img" type="file" required=""></li>
            </ul>
            <div class="form_buttons">
                <a  class="admin_close_button">Назад</a>
                <button type="submit" class="button">Добавить</button>
            </div>
        </form>
    </div>
</div>

<div id="add_product_form" class="form_container">
    <div class="block">
        <div class="form_x">
            <form id="add_product" action="/admin/add" method="post" class="form_style add_p">
                <h2>Добавление продукта</h2>
                <ul>
                    <li><label for="new_product_parent_cat">Категория: </label>
                        <select class="form_input" name="new_product_parent_cat" id="new_product_parent_cat">
                            <?php
                            $arr = $vars['full_categories'];
                            foreach($arr as $category)
                            {
                                echo '<option value="'.$category['id_category'].'">'.transliterate($category['name']).'</option>';
                            }
                            ?>
                        </select>
                    </li>
                    <li><label for="add_product_name">Названаие продукта</label><textarea class="form_input" name="add_product_name" id="add_product_name" ></textarea> </li>
                    <li><label for="add_product_description">Описание продукта</label><textarea class="form_input" name="add_product_description" id="add_product_description" ></textarea> </li>
                    <li>Тип продукта
                        <ul id="type_of_product">
                        <?php
                        $arr = $vars['types'];
                        $i = 0;
                        foreach($arr as $type)
                        {
                            echo '<li><a><label class="control control-checkbox"><input name="type_'.$i.'" value="'.$type['id_type_of_category'].'" type="checkbox"> '.$type['name_type_of_category'].'<div class="control_indicator"></div></label></a></li>';
                            $i = $i + 1;
                        }
                        echo '<input type="hidden" value="'.$i.'" name="amount_types">'
                        ?>
                        </ul>
                    </li>
                    <li id="xxx">
                        <ul id="yyy">
                            <div>
                                <?php if (isset($vars['categories_by_char'])){
                                    $arr = $vars['categories_by_char'];
                                    foreach ($arr as $category => $hars) {
                                        echo '<li>';
                                        if (is_array($hars) || is_object($hars)) {
                                            foreach ($hars as $har => $chars) {
                                                echo '<ul  > ' . $har ;
                                                if (is_array($chars) || is_object($chars)) {
                                                    foreach ($chars as $char) {
                                                        echo '<li><a><label class="control control-checkbox"><input name="'.transliterate($har).'" value="' . $char['id_type'] . '"  type="checkbox"> ' . $char['harac'] . ' <div class="control_indicator"></div></a></label></li>';
                                                    }
                                                }
                                                echo '</ul>';
                                            }
                                        }


                                        echo '</li>';

                                    }
                                } ?>
                            </div>

                        </ul>
                    </li>
                    <li><label for="add_price">Цена:</label> <input name="add_price" id="add_price" class="form_input" type="number"></li>
                    <li><label for="add_image1">Изображение :</label> <input name="add_image1" id="add_image1" class="form_input" type="file"></li>
                    <li><label for="add_image2">Изображение 2 :</label> <input name="add_image2" id="add_image2" class="form_input" type="file"></li>
                    <li><label for="add_image3">Изображение 3 :</label> <input name="add_image3" id="add_image3" class="form_input" type="file"></li>
                    <li><label for="add_image4">Изображение 4 :</label> <input name="add_image4" id="add_image4" class="form_input" type="file"></li>
                </ul>
                <div class="form_buttons">
                    <a  class="admin_close_button">Назад</a>
                    <button type="submit" class="button">Добавить</button>
                </div>
            </form>
        </div>

    </div>
</div>



<div id="add_class_form" class="form_container">
    <div class="block">
        <form id="add_class_form_id" action="/admin/class" method="post" class="form_style">
            <h2>Добавление класса категории</h2>
            <ul>
                <li><label for="category_class">Категория: </label>
                    <select class="form_input" name="category_class" id="category_class">
                        <?php
                        $arr = $vars['full_categories'];
                        foreach($arr as $category)
                        {
                            echo '<option value="'.$category['id_category'].'">'.$category['name'].'</option>';
                        }
                        ?>
                    </select>
                </li>
                <li><label for="count_category_class">Количество класов: </label><input name="count_category_class"  class="form_input" id="count_category_class" type="number" required=""></li>
                <li>
                    <ul id="classes_category">

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




<div class="container">
    <div class="load_gif">
        <img src="/public/images/Magnify-1s-200px.gif">
    </div>
    <!--    <script src="/public/scripts/catalogScripts.js"></script>-->
    <main class="content">
        <div class="cat_container">
            <?php
            foreach ($vars['catalog'] as $product){

                $name = $product['product_name'];
                echo '<div class="product_container">';
                echo '<div class="product_image"><a href="/product/'.translit($name).'/'.$product['product_category_id'].'/'.$product['id_product'].'"><img class="p_m" alt="" src="/public/images/products_images/'.$product['product_image'].'"></a> </div>';
                echo '<div class="product_name"><a href="/product/'.translit($name).'/'.$product['product_category_id'].'/'.$product['id_product'].'">'.$name.'</a> </div>';
                echo '<div class="price_button_container">';
                echo'<div class="product_price"><span class="price_number">'.$product['product_price'].' </span><span class="currency"> грн</span></div>';
                echo'</div>';
                echo '<div class="product_characteristics">'.$product['product_description'].'</div>';
                echo '</div>';
            }
            ?>

        </div>

    </main><!-- .content -->
</div><!-- .container-->
<script src="/public/scripts/slider/distribute/nouislider.js"></script>
<link rel="stylesheet" href="/public/scripts/slider/distribute/nouislider.css" >
<aside id="side" class="left-sidebar">
    <form id="qqq">
        <ul  id="left-categories">


            <?php
            //<input  name="max-price" type="text" class="max-price" value="'.$vars['max-price']['MAX(product_price)'].'" >
            //                        <input name="min-price" value="0" type="text" class="min-price"  >
            $arr = $vars['categories'];
            foreach ($arr as $category => $hars) {
                echo '<li class="slide-li"><div id="'.transliterate($category).'" style="display: inline-block"><a  class="cat_image" id="'.transliterate($category).'" href="#category='.translit($category).'">' . $category . '<span class=" info_admin">(катег.)</span></div><img alt="" class="img-cat" src="/public/images/PinClipart.com_salamander-clip-art_2150988.png">';
                echo '</a  >';
                if (is_array($hars) || is_object($hars)) {
                    foreach ($hars as $har => $chars) {
                        echo '<ul  style="display: none;" > ' . $har . '<span class=" info_admin">(класс хар.)</span>';
                        if (is_array($chars) || is_object($chars)) {
                            foreach ($chars as $char) {
                                echo '<li class="char" style="display: block"><a id="'.transliterate($category).'"  class="characteristics"><label class="control control-checkbox"><input  name="'.transliterate($har).'" value="' . $char['id_type'] . '"  type="checkbox"> ' . $char['harac'] . ' <span class=" info_admin">(хар.)</span><div class="control_indicator"></div></a></label></li>';
                            }
                        }
                        echo '</ul>';
                    }
                }


                echo '</li>';

            }
            echo '<ul class="price_ul">
                    <div id="price_name">Цена:</div> 
                    <div id="price_slider" >
                    <div id="inputs">
                    <input readonly name="min-price" min="0" value="0" type="text" class="min-price" size="3"  maxlength="6" onkeydown="size=value.length||10" onkeyup="onkeydown()" onkeypress="onkeydown()" onchange="onkeydown()"/> грн
                    <input readonly name="max-price" type="text" value="'.$vars['max-price']['MAX(product_price)'].'"   class="max-price" size="3"  maxlength="6" onkeydown="size=value.length||10" onkeyup="onkeydown()" onkeypress="onkeydown()" onchange="onkeydown()"/> грн
                    </div>
                    <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
                    <button class="submit-price">Поиск</button>
                    </div>
                  </ul>';
            ?>

            <li id="add_new_category">+ Добавить категории</li>
            <li id="add_new_class">+ Добавить клас характеристик</li>
            <li id="add_new_chars">+ Добавить характеристики</li>
            <li id="add_new_type">+ Добавить типы категории (в меню)</li>
            <li id="add_new_product">+ Добавить продукт</li>

            <script>
                $(".price_ul").draggable();
                $("#slider-range").slider({
                    range: true,
                    orientation: "horizontal",
                    min: 0,
                    max: <?php echo $vars['max-price']['MAX(product_price)']?>,
                    values: [0, <?php echo $vars['max-price']['MAX(product_price)']?>],
                    step: 100,
                    slide: function (event, ui) {
                        if (ui.values[0] == ui.values[1]) {
                            return false;
                        }
                        $(".min-price").val(ui.values[0]);
                        $(".max-price").val(ui.values[1]);
                    }
                });
            </script>
        </ul>
    </form>
</aside><!-- .left-sidebar -->





















<!--<div id="add_chars_form" class="form_container">-->
<!--    <div class="block">-->
<!--        <form action="/admin/characteristic" method="post" class="form_style">-->
<!--            <h2>Добавление характеристик</h2>-->
<!--            <ul>-->
<!--                <li><label for="new_char_parent_cat">Категория: </label>-->
<!--                    <select class="form_input" name="new_char_parent_cat" id="new_char_parent_cat">-->
<!--                                                    --><?php
//                                                    $arr = $vars['full_categories'];
//                                                    foreach($arr as $category)
//                                                    {
//                                                        echo '<option value="'.$category['id_category'].'">'.$category['name'].'</option>';
//                                                    }
//                                                    ?>
<!--                    </select></li>-->
<!--                <li id="li_chars"><label for="new_parent_name">Клас характеристик: </label>-->
<!--                    <select class="form_input" name="new_parent_name" id="new_parent_name">-->
<!--                                                    --><?php
//                                                    $arr = $vars['full_classes'];
//                                                    foreach($arr as $row)
//                                                    {
//                                                        echo '<option value="'.$row['id_har'].'">'.$row['name_haracter'].'</option>';
//                                                    }
//                                                    ?>
<!--                    </select>-->
<!--                </li>-->
<!--                <li><label for="count_chars">Количество характеристик: </label><input name="count_chars"  class="form_input" id="count_chars" type="number" required=""></li>-->
<!--                <li>-->
<!--                    <ul id="chars">-->
<!---->
<!--                    </ul>-->
<!--                </li>-->
<!--            </ul>-->
<!--            <button type="submit" class="button">Добавить</button>-->
<!--            <a  class="admin_close_button">Назад</a>-->
<!--        </form>-->
<!--    </div>-->
<!--</div>-->




