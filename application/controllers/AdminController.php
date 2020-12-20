<?php


namespace application\controllers;


use application\core\Controller;


class AdminController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }

    public function loginAction()
    {
        if (isset($_SESSION['admin']))
        {
            $this->view->redirect(shop_link().'/admin/panel');
        }
        if (!empty($_POST))
        {
            if (!$this->model->loginValidate($_POST))
            {
                $this->view->message('error', $this->model->error);
            }
            $_SESSION['admin'] = true;
            $this->view->redirect(shop_link().'/admin/panel');
        }
        $this->view->render('Вход', Array(),Array(),Array());
    }
    public function panelAction()
    {
        $this->view->render('Админ панель', Array(),Array(),Array());
    }

    public function catalogAction()
    {

        if (!isset($_POST['filter']))
        {
            $result = $this->model->search('');
            $vars['catalog'] =  $result;
        }
        else
        {
            if($_POST['filter'] === 'all')
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

        if (isset($_POST['category']))
        {
            $vars['categories_by_char'] = $this->model->getProductChars($_POST['category']);
        }
        $vars['categories'] = $this->model->viewAllCategories();
        $vars['full_categories'] = $this->model->viewFullCategories();
        $vars['types'] = $this->model->viewTypes('all');
        if (!isset($_POST['input_count_category']))
        {
            $vars['full_classes'] = $this->model->viewFullClassesChars();

        }
        else
            {
                $vars['full_classes'] = $this->model->viewClasses($_POST['input_count_category']);
                //echo var_dump($vars['full_classes']);
            }
        if (!isset($_POST['new_product_parent_cat']))
        {
            $vars['types'] = $this->model->viewTypes('all');

        }
        else
        {
            $vars['types'] = $this->model->viewTypes($_POST['new_product_parent_cat']);
        }
        if(isset($_SESSION['account']))
        {
            $vars['amount_in_cart']= $this->model->getAmountInCartDatabase($_SESSION['account']['id']);
        }
        else{
            $vars['amount_in_cart']= $this->model->getAmountInCartSession();
        }
        //Creating new class of chars
        $vars['max-price'] = $this->model->maxPrice();



        $this->view->render('Панель продуктов', Array(),Array(), $vars);
    }
    public function typeAction(){
        $types = $_POST;
        $category_id = $_POST['new_type_parent_cat'];
        unset($types['new_type_parent_cat']);
        unset($types['count_types']);
        $type = $types['type_name'];
        $image_name = $_FILES['type_img']['name'];
        $image_name = $this->model-> download_image($_FILES['type_img'],'public/images/categories_images/type_of_category_images/',$image_name);
        $this->model->addType($type,$category_id,$image_name);

    }
    public function waitlistAction()
    {
        $vars = $_SESSION['admin'];
        $this->view->render('Список ожидания',Array(),Array(),Array());
    }
    public function buylistAction()
    {
        $vars = $_SESSION['admin'];
        $this->view->render('Список желаний',Array(),Array(),Array());
    }
    public function wishlistAction()
    {
        $vars = $_SESSION['admin'];
        $this->view->render('Список желаний',Array(),Array(),Array());
    }
    public function cartAction()
    {
        $vars = $_SESSION['admin'];
        $this->view->render('Корзина',Array(),Array(),Array());
    }
    public function logoutAction()
    {
        unset($_SESSION['admin']);
        $this->view->redirect(shop_link().'/admin/login');
    }

    public function categoryAction() //проверка и запуск модели
    {

        $category_image = $_FILES['img_add'];
        $image_name = $category_image['name'];
        $image_name = $this->model-> download_image($_FILES['img_add'],'public/images/categories_images/',$image_name);
        $this->model->AddNewCategory($_POST,$image_name);

    }
    public function characteristicAction()
    {
//        $post = array_shift($_POST);
//        if (!isset($_POST['input_count_category']))
//        {
//            $result = $this->model->viewClasses($_POST['input_count_category']);
//            $vars['classes'] =  $result;
//        }
        $this->model->AddNewCharacteristic($_POST);
    }
    public function classAction()
    {
        $category = $_POST['category_class'];
        $classes = $_POST;
        unset($classes['category_class']);
        unset($classes['count_category_class']);
        $this->model->AddNewClassOfCharacteristics($category,$classes);
    }
    public function addAction()
    {

        $product_name = $_POST['add_product_name'];
        $product_descrioption = $_POST['add_product_description'];
        $product_price = $_POST['add_price'];
        $id_category = $_POST['new_product_parent_cat'];
        $chars = $_POST;
        $amount_types = $_POST['amount_types'];
        $types = Array();
        for ($i = 0; $i <= $amount_types; $i++) {
            $type_name = 'type_'.$i;
            if(isset($_POST[$type_name])){
                $type_id = $_POST[$type_name];
                array_push($types,$type_id);
                unset($chars[$type_name]);
            }
        }
        unset($chars['amount_types']);
        unset($chars['new_product_parent_cat']);
        unset($chars['add_product_name']);
        unset($chars['add_product_description']);
        unset($chars['add_price']);
        //exit;
        //$this->model->AddNewProduct($id_category,$chars);
        $bytes1 = random_bytes(10);
        $bytes1 = bin2hex($bytes1);
        $bytes2 = random_bytes(10);
        $bytes2 = bin2hex($bytes2);
        $bytes3 = random_bytes(10);
        $bytes3 = bin2hex($bytes3);
        $bytes4 = random_bytes(10);
        $bytes4 = bin2hex($bytes4);
        $image1 = $bytes1.'_'.$_FILES['add_image1']['name'];
        $image2 = $bytes2.'_'.$_FILES['add_image2']['name'];
        $image3 = $bytes3.'_'.$_FILES['add_image3']['name'];
        $image4 = $bytes4.'_'.$_FILES['add_image4']['name'];
        if ($this->model->CheckImage($_FILES,$image1,$image2,$image3,$image4) == false){
            $this->view->message('Error', $this->model->error);
        }
        else{

            $this->model->CheckImage($_FILES,$image1,$image2,$image3,$image4);
            $last_product_id = $this->model->AddNewProduct($id_category, $image1, $image2, $image3, $image4, $chars,$product_name,$product_descrioption,$product_price);
            foreach ($types as $type){
                $this->model->addProductType($last_product_id,$type,$id_category);
            }
        }
    }
    public function filterAction()
    {
        $result = $this->model->viewFilter($this->route['filters']);
        $vars['catalog'] =  $result;
        $vars['categories'] = $this->model->viewAllCategories();
        $this->view->render('Каталог',Array(),Array(), $vars);
    }
}