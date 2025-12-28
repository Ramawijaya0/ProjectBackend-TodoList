<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        if (isset($_SESSION['user'])) {
            header('Location: index.php?page=dashboard');
            exit;
        }

        require_once __DIR__ . '/../public/login.php';
    }

    public function authenticate($data)
    {
        $user = $this->userModel->findByEmail($data['email']);

        if ($user && password_verify($data['password'], $user['password'])) {

            $_SESSION['user'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email']
            ];

            $_SESSION['success'] = 'Login berhasil';
            header('Location: index.php?page=dashboard');
            exit;
        }

        $_SESSION['error'] = 'Email atau password salah';
        header('Location: index.php?page=login');
        exit;
    }

    public function register()
    {
        require_once __DIR__ . '/../public/register.php';
    }

    public function store($data)
    {
        if ($this->userModel->findByEmail($data['email'])) {
            $_SESSION['error'] = 'Email sudah digunakan';
            header('Location: index.php?page=register');
            exit;
        }

        $this->userModel->create($data);

        $_SESSION['success'] = 'Akun berhasil dibuat, silakan login';
        header('Location: index.php?page=login');
        exit;
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }

    public static function check()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: index.php?page=login');
            exit;
        }
    }
}
