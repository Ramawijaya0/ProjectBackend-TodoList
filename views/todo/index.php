<h2>Todo List</h2>

<form method="POST" action="index.php?page=add-todo">
    <input type="text" name="title" placeholder="Todo baru..." required>
    <button type="submit">Tambah</button>
</form>

<ul>
    <?php foreach ($todos as $todo): ?>
    <li>
        <?= $todo['is_done'] ? '✅' : '⬜' ?>
        <?= htmlspecialchars($todo['title']) ?>

        <a href="index.php?page=toggle-todo&id=<?= $todo['id'] ?>">Toggle</a>
        |
        <a href="index.php?page=delete-todo&id=<?= $todo['id'] ?>" onclick="return confirm('Hapus todo ini?')">
            Hapus
        </a>
    </li>
    <?php endforeach; ?>
</ul>

<hr>

<a href="index.php?page=logout">Logout</a>