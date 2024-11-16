<?php
set_include_path(__DIR__ . '/../');
require 'vendor/autoload.php';
require 'dao/Database.php';
require 'dao/PostDAO.php';

use eftec\bladeone\BladeOne;

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

// アプリケーションの実行
try {
    $pdo = Database::getConnection();
    $postDAO = new PostDAO($pdo);
    $app = new App($postDAO);
    $app->handleRequest();
} catch (Exception $e) {
    error_log("Exception caught: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    http_response_code(500);
    echo "Internal Server Error. Please try again later.";
}
