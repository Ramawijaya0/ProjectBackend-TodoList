<!DOCTYPE html>
<html>

<head>
    <title>Tambah Todo</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="card">
        <h2>Tambah Todo</h2>

        <form action="index.php?page=todo-store" method="POST">
            <input type="text" name="title" placeholder="Judul Todo" required>
            <textarea name="description" placeholder="Deskripsi"></textarea>
            <input type="date" name="due_date" required>

            <button type="submit">Simpan</button>
            <a href="index.php?page=dashboard">Kembali</a>
        </form>
    </div>

</body>

</html>