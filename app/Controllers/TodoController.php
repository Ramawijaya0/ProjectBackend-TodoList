<?php

require_once __DIR__ . '/../Models/Todo.php';
require_once __DIR__ . '/../Core/Auth.php';

class TodoController
{
    public function index()
    {
        Auth::check();

        $todoModel = new Todo();
        $todos = $todoModel->allByUser(Auth::user()['id']);

        $view = __DIR__ . '/../../views/todo/index.php';
        require __DIR__ . '/../../views/layout.php';
    }


    public function store()
    {
        Auth::check();
        if (!empty($_POST['title'])) {
            $todoModel = new Todo();
            $todoModel->create(Auth::user()['id'], $_POST['title']);
        }
        header('Location: index.php?page=todo');
    }

    public function delete()
    {
        Auth::check();
        $todoModel = new Todo();
        $todoModel->delete($_GET['id'], Auth::user()['id']);
        header('Location: index.php?page=todo');
    }

    public function toggle()
    {
        Auth::check();
        $todoModel = new Todo();
        $todoModel->toggle($_GET['id'], Auth::user()['id']);
        header('Location: index.php?page=todo');
    }
}