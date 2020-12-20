<link rel="stylesheet" href="/public/styles/profile_adaptivity.css">
<script src="/public/scripts/profile_adaptivity.js"></script>
<div class="container">
    <main class="content">
        <div id="waiting_list_info">
            <style>
                table {
                    border-spacing: 0; /* Расстояние между ячеек */
                    text-align: justify;
                    font-size: 14px;
                    margin: 20px;
                }
                th {
                    background-color: rgba(59, 255, 117, 0.25);
                    color: rgba(0, 0, 0, 0.82);
                }
                td, th {
                    padding: 5px 10px; /* Поля в ячейках */
                    border-right: 1px solid rgba(0, 0, 0, 0.23);
                    border-bottom: 1px solid rgba(0, 0, 0, 0.23);
                }
                tr>*:hover {
                    cursor: pointer;
                }
            </style>
            <h1 id="header_waitlist">Список ожиданий:</h1>
            <table>
                <tr>
                    <th>№</th>
                    <th style="width: 200px">Товары</th>
                    <th>ФИО</th>
                    <th>Номер телефона</th>
                    <th>Адрес доставки</th>
                    <th>Тип оплаты</th>
                    <th>Сумма</th>
                </tr>




            <?php
            $product_vars = $vars['wait_list'];
            //echo $product_vars['last_name'];

            foreach ($product_vars as $product_var){
                echo '<tr><td>'.$product_var['id_order'].'</td><td>'.$product_var['products'].'</td>
                        <td>'.$product_var['first_name'].' '.$product_var['last_name'].'</td>
                        <td>'.$product_var['phone_number'].'</td>
                        <td>Місто: '.$product_var['city'].' '.$product_var['post_address'].'</td>
                        <td>'.$product_var['pay_type'].'</td>
                        <td>'.$product_var['amount_price'].' грн</td></tr>';
            }
            ?>

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

