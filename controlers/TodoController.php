<?php

require_once __DIR__ . '/../models/Todo.php';

class TodoController
{
    private $todoModel;

    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $this->todoModel = new Todo();
    }

    public function index()
    {
        $userId = $_SESSION['user']['id'];
        $todos = $this->todoModel->getAllByUser($userId);

        require __DIR__ . '/../public/dashboard.php';
    }

    public function create()
    {
        require __DIR__ . '/../public/todo_add.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->todoModel->create([
                'user_id'     => $_SESSION['user']['id'],
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'due_date'    => $_POST['due_date']
            ]);

            header("Location: index.php?page=dashboard");
            exit;
        }
    }

    public function edit($id)
    {
        $todo = $this->todoModel->getById($id, $_SESSION['user']['id']);

        if (!$todo) {
            die("Todo tidak ditemukan");
        }

        require __DIR__ . '/../public/todo_edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->todoModel->update([
                'id'          => $_POST['id'],
                'user_id'     => $_SESSION['user']['id'],
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'due_date'    => $_POST['due_date'],
                'status'      => $_POST['status']
            ]);

            header("Location: index.php?page=dashboard");
            exit;
        }
    }

    public function delete($id)
    {
        $this->todoModel->delete($id, $_SESSION['user']['id']);

        header("Location: index.php?page=dashboard");
        exit;
    }
}
