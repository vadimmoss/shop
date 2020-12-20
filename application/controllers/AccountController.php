<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller {

    public function loginAction()
    {
        if (!empty($_POST))
        {
            if (!$this->model->validate(['login', 'password'], $_POST))
            {
                $this->view->message('Error', $this->model->error);
            }
            elseif (!$this->model->checkData($_POST['login'], $_POST['password']))
            {
                $this->view->message('Error', 'Логин или пароль указан неверно');
            }
            elseif (!$this->model->checkStatus('login', $_POST['login']))
            {
                $this->view->message('Error', $this->model->error);
            }
            $this->model->login($_POST['login']);
            $this->view->location('account/profile');
        }
    }

    public function profileAction()
    {
        $vars = $_SESSION['account'];
        $title = $this->model->getProfileTitle($_SESSION['account']);
        $keywords = '';
        $description = '';
        if(isset($_SESSION['account']))
        {
            $vars['amount_in_cart']= $this->model->getAmountInCartDatabase($_SESSION['account']['id']);
        }
        else{
            $vars['amount_in_cart']= $this->model->getAmountInCartSession();
        }
        $this->view->render($title, $keywords, $description, $vars);
    }

    public function waitlistAction()
    {
        $id_user = $_SESSION['account']['id'];
        $vars['account'] = $_SESSION['account'];
        $vars['wait_list'] = $this->model->waitList($id_user);
        $keywords = '';
        $description = '';
        if(isset($_SESSION['account']))
        {
            $vars['amount_in_cart']= $this->model->getAmountInCartDatabase($_SESSION['account']['id']);
        }
        else{
            $vars['amount_in_cart']= $this->model->getAmountInCartSession();
        }
        $this->view->render('Список ожидания',$keywords, $description, $vars);
    }

    public function buylistAction()
    {
        $vars = $_SESSION['account'];
        $keywords = '';
        $description = '';
        if(isset($_SESSION['account']))
        {
            $vars['amount_in_cart']= $this->model->getAmountInCartDatabase($_SESSION['account']['id']);
        }
        else{
            $vars['amount_in_cart']= $this->model->getAmountInCartSession();
        }
        $this->view->render('Список покупок',$keywords, $description, $vars);
    }

    public function wishlistAction()
    {
        $vars = $_SESSION['account'];
        $keywords = '';
        $description = '';
        if(isset($_SESSION['account']))
        {
            $vars['amount_in_cart']= $this->model->getAmountInCartDatabase($_SESSION['account']['id']);
        }
        else{
            $vars['amount_in_cart']= $this->model->getAmountInCartSession();
        }
        $this->view->render('Список желаний',$keywords, $description, $vars);
    }

    public function cartAction()
    {

        $vars['user'] = $_SESSION['account'];
        //$vars['cities']= $this->model->getCities();
        $vars['amount']= $this->model->getAmount($_SESSION['account']['id']);
//        if (isset($_POST['city_post']))
//        {
//            $vars['posts'] = $this->model->getPostAddresses($_POST['city_post']);
//        }
//        else
//            {
//                $vars['posts'] = $this->model->getPostAddresses($vars['user']['city']);
//            }
        if (isset($_POST['id_del_product_from_cart']))
        {
            $this->model->deleteProductFromCart($_POST['id_del_product_from_cart']);
        }
        if (isset($_POST['id_product']) and isset($_POST['category_id']))
        {
            if(!$this->model->checkCartProduct($_POST['id_product'], $_POST['category_id']))
            {
                $this->view->message('Error', $this->model->error);
            }
            else
                {
                    $this->model->addToCart($_POST['id_product'], $_POST['category_id']);
                    $this->view->message('Добавлено', $this->model->error);
                }
        }
        else
            {
                $vars['products'] = $this->model->getCartProducts($_SESSION['account']['id']);
                $keywords = '';
                $description = '';
                $this->view->render('Корзина',$keywords, $description, $vars);
            }
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

    public function logoutAction()
    {
        unset($_SESSION['account']);
        unset($_SESSION['cart']);
        $this->view->redirect('/');
    }

    public function registerAction()
    {
        if (!empty($_POST))
        {
            if (!$this->model->validate(['email', 'login', 'password'], $_POST))
            {
                $this->view->message('Error', $this->model->error);
            }
            elseif ($this->model->checkEmailExists($_POST['email']))
            {
                $this->view->message('Error', 'Этот E-mail уже используется');
            }
            elseif (!$this->model->checkLoginExists($_POST['login']))
            {
                $this->view->message('Error', $this->model->error);
            }
            $this->model->register($_POST);
            $this->view->message('Success', 'Регистрация завершена, подтвердите свой E-mail');
        }
    }
    public function activateAction(){
        if($this->model->checkActivationCode($_POST['activation_code'])){
            $login = $_SESSION['login_reg'];
            $this->model->activateProfile($login);
            $this->view->message('Success', 'Регистрация подтверждена, войдите в свой кабинет.'); //
        }
        else
        {
            $this->view->message('Error', 'Код не действителен!');
        }
    }
    public function cURLAction(){
        $city = $_POST['city'];
        $this->model->cURL($city);
    }
    public function pURLAction(){
        $Ref = $_POST['city'];
        $this->model->pURL($Ref);
    }
}