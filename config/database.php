<?php
// File konfigurasi database
// -------------------------
// Berisi pengaturan koneksi ke MySQL yang digunakan oleh class Database.
// Nilai-nilai ini dipanggil di Core/Database.php untuk membuat koneksi PDO.

return [
    // Host database (biasanya localhost untuk development)
    'host' => 'localhost',

    // Nama database yang digunakan
    'dbname' => 'todo_list',

    // Username untuk koneksi database
    'user' => 'root',

    // Password untuk koneksi database (kosong jika default XAMPP/MAMP)
    'pass' => ''
];