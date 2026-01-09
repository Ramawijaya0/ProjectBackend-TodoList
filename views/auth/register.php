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