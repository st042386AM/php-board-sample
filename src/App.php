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
        $this->postDAO->create($_POST['name'], $_POST['title'], $_POST['content']);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    private function handleDeleteRequest(): void
    {
        $this->postDAO->delete($_POST['id']);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    private function handleGetRequest(): void
    {
        $posts = $this->postDAO->getAll();
        echo $this->blade->run('board', ['posts' => $posts]);
        exit;
    }
}
