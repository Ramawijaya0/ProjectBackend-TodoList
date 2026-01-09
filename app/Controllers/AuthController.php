<?php

// Import model User untuk autentikasi
require_once __DIR__ . '/../Models/User.php';

/**
 * Class AuthController
 * --------------------
 * Controller ini bertanggung jawab untuk proses autentikasi user:
 * - Login
 * - Register
 * - Logout
 *
 * Alur umum:
 * 1. Menerima request dari user (via form).
 * 2. Memanggil model User untuk validasi/CRUD.
 * 3. Mengatur session dan redirect ke halaman sesuai.
 * 4. Memanggil view untuk menampilkan form login/register.
 */
class AuthController
{
    /**
     * Method login()
     * --------------
     * - Jika request POST: validasi email & password melalui User model.
     * - Jika berhasil: simpan data user ke session dan redirect ke halaman todo.
     * - Jika gagal atau GET: tampilkan form login.
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            // Panggil fungsi login dari model User
            $user = $userModel->login($_POST['email'], $_POST['password']);

            if ($user) {
                // Simpan data user ke session
                $_SESSION['user'] = $user;
                // Redirect ke halaman todo
                header('Location: index.php?page=todo');
                exit;
            }
        }

        // Tentukan view yang akan dipakai
        $view = __DIR__ . '/../../views/auth/login.php';
        // Gunakan layout utama
        require __DIR__ . '/../../views/layout.php';
    }

    /**
     * Method register()
     * -----------------
     * - Jika request POST: ambil data dari form (name, email, password).
     * - Panggil fungsi register dari model User untuk simpan ke database.
     * - Redirect ke halaman login setelah berhasil daftar.
     * - Jika GET: tampilkan form register.
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            // Panggil fungsi register dari model User
            $userModel->register(
                $_POST['name'],
                $_POST['email'],
                $_POST['password']
            );
            // Redirect ke halaman login
            header('Location: index.php?page=login');
            exit;
        }

        // Tentukan view yang akan dipakai
        $view = __DIR__ . '/../../views/auth/register.php';
        // Gunakan layout utama
        require __DIR__ . '/../../views/layout.php';
    }

    /**
     * Method logout()
     * ---------------
     * - Menghancurkan session user.
     * - Redirect ke halaman login.
     */
    public function logout()
    {
        session_destroy();
        header('Location: index.php?page=login');
    }
}