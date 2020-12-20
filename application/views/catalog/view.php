<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>






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
                echo '<div class="product_image"><a href="/product/'.translit($name).'/'.$product['product_category_id'].'/'.$product['id_product'].'"><img class="p_m" alt="" src="/public/images/'.$product['product_image'].'"></a> </div>';
                echo '<div class="product_name"><a href="/product/'.translit($name).'/'.$product['product_category_id'].'/'.$product['id_product'].'">'.$name.'</a> </div>';
                echo '<div class="price_button_container">';
                echo'<div class="product_price">'.$product['product_price'].' грн</div>';
                echo'<div class="product_buy_button"><a class="buy_button">Купить</a></div>';
                echo'</div>';
                echo '<div class="product_characteristics">'.$product['product_description'].'</div>';
                echo '</div>';
            }
            ?>
        </div>

    </main>
</div>

<!------ Include the above in your HEAD tag ---------->
<script src="/public/scripts/slider/distribute/nouislider.js"></script>
<link rel="stylesheet" href="/public/scripts/slider/distribute/nouislider.css" >


<aside id="side"  class="left-sidebar">

    <form id="qqq">
        <ul  id="left-categories">


            <?php
            //<input  name="max-price" type="text" class="max-price" value="'.$vars['max-price']['MAX(product_price)'].'" >
            //                        <input name="min-price" value="0" type="text" class="min-price"  >
            $arr = $vars['categories'];
            echo '<ul class="price_ul">
                    <div id="price_name">Цена:</div> 
                    <div id="price_slider" >
                    <div id="inputs">
                    <input readonly name="min-price" min="0" value="0" type="text" class="min-price" size="2"  maxlength="6" onkeydown="size=value.length||10" onkeyup="onkeydown()" onkeypress="onkeydown()" onchange="onkeydown()"/> грн
                    <input readonly name="max-price" type="text" value="'.$vars['max-price']['MAX(product_price)'].'"   class="max-price" size="2"  maxlength="6" onkeydown="size=value.length||10" onkeyup="onkeydown()" onkeypress="onkeydown()" onchange="onkeydown()"/> грн
                    </div>
                    <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
                    <button class="submit-price">Поиск</button>
                    </div>
                  </ul>';
            foreach ($arr as $category => $hars) {
                echo '<li class="slide-li"><div style="display: inline-block"><a  class="cat_image" id="'.transliterate($category).'" href="#category='.translit($category).'">' . $category . '</div><img alt="" class="img-cat" src="/public/images/PinClipart.com_salamander-clip-art_2150988.png">';
                echo '</a  >';
                if (is_array($hars) || is_object($hars)) {
                    foreach ($hars as $har => $chars) {
                        echo '<ul  style="display: none;" > ' . $har ;
                        if (is_array($chars) || is_object($chars)) {
                            foreach ($chars as $char) {
                                echo '<li class="char" style="display: block"><a id="'.transliterate($category).'"  class="characteristics"><label class="control control-checkbox"><input  name="'.transliterate($har).'" value="' . $char['id_type'] . '"  type="checkbox"> ' . $char['harac'] . ' <div class="control_indicator"></div></a></label></li>';
                            }
                        }
                        echo '</ul>';
                    }
                }


                echo '</li>';

            }

            ?>
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
</aside>