# Todo List App

## Deskripsi Project

Aplikasi Todo List berbasis PHP Native dan MySQL yang dilengkapi dengan fitur autentikasi (Login & Register).
Setiap user hanya dapat mengelola todo miliknya sendiri. Project ini dibuat menggunakan konsep MVC sederhana.

---

## Teknologi yang Digunakan

- PHP 8.x
- MySQL (phpMyAdmin)
- Apache (XAMPP)
- HTML & CSS
- PDO (PHP Data Object)
- Session PHP

---

## Struktur Folder Project

```
ProjectTodoList/
app/
│
├── Controllers/
│   ├── AuthController.php
│   └── TodoController.php
│
├── Core/
│   ├── Auth.php
│   └── Database.php
│
├── Models/
│   ├── User.php
│   └── Todo.php
│
config/
│   └── database.php
│
public/
│   └── assets/
│       ├── css/
│       │   └── style.css
│       └── js/
│           └── script.js
│
views/
│
├── auth/
│   ├── login.php
│   └── register.php
│
├── todo/
│   ├── index.php
│
├── layout.php
│
index.php
schema.sql
README.md
```

---

## Cara Instalasi

### 1. Persiapan Environment

- Install XAMPP
- Jalankan Apache dan MySQL
- Pastikan PHP versi 8.x
- Buat folder yang bernama PROJECTTODOLIST

---

### 2. Membuat Database

1. Buka browser dan akses:
   http://localhost/phpmyadmin
2. Buat database baru:
   todo_list
3. Pilih database tersebut
4. Copy query yang ada di schema.sql
5. Paste di menu SQL pada phpmyadmin
6. Lalu klik kirim

---

### 3. Menyalin Kode

### Pastikan Struktur folder sudah benar

---

#### 3.1 app/Controllers/AuthController.php

Salin kode berikut:

```php
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
```

#### 3.2 app/Controllers/TodoController.php

Salin kode berikut:

```php
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
```

#### 3.3 app/Core/Auth.php

Salin kode berikut:

```php
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
```

#### 3.4 app/Core/Database.php

Salin kode berikut:

```php
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
```

#### 3.5 app/Models/Todo.php

Salin kode berikut:

```php
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
```

#### 3.6 app/Models/User.php

Salin kode berikut:

```php
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
```

#### 3.7 Config/database.php

Salin kode berikut:

```php
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
```

#### 3.8 public/assets/css/style.css

Salin kode berikut:

```php
/* Reset box-sizing agar semua elemen menghitung padding & border dalam ukuran total */
* {
  box-sizing: border-box;
}

/* Atur font utama untuk seluruh halaman */
body {
  font-family: "Poppins", sans-serif;
}

/* Styling dasar body: background abu-abu muda + padding */
body {
  background: #f4f4f4;
  padding: 40px;
}

/* Container utama untuk konten todo list */
.container {
  max-width: 500px;      /* Lebar maksimal container */
  background: #fff;      /* Background putih */
  padding: 20px;         /* Ruang dalam */
  margin: auto;          /* Posisi tengah */
  border-radius: 8px;    /* Sudut membulat */
}

/* Styling umum untuk input dan button */
input,
button {
  width: 100%;           /* Lebar penuh */
  padding: 8px;          /* Ruang dalam */
  margin: 6px 0;         /* Jarak antar elemen */
}

/* Styling khusus untuk button */
button {
  background: #2563eb;   /* Warna biru */
  color: white;          /* Teks putih */
  border: none;          /* Hilangkan border default */
  border-radius: 4px;    /* Sudut membulat */
}
```

#### 3.9 public/assets/js/script.js

Salin kode berikut:

```php
// File JavaScript utama untuk aplikasi Todo List
// ----------------------------------------------
// Digunakan untuk menampilkan pesan awal di console browser
// sebagai indikator bahwa script sudah berjalan dengan benar.

console.log("Todo List App"); // Output pesan ke console browser
```

#### 3.10 views/auth/login.php

Salin kode berikut:

