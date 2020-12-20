<?php


namespace application\controllers;

use application\core\Controller;

class CatalogController extends Controller
{

    public function addNewCategoryAction() //проверка и запуск модели
    {
        if (isset($_POST['name']))
        {
            $name = $_POST['name'];
            $this->model->AddNewCategory($name);
        }
    }
    public function viewAction()
    {
        if (isset($_POST['search_string']))
        {
            $result = $this->model->search($_POST['search_string']);
            $vars['catalog'] =  $result;
        }
        else{
            if (!isset($_POST['filter']))
            {
                $result = $this->model->viewAll();
                $vars['catalog'] =  $result;
            }
            else
            {
                if($_POST['filter'] === 'all')
                {
                    $result = $this->model->viewAll();
                    $vars['catalog'] =  $result;
                }
                else
                {
                    $vars['catalog'] =  $this->model->viewFilter($_POST['table_name'], $_POST['filter']);
                }
            }
        }
        $vars['categories'] = $this->model->viewAllCategories();
        $this->view->render('Каталог', $vars);
    }
    public function filterAction()
    {
        $result = $this->model->viewFilter($this->route['filters']);
        $vars['catalog'] =  $result;
        $vars['categories'] = $this->model->viewAllCategories();
        $this->view->render('Каталог', $vars);
    }
    public function searchAction()
    {

        $vars['categories'] = $this->model->viewAllCategories();
        $this->view->render('Каталог', $vars);
    }
}