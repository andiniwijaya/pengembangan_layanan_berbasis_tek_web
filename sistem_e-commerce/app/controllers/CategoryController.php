<?php
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../../core/helpers.php';

class CategoryController {

    private function auth(){
        if(!isset($_SESSION['user'])){
            header("Location: /?url=auth/login");
            exit;
        }
    }

    public function index(){
        $this->auth();

        $model = new Category();
        $data = $model->all();

        $view = __DIR__ . '/../views/category/index.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function create(){
        $this->auth();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            (new Category())->create($_POST['name']);
            header("Location: /?url=category/index");
        }

        $view = __DIR__ . '/../views/category/create.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function edit(){
        $this->auth();

        $model = new Category();
        $id = $_GET['id'];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $model->update($id, $_POST['name']);
            header("Location: /?url=category/index");
        }

        $category = $model->find($id);

        $view = __DIR__ . '/../views/category/edit.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function delete(){
        $this->auth();

        (new Category())->delete($_GET['id']);
        header("Location: /?url=category/index");
    }
}