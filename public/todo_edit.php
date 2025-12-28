<?php
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (!isset($todo)) {
    echo "Data todo tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Todo</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <h2>Edit Todo</h2>

    <form action="index.php?page=update" method="POST">
        <input type="hidden" name="id" value="<?= $todo['id']; ?>">

        <label>Judul</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($todo['title']); ?>" required><br><br>

        <label>Deskripsi</label><br>
        <textarea name="description" required><?= htmlspecialchars($todo['description']); ?></textarea><br><br>

        <label>Tanggal Jatuh Tempo</label><br>
        <input type="date" name="due_date" value="<?= $todo['due_date']; ?>" required><br><br>

        <label>Status</label><br>
        <select name="status">
            <option value="pending" <?= $todo['status'] === 'pending' ? 'selected' : ''; ?>>
                Belum Selesai
            </option>
            <option value="completed" <?= $todo['status'] === 'completed' ? 'selected' : ''; ?>>
                Selesai
            </option>
        </select><br><br>

        <button type="submit">Update</button>
        <a href="index.php">Kembali</a>
    </form>

</body>

</html>