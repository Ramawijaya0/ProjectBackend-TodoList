<?php

// Import model Todo dan class Auth untuk otentikasi
require_once __DIR__ . '/../Models/Todo.php';
require_once __DIR__ . '/../Core/Auth.php';

/**
 * Class TodoController
 * --------------------
 * Controller ini bertanggung jawab untuk fitur utama To-Do List:
 * - Menampilkan daftar todo milik user
 * - Menambahkan todo baru
 * - Menghapus todo
 * - Mengubah status todo (selesai/belum)
 *
 * Semua method dilindungi oleh Auth::check() agar hanya user login yang bisa mengakses.
 */
class TodoController
{
    /**
     * Method index()
     * --------------
     * - Mengecek autentikasi user.
     * - Mengambil semua todo berdasarkan user yang sedang login.
     * - Menentukan view yang akan dirender.
     */
    public function index()
    {
        Auth::check(); // Pastikan user sudah login

        $todoModel = new Todo();
        // Ambil semua todo milik user yang sedang login
        $todos = $todoModel->allByUser(Auth::user()['id']);

        // Tentukan view yang akan digunakan
        $view = __DIR__ . '/../../views/todo/index.php';
        require __DIR__ . '/../../views/layout.php';
    }

    /**
     * Method store()
     * --------------
     * - Mengecek autentikasi user.
     * - Jika ada input 'title', buat todo baru untuk user.
     * - Redirect kembali ke halaman todo.
     */
    public function store()
    {
        Auth::check();
        if (!empty($_POST['title'])) {
            $todoModel = new Todo();
            // Buat todo baru dengan title dari form
            $todoModel->create(Auth::user()['id'], $_POST['title']);
        }
        // Redirect ke halaman todo setelah simpan
        header('Location: index.php?page=todo');
    }

    /**
     * Method delete()
     * ---------------
     * - Mengecek autentikasi user.
     * - Menghapus todo berdasarkan id milik user.
     * - Redirect ke halaman todo.
     */
    public function delete()
    {
        Auth::check();
        $todoModel = new Todo();
        // Hapus todo sesuai id dan user login
        $todoModel->delete($_GET['id'], Auth::user()['id']);
        header('Location: index.php?page=todo');
    }

    /**
     * Method toggle()
     * ---------------
     * - Mengecek autentikasi user.
     * - Mengubah status todo (selesai ↔ belum selesai).
     * - Redirect ke halaman todo.
     */
    public function toggle()
    {
        Auth::check();
        $todoModel = new Todo();
        // Toggle status todo sesuai id dan user login
        $todoModel->toggle($_GET['id'], Auth::user()['id']);
        header('Location: index.php?page=todo');
    }
}