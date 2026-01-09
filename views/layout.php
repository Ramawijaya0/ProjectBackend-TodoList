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