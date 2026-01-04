<?php

require_once __DIR__ . '/../Core/Database.php';

class Todo {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function allByUser($userId) {
        $stmt = $this->db->prepare(
            "SELECT * FROM todos WHERE user_id = ? ORDER BY id DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($userId, $title) {
        $stmt = $this->db->prepare(
            "INSERT INTO todos (user_id, title) VALUES (?, ?)"
        );
        return $stmt->execute([$userId, $title]);
    }

    public function delete($id, $userId) {
        $stmt = $this->db->prepare(
            "DELETE FROM todos WHERE id = ? AND user_id = ?"
        );
        return $stmt->execute([$id, $userId]);
    }

    public function toggle($id, $userId) {
        $stmt = $this->db->prepare(
            "UPDATE todos SET is_done = !is_done WHERE id = ? AND user_id = ?"
        );
        return $stmt->execute([$id, $userId]);
    }
}