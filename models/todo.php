<?php

require_once __DIR__ . '/../core/Database.php';

class Todo
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllByUser($userId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM todos 
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $userId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM todos 
            WHERE id = ? AND user_id = ?
        ");
        $stmt->execute([$id, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO todos (user_id, title, description, due_date, status)
            VALUES (?, ?, ?, ?, 'pending')
        ");

        return $stmt->execute([
            $data['user_id'],
            $data['title'],
            $data['description'],
            $data['due_date']
        ]);
    }

    public function update($data)
    {
        $stmt = $this->db->prepare("
            UPDATE todos 
            SET title = ?, description = ?, due_date = ?, status = ?
            WHERE id = ? AND user_id = ?
        ");

        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['due_date'],
            $data['status'],
            $data['id'],
            $data['user_id']
        ]);
    }

    public function delete($id, $userId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM todos 
            WHERE id = ? AND user_id = ?
        ");
        return $stmt->execute([$id, $userId]);
    }
}
