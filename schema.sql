-- Tabel users
-- ----------------------------
-- Menyimpan data akun pengguna
-- Field:
-- - id         : Primary key, auto increment
-- - name       : Nama lengkap user
-- - email      : Email unik untuk login
-- - password   : Password yang sudah di-hash
-- - created_at : Timestamp otomatis saat data dibuat
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel todos
-- ----------------------------
-- Menyimpan daftar todo milik user
-- Field:
-- - id         : Primary key, auto increment
-- - user_id    : Relasi ke tabel users (foreign key)
-- - title      : Judul todo
-- - is_done    : Status todo (0 = belum selesai, 1 = selesai)
-- - created_at : Timestamp otomatis saat todo dibuat
-- Constraint:
-- - FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
--   -> Jika user dihapus, semua todo miliknya ikut terhapus
CREATE TABLE todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    is_done BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);