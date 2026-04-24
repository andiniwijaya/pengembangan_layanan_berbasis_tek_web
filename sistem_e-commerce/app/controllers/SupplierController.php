<?php
require_once __DIR__ . '/../models/Supplier.php';
require_once __DIR__ . '/../../core/helpers.php';

class SupplierController {

    private function auth(){
        if(!isset($_SESSION['user'])){
            header("Location: /?url=auth/login");
            exit;
        }
    }

    public function index(){
        $this->auth();

        $data = (new Supplier())->all();

        $view = __DIR__ . '/../views/supplier/index.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function create(){
        $this->auth();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            (new Supplier())->create($_POST);
            header("Location: /?url=supplier/index");
        }

        $view = __DIR__ . '/../views/supplier/create.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function edit(){
        $this->auth();

        $model = new Supplier();
        $id = $_GET['id'];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $model->update($id, $_POST);
            header("Location: /?url=supplier/index");
        }

        $data = $model->find($id);

        $view = __DIR__ . '/../views/supplier/edit.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function delete(){
        $this->auth();

        (new Supplier())->delete($_GET['id']);
        header("Location: /?url=supplier/index");
    }
}