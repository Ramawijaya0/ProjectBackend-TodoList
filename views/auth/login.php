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