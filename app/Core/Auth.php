<?php

/**
 * Class Auth
 * ----------
 * Class ini bertanggung jawab untuk autentikasi dasar:
 * - Mengecek apakah user sudah login (check)
 * - Mengambil data user dari session (user)
 *
 * Digunakan oleh controller lain (misalnya TodoController, AuthController)
 * untuk memastikan hanya user yang login bisa mengakses fitur tertentu.
 */
class Auth {
    /**
     * Method check()
     * --------------
     * - Mengecek apakah session 'user' sudah ada.
     * - Jika belum login:
     *   - Simpan pesan error ke session.
     *   - Redirect ke halaman login.
     *   - Hentikan eksekusi script dengan exit.
     */
    public static function check() {
        if (!isset($_SESSION['user'])) {
            // Simpan pesan error ke session
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            // Redirect ke halaman login
            header('Location: index.php?page=login');
            exit;
        }
    }

    /**
     * Method user()
     * -------------
     * - Mengambil data user dari session.
     * - Jika tidak ada user login, return null.
     *
     * @return array|null Data user yang sedang login atau null
     */
    public static function user() {
        // Ambil data user dari session jika ada
        return $_SESSION['user'] ?? null;
    }
}