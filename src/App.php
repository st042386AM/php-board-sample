<?php

use eftec\bladeone\BladeOne;

// アプリケーションクラス
class App
{
    private PostDAO $postDAO;
    private BladeOne $blade;

    public function __construct(PostDAO $postDAO)
    {
        $this->postDAO = $postDAO;
        $this->blade = new BladeOne(__DIR__ . '/templates', __DIR__ . '/../cache');
    }

    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
                $this->handleDelete();
            } else {
                $this->handlePost();
            }
        } else {
            $this->handleGet();
        }
    }

    private function handlePost(): void
    {
        $this->postDAO->create($_POST['name'], $_POST['title'], $_POST['content']);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    private function handleDelete(): void
    {
        $this->postDAO->delete($_POST['id']);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    private function handleGet(): void
    {
        $posts = $this->postDAO->getAll();
        echo $this->blade->run('board', ['posts' => $posts]);
        exit;
    }
}
