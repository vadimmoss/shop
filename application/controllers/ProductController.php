<?php

namespace application\controllers;

use application\core\Controller;

class ProductController extends Controller
{
    public function viewAction()
    {

        $vars = $this->model->getProduct($this->route['category'],$this->route['id'],$this->route['name']);
        $name = $vars[0]['product_name'];
        $vars['chars'] = $this->model->getChars($this->route['category'], $this->route['id']);
        $keywords = $this->model->getProductKeywords($this->route['category'], $this->route['id']);
        $description = $this->model->getProductDescription($this->route['category'], $this->route['id']);
        $title = $this->model->getProductTitle($this->route['category'], $this->route['id']);
        //$vars['is_in_cart_database'] = $this->model->isInCartDatabase($this->route['category'],$this->route['id']);
        //$vars['is_in_cart'] = $this->model->isInCartSession($this->route['category'],$this->route['id']);
        if(isset($_SESSION['account']))
        {
            $vars['amount_in_cart']= $this->model->getAmountInCartDatabase($_SESSION['account']['id']);
        }
        else{
            $vars['amount_in_cart']= $this->model->getAmountInCartSession();
        }
        $this->view->render($title, $keywords, $description, $vars);
    }
}