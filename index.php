<?php
// Mulai session untuk menyimpan data user login
session_start();

// Import controller yang dibutuhkan
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/TodoController.php';

// Ambil parameter 'page' dari URL, default ke 'login' jika tidak ada
$page = $_GET['page'] ?? 'login';

// Inisialisasi controller
$auth = new AuthController();
$todo = new TodoController();

/**
 * Routing sederhana menggunakan switch-case
 * -----------------------------------------
 * - Menentukan halaman/fungsi yang dipanggil berdasarkan nilai $page
 * - Mengarahkan ke method controller sesuai kebutuhan
 */
switch ($page) {
    case 'login':
        // Halaman login
        $auth->login();
        break;
    case 'register':
        // Halaman register
        $auth->register();
        break;
    case 'logout':
        // Proses logout
        $auth->logout();
        break;
    case 'todo':
        // Halaman daftar todo
        $todo->index();
        break;
    case 'add-todo':
        // Proses tambah todo baru
        $todo->store();
        break;
    case 'delete-todo':
        // Proses hapus todo
        $todo->delete();
        break;
    case 'toggle-todo':
        // Proses toggle status todo (selesai ↔ belum)
        $todo->toggle();
        break;
    default:
        // Jika halaman tidak ditemukan
        echo "404";
}