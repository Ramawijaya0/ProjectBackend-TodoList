<?php

// Import class Database untuk koneksi ke MySQL
require_once __DIR__ . '/../Core/Database.php';

/**
 * Class Todo
 * ----------
 * Model ini bertanggung jawab untuk operasi CRUD pada tabel `todos`.
 * - allByUser() : ambil semua todo milik user tertentu
 * - create()    : tambah todo baru
 * - delete()    : hapus todo berdasarkan id dan user
 * - toggle()    : ubah status todo (selesai ↔ belum selesai)
 */
class Todo {
    // Properti untuk menyimpan koneksi database (PDO)
    private $db;

    /**
     * Constructor
     * -----------
     * - Inisialisasi koneksi database menggunakan Singleton Database::getInstance()
     */
    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Method allByUser()
     * ------------------
     * - Mengambil semua todo berdasarkan user_id.
     * - Urutkan hasil berdasarkan id secara descending.
     *
     * @param int $userId ID user
     * @return array daftar todo milik user
     */
    public function allByUser($userId) {
        $stmt = $this->db->prepare(
            "SELECT * FROM todos WHERE user_id = ? ORDER BY id DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Method create()
     * ---------------
     * - Menambahkan todo baru ke database.
     *
     * @param int $userId ID user
     * @param string $title Judul todo
     * @return bool hasil eksekusi query
     */
    public function create($userId, $title) {
        $stmt = $this->db->prepare(
            "INSERT INTO todos (user_id, title) VALUES (?, ?)"
        );
        return $stmt->execute([$userId, $title]);
    }

    /**
     * Method delete()
     * ---------------
     * - Menghapus todo berdasarkan id dan user_id.
     *
     * @param int $id ID todo
     * @param int $userId ID user
     * @return bool hasil eksekusi query
     */
    public function delete($id, $userId) {
        $stmt = $this->db->prepare(
            "DELETE FROM todos WHERE id = ? AND user_id = ?"
        );
        return $stmt->execute([$id, $userId]);
    }

    /**
     * Method toggle()
     * ---------------
     * - Mengubah status todo (is_done) menjadi kebalikan dari nilai sebelumnya.
     * - Digunakan untuk menandai todo selesai ↔ belum selesai.
     *
     * @param int $id ID todo
     * @param int $userId ID user
     * @return bool hasil eksekusi query
     */
    public function toggle($id, $userId) {
        $stmt = $this->db->prepare(
            "UPDATE todos SET is_done = !is_done WHERE id = ? AND user_id = ?"
        );
        return $stmt->execute([$id, $userId]);
    }
}