<?php
set_include_path(__DIR__ . '/../');
require 'vendor/autoload.php';
require 'dao/PostDAO.php';

use eftec\bladeone\BladeOne;

// アプリケーションクラス
class App
{
    private PostDAO $postDAO;
    private BladeOne $blade;

    public function __construct(PostDAO $postDAO)
    {
        $this->postDAO = $postDAO;
        $this->blade = new BladeOne(__DIR__ . '/../templates', __DIR__ . '/../cache');
    }

    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
                $this->handleDeleteRequest();
            } else {
                $this->handlePostRequest();
            }
        } else {
            $this->handleGetRequest();
        }
    }

    private function handlePostRequest(): void
    {
        $this->postDAO->createPost($_POST['name'], $_POST['title'], $_POST['content']);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    private function handleDeleteRequest(): void
    {
        $this->postDAO->deletePost($_POST['id']);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    private function handleGetRequest(): void
    {
        $posts = $this->postDAO->getPosts();
        echo $this->blade->run('board', ['posts' => $posts]);
        exit;
    }
}

// アプリはここから開始
try {
    // DB接続
    $config = include __DIR__ . '/../config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['DB_HOST']};port={$config['DB_PORT']};dbname={$config['DB_NAME']};charset=utf8mb4",
        $config['DB_USER'],
        $config['DB_PASS'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    // Data Access Objectの生成
    $postDAO = new PostDAO($pdo);
    // アプリケーションの実行
    $app = new App($postDAO);
    // リクエストの処理
    $app->handleRequest();
} catch (Exception $e) {
    error_log("Exception caught: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    http_response_code(500);
    echo "Internal Server Error. Please try again later.";
}
