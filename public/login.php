<?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController();
    $error = $auth->login($_POST['email'], $_POST['password']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="card">
        <h2>Login</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color:red;">
                <?= $_SESSION['error']; ?>
            </p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <p style="color:green;">
                <?= $_SESSION['success']; ?>
            </p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button>Login</button>
        </form>
        <p><?= $error ?></p>
        <a href="index.php?page=register">Register</a>
    </div>
</body>

</html>