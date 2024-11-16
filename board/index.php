<?php
set_include_path(__DIR__ . '/../');
require 'vendor/autoload.php';
$config = include 'config/config.php';

use eftec\bladeone\BladeOne;

// Bladeテンプレートエンジンを初期化
$blade = new BladeOne(__DIR__ . '/../templates', __DIR__ . '/../cache');

try {
    // データベース接続を確立    
    $pdo = new PDO(
        "mysql:host={$config['DB_HOST']};port={$config['DB_PORT']};dbname={$config['DB_NAME']};charset=utf8mb4",
        $config['DB_USER'],
        $config['DB_PASS'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // POSTリクエストの処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // データを挿入
        $stmt = $pdo->prepare('INSERT INTO posts (name, title, content) VALUES (:name, :title, :content)');
        $stmt->execute([
            ':name' => $_POST['name'] ?? '',
            ':title' => $_POST['title'] ?? '',
            ':content' => $_POST['content'] ?? ''
        ]);

        // フォーム再送信を防ぐためにリダイレクト
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    // 投稿データを取得
    $stmt = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC');
    $posts = $stmt->fetchAll();
} catch (PDOException $e) {
    die("データベースエラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}

// Bladeテンプレートをレンダリング
echo $blade->run('board', ['posts' => $posts]);
