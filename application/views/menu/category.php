<link rel="stylesheet" href="/public/styles/menu.css">
<?php
echo '<div class="menu_container">';
foreach($vars['types'] as $category):
    echo '<a href="/'.$category['id_category'].'/'.$category['id_category'].'/'.transliterate($category['name_type_of_category']).'/'.$category['id_type_of_category'].'">';
    echo '<div class="category_container">';
    echo '<div class="category_image_container">';
    echo '<img alt="" src="/public/images/categories_images/type_of_category_images/'.$category['type_of_category_image'].'" class="category_image">';
    echo '</div>';
    echo '<div class="category_name_container">';
    echo '<span  class="category_name">'.$category['name_type_of_category'].'</span>';
    echo '</div>';
    echo '</div>';
endforeach;
echo '</div>';
