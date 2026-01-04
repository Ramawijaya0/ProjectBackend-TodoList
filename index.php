<?php
session_start();

require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/TodoController.php';

$page = $_GET['page'] ?? 'login';

$auth = new AuthController();
$todo = new TodoController();

switch ($page) {
    case 'login':
        $auth->login();
        break;
    case 'register':
        $auth->register();
        break;
    case 'logout':
        $auth->logout();
        break;
    case 'todo':
        $todo->index();
        break;
    case 'add-todo':
        $todo->store();
        break;
    case 'delete-todo':
        $todo->delete();
        break;
    case 'toggle-todo':
        $todo->toggle();
        break;
    default:
        echo "404";
}