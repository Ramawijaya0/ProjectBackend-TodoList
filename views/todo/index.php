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