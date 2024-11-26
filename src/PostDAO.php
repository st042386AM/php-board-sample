<?php

class PostDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(string $name, string $title, string $content): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO posts (name, title, content) VALUES (:name, :title, :content)');
        $stmt->execute([
            ':name' => $name,
            ':title' => $title,
            ':content' => $content,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM posts WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM posts ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }
}
