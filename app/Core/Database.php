<?php

/**
 * Class Database
 * --------------
 * Class ini menggunakan pola Singleton untuk mengelola koneksi database.
 * - Hanya ada satu instance Database yang dibuat selama aplikasi berjalan.
 * - Menggunakan PDO untuk koneksi ke MySQL.
 * - Konfigurasi diambil dari file config/database.php.
 */
class Database
{
    // Menyimpan instance tunggal Database
    private static $instance = null;

    // Menyimpan objek PDO
    private $pdo;

    /**
     * Constructor privat
     * ------------------
     * - Mencegah instansiasi langsung dari luar class.
     * - Membuat koneksi PDO menggunakan konfigurasi dari file config.
     */
    private function __construct()
    {
        // Ambil konfigurasi database dari file config/database.php
        $config = require __DIR__ . '/../../config/database.php';

        // Data Source Name (DSN) untuk koneksi MySQL
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";

        // Buat koneksi PDO dengan opsi error mode exception
        $this->pdo = new PDO($dsn, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    /**
     * Method getInstance()
     * --------------------
     * - Mengembalikan instance tunggal PDO.
     * - Jika belum ada instance, buat baru.
     *
     * @return PDO Objek koneksi PDO
     */
    public static function getInstance()
    {
        // Jika belum ada instance, buat baru
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        // Kembalikan objek PDO
        return self::$instance->pdo;
    }
}