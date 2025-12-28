<?php
// dashboard.php hanya bertugas menampilkan data
// data $todos dikirim dari TodoController

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Todo</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <h2>Dashboard Todo List</h2>

    <p>Halo, <strong><?= htmlspecialchars($_SESSION['user']['name']); ?></strong></p>

    <a href="index.php?page=add">+ Tambah Todo</a>
    <a href="index.php?page=logout">Logout</a>

    <hr>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php if (!empty($todos)): ?>
            <?php foreach ($todos as $i => $todo): ?>
                <tr>
                    <td><?= $i + 1; ?></td>
                    <td><?= htmlspecialchars($todo['title']); ?></td>
                    <td><?= htmlspecialchars($todo['description']); ?></td>
                    <td><?= $todo['due_date']; ?></td>
                    <td><?= $todo['status']; ?></td>
                    <td>
                        <a href="index.php?page=edit&id=<?= $todo['id']; ?>">Edit</a>
                        <a href="index.php?page=delete&id=<?= $todo['id']; ?>"
                            onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <?php if (isset($_SESSION['success'])): ?>
                <p style="color:green;">
                    <?= $_SESSION['success']; ?>
                </p>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <tr>
                <td colspan="6">Belum ada todo</td>
            </tr>
        <?php endif; ?>
    </table>

</body>

</html>