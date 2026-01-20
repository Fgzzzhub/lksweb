<?php

class MessageModel extends BaseModel
{
    public function create($name, $email, $subject, $message)
    {
        $stmt = $this->pdo->prepare('INSERT INTO messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())');
        $stmt->execute([$name, $email, $subject, $message]);
    }

    public function all()
    {
        $stmt = $this->pdo->query('SELECT * FROM messages ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM messages WHERE id = ?');
        $stmt->execute([(int) $id]);
        return $stmt->fetch();
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM messages WHERE id = ?');
        $stmt->execute([(int) $id]);
    }
}
