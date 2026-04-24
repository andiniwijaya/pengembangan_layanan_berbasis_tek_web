<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {

    public function login(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $userModel = new User();
            $user = $userModel->findByUsername($_POST['username']);

            if($user && password_verify($_POST['password'], $user['password'])){

                $_SESSION['user'] = $user;

                if($user['role'] == 'admin'){
                    header("Location: /?url=dashboard/admin");
                } else {
                    header("Location: /?url=dashboard/kasir");
                }

                exit;
            }

            $error = "Username atau password salah";
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout(){
        session_destroy();
        header("Location: /?url=auth/login");
    }
}