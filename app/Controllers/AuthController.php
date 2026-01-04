<?php

require_once __DIR__ . '/../Models/User.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $user = $userModel->login($_POST['email'], $_POST['password']);

            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: index.php?page=todo');
                exit;
            }
        }

        $view = __DIR__ . '/../../views/auth/login.php';
        require __DIR__ . '/../../views/layout.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $userModel->register(
                $_POST['name'],
                $_POST['email'],
                $_POST['password']
            );
            header('Location: index.php?page=login');
            exit;
        }

        $view = __DIR__ . '/../../views/auth/register.php';
        require __DIR__ . '/../../views/layout.php';
    }


    public function logout()
    {
        session_destroy();
        header('Location: index.php?page=login');
    }
}