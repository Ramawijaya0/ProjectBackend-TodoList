<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="card">
        <h2>Register</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <p style="color:red"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <p style="color:green"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form method="POST" action="index.php?page=register_store">
            <input type="text" name="name" required placeholder="Nama">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Register</button>
        </form>

        <p><a href="index.php?page=login">Login</a></p>
    </div>

</body>

</html>