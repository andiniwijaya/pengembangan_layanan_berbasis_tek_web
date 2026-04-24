<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../../core/helpers.php';

class ProductController {

    private function auth(){
        if(!isset($_SESSION['user'])){
            header("Location: /?url=auth/login");
            exit;
        }
    }

    public function index(){
        $this->auth();

        $model = new Product();
        $data = $model->all();

        $view = __DIR__ . '/../views/product/index.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function create(){
        $this->auth();

        $model = new Product();

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $model->create($_POST);
            header("Location: /?url=product/index");
        }

        $categories = $model->getCategories();
        $suppliers  = $model->getSuppliers();

        $view = __DIR__ . '/../views/product/create.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function edit(){
        $this->auth();

        $model = new Product();
        $id = $_GET['id'];

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $model->update($id,$_POST);
            header("Location: /?url=product/index");
        }

        $data = $model->find($id);
        $categories = $model->getCategories();
        $suppliers  = $model->getSuppliers();

        $view = __DIR__ . '/../views/product/edit.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function delete(){
        $this->auth();

        (new Product())->delete($_GET['id']);
        header("Location: /?url=product/index");
    }
}