<?php


namespace application\controllers;

use application\core\Controller;

class CartController extends Controller
{
    public function cartAction()
    {
        $keywords = '';
        $description = '';
        $title =  'Корзина';
//        $vars['cities']= $this->model->getCities();
        if(isset($_SESSION['account']))
        {
            $vars['amount_in_cart']= $this->model->getAmountInCartDatabase($_SESSION['account']['id']);
        }
        else{
            $vars['amount_in_cart']= $this->model->getAmountInCartSession();
        }
//        if (isset($_POST['city_post'])){
//            $vars['posts'] = $this->model->getPostAddresses($_POST['city_post']);
//        }
//        else{
//            $vars['posts'] = $this->model->getPostAddresses('Абазівка');
//        }
        if(isset($_SESSION['cart'])){
            $vars['cart'] = $this->model->getCartProducts($_SESSION['cart']);
            $vars['amount_price'] = $this->model->getAmountPrice($_SESSION['cart']);
        }
        else{
            $vars['cart'] = Array('nothing');
        }

        $this->view->render($title, $keywords, $description, $vars);
    }
    public function addAction()
    {
        $id_category = $_POST['category_id'];
        $id_product = $_POST['id_product'];
        $this->model->addToCart($id_category, $id_product);
    }
    public function delAction()
    {
        $id_category = $_POST['category_id'];
        $id_product = $_POST['id_product'];
        $this->model->delFromCart($id_category, $id_product);

    }
    public function cURLAction(){
        $city = $_POST['city'];
        $this->model->cURL($city);
    }
    public function pURLAction(){
        $Ref = $_POST['city'];
        $this->model->pURL($Ref);
    }
    public function sendAction()
    {
        if (!empty($_POST))
        {
            $this->model->sendOrder($_POST);
        }
        else
        {
            echo 'POST is empty!';
        }
    }
}