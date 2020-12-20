
<link rel="stylesheet" href="/public/styles/menu.css">
<?php
echo '<div class="menu_container">';
foreach($vars['categories'] as $category):
    echo '<a class="link_cat" href="/menu/'.transliterate($category['name']).'/'.$category['id_category'].'">';
    echo '<div class="category_container">';
    echo '<div class="category_image_container">';
    echo '<img alt="" src="/public/images/categories_images/'.$category['category_image'].'" class="category_image">';
    echo '</div>';
    echo '<div class="category_name_container">';
    echo '<span  class="category_name">'.$category['name'].'</span>';
    echo '</div>';
    echo '</div>';
    echo '</a>';
endforeach;
echo '</div>';

