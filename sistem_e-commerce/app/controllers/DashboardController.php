<?php
require_once __DIR__ . '/../../core/helpers.php';

class DashboardController {

    private function auth(){
        if(!isset($_SESSION['user'])){
            header("Location: /?url=auth/login");
            exit;
        }
    }

    public function admin(){

        $this->auth();

        if($_SESSION['user']['role'] != 'admin'){
            header("Location: /?url=dashboard/kasir");
            exit;
        }

        $view = __DIR__ . '/../views/dashboard/admin.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function kasir(){

        $this->auth();

        if($_SESSION['user']['role'] != 'kasir'){
            header("Location: /?url=dashboard/admin");
            exit;
        }

        $view = __DIR__ . '/../views/dashboard/kasir.php';
        require __DIR__ . '/../views/layout/main.php';
    }
}