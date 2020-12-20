<link rel="stylesheet" href="/public/styles/product_adaptivity.css">
<?php

$product = $vars[0];
?>
<div class="full_product_container">
    <div class="left_block">
        <div class="full_product_image">
            <div id="block-for-slider">
                <div id="viewport">
                    <ul id="slidewrapper">
                        <li class="slide"><img src="/public/images/products_images/<?php echo $product['product_image'];?>" alt="1" class="slide-img"></li>
                        <li class="slide"><img src="/public/images/products_images/<?php echo $product['product_image2'];?>" alt="2" class="slide-img"></li>
                        <li class="slide"><img src="/public/images/products_images/<?php echo $product['product_image3'];?>" alt="3" class="slide-img"></li>
                        <li class="slide"><img src="/public/images/products_images/<?php echo $product['product_image4'];?>" alt="4" class="slide-img"></li>
                    </ul>

                    <div id="prev-next-btns">
                        <div id="prev-btn"></div>
                        <div id="next-btn"></div>
                    </div>

                    <ul id="nav-btns">
                        <li class="slide-nav-btn"></li>
                        <li class="slide-nav-btn"></li>
                        <li class="slide-nav-btn"></li>
                        <li class="slide-nav-btn"></li>
                    </ul>
                </div>
            </div>
            <script>
                var slideNow = 1;
                var slideCount = $('#slidewrapper').children().length;
                var slideInterval = 3000;
                var navBtnId = 0;
                var translateWidth = 0;

                $(document).ready(function() {

                    $('#next-btn').click(function() {
                        nextSlide();
                    });

                    $('#prev-btn').click(function() {
                        prevSlide();
                    });

                    $('.slide-nav-btn').click(function() {
                        navBtnId = $(this).index();

                        if (navBtnId + 1 != slideNow) {
                            translateWidth = -$('#viewport').width() * (navBtnId);
                            $('#slidewrapper').css({
                                'transform': 'translate(' + translateWidth + 'px, 0)',
                                '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
                                '-ms-transform': 'translate(' + translateWidth + 'px, 0)',
                            });
                            slideNow = navBtnId + 1;
                        }
                    });
                });


                function nextSlide() {
                    if (slideNow == slideCount || slideNow <= 0 || slideNow > slideCount) {
                        $('#slidewrapper').css('transform', 'translate(0, 0)');
                        slideNow = 1;
                    } else {
                        translateWidth = -$('#viewport').width() * (slideNow);
                        $('#slidewrapper').css({
                            'transform': 'translate(' + translateWidth + 'px, 0)',
                            '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
                            '-ms-transform': 'translate(' + translateWidth + 'px, 0)',
                        });
                        slideNow++;
                    }
                }

                function prevSlide() {
                    if (slideNow == 1 || slideNow <= 0 || slideNow > slideCount) {
                        translateWidth = -$('#viewport').width() * (slideCount - 1);
                        $('#slidewrapper').css({
                            'transform': 'translate(' + translateWidth + 'px, 0)',
                            '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
                            '-ms-transform': 'translate(' + translateWidth + 'px, 0)',
                        });
                        slideNow = slideCount;
                    } else {
                        translateWidth = -$('#viewport').width() * (slideNow - 2);
                        $('#slidewrapper').css({
                            'transform': 'translate(' + translateWidth + 'px, 0)',
                            '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
                            '-ms-transform': 'translate(' + translateWidth + 'px, 0)',
                        });
                        slideNow--;
                    }
                }
            </script>
        </div>
    </div>
    <div class="middle_block">
        <div class="full_product_name"><?php echo $product['product_name'];?></div>
        <div class="product_items">
            <div class="product_price"><?php echo $product['product_price'];?> грн.</div>
<!--            <div class="buy_button_container"><a class="buy_button">Купить</a></div>-->
            <div class="add_to_cart_button">
                <?php

                if($vars['is_in_cart'] === true or $vars['is_in_cart_database'] === true){
                echo'<div class="product_buy_button"><a class="buy_button_product_page" category="'.$product['product_category_id'].'" id="'.$product['id_product'].'">В Корзине <img class="buy_cart" src="/public/images/cart/cart_checked.png"></a></div>';
                }
                else{
                echo'<div class="product_buy_button"><a class="buy_button_product_page" category="'.$product['product_category_id'].'" id="'.$product['id_product'].'"> Купить <img class="buy_cart" src="/public/images/cart/cart.png"></a></div>';
                }?>
            </div>
        </div>
        <div class="full_product_description"><?php echo $product['product_description'];?></div>

    </div>

</div>
<div class="right_block">
    <div class="full_product_chars">
        <div class="chars_article">Характеристики товарів:</div>
        <table class="chars_table">
            <?php
            foreach ($vars['chars'] as $key => $value){
                echo "<tr>";
                echo "<td>$key: </td>";
                echo "<td>$value</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>
