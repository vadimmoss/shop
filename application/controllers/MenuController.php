<?php



namespace application\controllers;

use application\core\Controller;


class MenuController extends Controller
{
    public function menuAction()
    {
        $vars['categories'] = $this->model->viewCategories();
        if(isset($_SESSION['account']))
        {
            $vars['amount_in_cart']= $this->model->getAmountInCartDatabase($_SESSION['account']['id']);
        }
        else{
            $vars['amount_in_cart']= $this->model->getAmountInCartSession();
        }
        $this->view->render('Главное меню', Array(), Array(), $vars);
    }

    public function categoryAction()
    {
        $vars['types'] = $this->model->viewAllTypes($this->route['name'],$this->route['id']);
        if(isset($_SESSION['account']))
        {
            $vars['amount_in_cart']= $this->model->getAmountInCartDatabase($_SESSION['account']['id']);
        }
        else{
            $vars['amount_in_cart']= $this->model->getAmountInCartSession();
        }
        $this->view->render('Категория', Array(), Array(), $vars);
    }
//    public function catalogAction()
//    {
//        $vars['types'] = $this->model->viewAllTypes($this->route['name'],$this->route['id']);
//        $this->view->render('Главное меню', Array(), Array(), $vars);
//    }
    public function catalogAction()
    {

        if (isset($_POST['search_string']))
        {
            $result = $this->model->search($_POST['search_string'],$this->route['category'],$this->route['categoryid'],$this->route['type'],$this->route['typeid']); //type of product, id of category

            $vars['catalog'] =  $result;
        }
        else{
            if (!isset($_POST['filter']))
            {
                $result = $this->model->search('',$this->route['category'],$this->route['categoryid'],$this->route['type'],$this->route['typeid']); //type of product, id of category
                $vars['catalog'] =  $result;
            }
            else
            {
//                if($_POST['filter'] === 'all' && isset($_POST['table_name'])){
//
//                }
                if ($_POST['filter'] === 'all')
                {
                    $result = $this->model->search('',$this->route['category'],$this->route['categoryid'],$this->route['type'],$this->route['typeid']); //type of product, id of category

                    $vars['catalog'] =  $result;
                }
                else
                {
                    if (!isset($_POST['table_name'])){
                        $vars['catalog'] =  $this->model->viewFilterall($_POST['filter'],$this->route['category'],$this->route['categoryid'],$this->route['type'],$this->route['typeid']);
                    }
                    else
                    {

                        $vars['catalog'] =  $this->model->viewFilter($_POST['table_name'], $_POST['filter'],$this->route['category'],$this->route['categoryid'],$this->route['type'],$this->route['typeid']);
                    }
                }
            }
        }

        $vars['categories'] = $this->model->viewAllCategories($this->route['categoryid']);
        $vars['max-price'] = $this->model->maxPrice();
        $keywords = $this->model->getKeyWords();
        $description = $this->model->getDescription();
        $title =  $this->model->getMainTitle();
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