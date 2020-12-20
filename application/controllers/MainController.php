<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller {

    public function addNewCategoryAction()
    {
        if (isset($_POST['name']))
        {
            $name = $_POST['name'];
            $this->model->AddNewCategory($name);
        }
    }

    public function indexAction()
    {
        if (isset($_POST['search_string']))
        {
            $result = $this->model->search($_POST['search_string']);
            $vars['catalog'] =  $result;
        }
        else{
            if (!isset($_POST['filter']))
            {
                $result = $this->model->search('');
                $vars['catalog'] =  $result;
            }
            else
            {
//                if($_POST['filter'] === 'all' && isset($_POST['table_name'])){
//
//                }
                if ($_POST['filter'] === 'all')
                {
                    $result = $this->model->search('');
                    $vars['catalog'] =  $result;
                }
                else
                {
                    if (!isset($_POST['table_name'])){
                        $vars['catalog'] =  $this->model->viewFilterall($_POST['filter']);
                    }
                    else
                    {
                        $vars['catalog'] =  $this->model->viewFilter($_POST['table_name'], $_POST['filter']);
                    }
                }
            }
        }
        if(isset($_SESSION['account']))
        {
            $vars['amount_in_cart']= $this->model->getAmountInCartDatabase($_SESSION['account']['id']);
        }
        else{
            $vars['amount_in_cart']= $this->model->getAmountInCartSession();
        }
        $vars['categories'] = $this->model->viewAllCategories();
        $vars['max-price'] = $this->model->maxPrice();
        $keywords = $this->model->getKeyWords();
        $description = $this->model->getDescription();
        $title =  $this->model->getMainTitle();
        $this->view->render($title, $keywords, $description, $vars);
    }
}