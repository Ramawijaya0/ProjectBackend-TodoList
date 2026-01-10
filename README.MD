# Todo List App (PHP + MySQL)

## 1. Deskripsi Aplikasi

### Entitas yang dipilih
Aplikasi ini menggunakan dua entitas utama, yaitu **User** dan **Todo**.  
- **User** berfungsi sebagai pengelola autentikasi, di mana setiap pengguna dapat melakukan registrasi, login, dan logout. Setelah berhasil login, pengguna memperoleh akses ke seluruh fitur aplikasi untuk mengelola daftar todo.  
- **Todo** menjadi objek utama pendataan, mencakup informasi seperti judul todo, status selesai/belum selesai, serta waktu pembuatan.

### Fungsi aplikasi
Fitur aplikasi berfokus pada pengelolaan daftar todo melalui operasi **Create, Read, Update, Delete (CRUD)**:  
- Menambahkan todo baru.  
- Menampilkan daftar todo dalam tampilan terstruktur.  
- Melakukan toggle status todo (selesai ↔ belum selesai).  
- Menghapus todo yang tidak diperlukan.  

Seluruh proses pengolahan data dilakukan melalui antarmuka sederhana dan terintegrasi dengan sistem autentikasi, sehingga hanya pengguna terverifikasi yang dapat melakukan perubahan.

---

## 2. Spesifikasi Teknis

### Versi PHP & DBMS
- PHP versi **8.x**  
- Database: **MySQL** bawaan XAMPP/MAMP/Laragon

### Struktur Folder Ringkas
- `config/database.php` → konfigurasi koneksi database  
- `app/Controllers/` → berisi `AuthController.php`, `TodoController.php`  
- `app/Core/` → berisi `Database.php`, `Auth.php`  
- `app/Models/` → berisi `User.php`, `Todo.php`  
- `views/` → berisi `layout.php`, `login.php`, `register.php`, `todo/index.php`  
- `public/assets/css/style.css` → stylesheet utama  
- `public/assets/js/app.js` → script frontend  
- Root → `index.php`, `schema.sql`

### Class Utama
- **Database**: pengelola koneksi ke MySQL menggunakan PDO.  
- **User**: menangani autentikasi (registrasi, login, logout).  
- **Todo**: menangani operasi CRUD untuk entitas todo.  

---

## 3. Instruksi Menjalankan Aplikasi

### Download
Clone repository atau unduh project.

### Lokasi Penempatan
- **PHP built-in server**: ekstrak folder proyek di lokasi bebas.  
- **XAMPP**: ekstrak ke `C:\xampp\htdocs\`  
C:\xampp\htdocs\todo-list-app\

---

### Langkah Impor Database
1. Pastikan MySQL berjalan.  
2. Database default: `todo_list` (dari `schema.sql`).  
3. Buka phpMyAdmin / MySQL client.  
4. Pilih menu **Import**.  
5. Pilih file `schema.sql` dari root project.  
6. Klik **Go** → database & tabel otomatis dibuat.

### Konfigurasi Database
1. Buka `config/database.php`.  
2. Sesuaikan `host`, `username`, `password` dengan MySQL lokal.  
 (XAMPP default: `root` tanpa password).

### Menjalankan Aplikasi
- **PHP built-in server**  
Jalankan server:  
```bash
php -S localhost:8000
- XAMPP
Letakkan folder di htdocs, jalankan Apache.
URL Akses
- http://localhost/todo-list-app/index.php
- http://localhost:8000/index.php
User tanpa session login akan diarahkan ke login.php.

---

## 4. Contoh Skenario Uji Singkat
User
- Registrasi akun baru melalui halaman register.
- Login menggunakan akun terdaftar.
- Logout dari aplikasi.
Todo
- Menambahkan todo baru melalui form tambah.
- Menampilkan seluruh todo pada halaman index.
- Melakukan toggle status todo (selesai ↔ belum selesai).
- Menghapus todo berdasarkan ID.
- Ada konfirmasi sebelum penghapusan.

---