```php
<!-- Judul halaman login -->
<h2>Login</h2>

<!-- Form login -->
<form class="form-login" method="POST">
    <!-- Input email: wajib diisi -->
    <input type="email" name="email" placeholder="Email" required>

    <!-- Input password: wajib diisi -->
    <input type="password" name="password" placeholder="Password" required>

    <!-- Tombol submit untuk login -->
    <button type="submit">Login</button>
</form>

<!-- Link ke halaman register jika belum punya akun -->
<p>
    Belum punya akun?
    <a href="index.php?page=register">Register</a>
</p>
```

#### 3.11 views/auth/register.php

Salin kode berikut:

```php
<!-- Judul halaman register -->
<h2>Register</h2>

<!-- Form register -->
<form method="POST">
    <!-- Input nama lengkap: wajib diisi -->
    <input type="text" name="name" placeholder="Nama Lengkap" required>

    <!-- Input email: wajib diisi -->
    <input type="email" name="email" placeholder="Email" required>

    <!-- Input password: wajib diisi -->
    <input type="password" name="password" placeholder="Password" required>

    <!-- Tombol submit untuk mendaftar -->
    <button type="submit">Daftar</button>
</form>

<!-- Link ke halaman login jika sudah punya akun -->
<p>
    Sudah punya akun?
    <a href="index.php?page=login">Login</a>
</p>
```

#### 3.12 views/todo/index.php

Salin kode berikut:

```php
<!-- Judul halaman Todo List -->
<h2>Todo List</h2>

<!-- Form untuk menambahkan todo baru -->
<form method="POST" action="index.php?page=add-todo">
    <!-- Input judul todo: wajib diisi -->
    <input type="text" name="title" placeholder="Todo baru..." required>

    <!-- Tombol submit untuk menambahkan todo -->
    <button type="submit">Tambah</button>
</form>

<!-- Daftar todo -->
<ul>
    <?php foreach ($todos as $todo): ?>
    <li>
        <!-- Tampilkan status todo: ✅ jika selesai, ⬜ jika belum -->
        <?= $todo['is_done'] ? '✅' : '⬜' ?>

        <!-- Tampilkan judul todo, diamankan dengan htmlspecialchars -->
        <?= htmlspecialchars($todo['title']) ?>

        <!-- Link untuk toggle status todo -->
        <a href="index.php?page=toggle-todo&id=<?= $todo['id'] ?>">Toggle</a>
        |
        <!-- Link untuk hapus todo, dengan konfirmasi sebelum eksekusi -->
        <a href="index.php?page=delete-todo&id=<?= $todo['id'] ?>" onclick="return confirm('Hapus todo ini?')">
            Hapus
        </a>
    </li>
    <?php endforeach; ?>
</ul>

<!-- Garis pemisah -->
<hr>

<!-- Link untuk logout -->
<a href="index.php?page=logout">Logout</a>
```

#### 3.13 views/layout.php

Salin kode berikut:

```php
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Todo App</title>

    <!-- Import Google Font Poppins untuk styling teks -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Import file CSS utama -->
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>

<body>
    <!-- Container utama untuk menampilkan konten halaman -->
    <div class="container">
        <!-- Render view sesuai dengan halaman yang dipanggil -->
        <?php require $view; ?>
    </div>
</body>

</html>
```

#### 3.14 index.php

Salin kode berikut:

```php
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
```

---

### 4. Menjalankan Project

- Buka XAMPP
- Jalankan Apache & MySQL
- Buka folder PROJECTTODOLIST Pada Vs code
- Buka terminal (ctrl + `)
- Ketik: php -S localhost:8000

---

## Fitur Aplikasi

### Autentikasi

- Register user
- Login user
- Logout
- Session untuk proteksi halaman

### Todo List

- Menampilkan todo berdasarkan user
- Tambah todo
- Edit todo
- Hapus todo
- Status todo (pending / selesai)

---

## Alur Aplikasi

1. User membuka aplikasi
2. User login atau register
3. User diarahkan ke dashboard
4. User mengelola todo miliknya
5. Semua data terhubung ke database

---

## Catatan

- Project menggunakan PHP Native tanpa framework
- Struktur MVC sederhana
- Menggunakan PDO untuk keamanan database
- Session digunakan untuk autentikasi

---

## Identitas

Nama : KADEK ANINDYA RATU KENCANA
NIM : 240030258

Nama : I Putu Rama Wijaya Kusuma Putra
NIM : 240030202

Nama : Made Raka Krisnawan Maheswara
NIM : 240030209

Matkul : Backend
