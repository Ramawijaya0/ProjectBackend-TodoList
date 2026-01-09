<?php

// Import class Database untuk koneksi ke MySQL
require_once __DIR__ . '/../Core/Database.php';

/**
 * Class User
 * ----------
 * Model ini bertanggung jawab untuk operasi CRUD pada tabel `users`.
 * - register() : menambahkan user baru dengan password yang di-hash
 * - login()    : memverifikasi login user berdasarkan email & password
 */
class User
{
    // Properti untuk menyimpan koneksi database (PDO)
    private $db;

    /**
     * Constructor
     * -----------
     * - Inisialisasi koneksi database menggunakan Singleton Database::getInstance()
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Method register()
     * -----------------
     * - Menambahkan user baru ke database.
     * - Password di-hash menggunakan password_hash() agar aman.
     *
     * @param string $name Nama user
     * @param string $email Email user
     * @param string $password Password user (plain text, akan di-hash)
     * @return bool hasil eksekusi query
     */
    public function register($name, $email, $password)
    {
        // Hash password sebelum disimpan
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Query insert user baru
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$name, $email, $hash]);
    }

    /**
     * Method login()
     * --------------
     * - Mengecek apakah email ada di database.
     * - Verifikasi password dengan password_verify().
     * - Jika berhasil, hapus field password dari hasil fetch dan return data user.
     * - Jika gagal, return false.
     *
     * @param string $email Email user
     * @param string $password Password user (plain text)
     * @return array|false Data user tanpa password jika berhasil, false jika gagal
     */
    public function login($email, $password)
    {
        // Query ambil user berdasarkan email
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = ?"
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifikasi password
        if ($user && password_verify($password, $user['password'])) {
            // Hapus field password agar tidak disimpan di session
            unset($user['password']);
            return $user;
        }
        return false;
    }
}