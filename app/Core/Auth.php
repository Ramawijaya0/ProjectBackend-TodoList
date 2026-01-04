<?php

class Auth {
    public static function check() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: index.php?page=login');
            exit;
        }
    }

    public static function user(){
        return $_SESSION['user'] ?? null;
    }
}