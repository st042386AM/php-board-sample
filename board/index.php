<?php
set_include_path(__DIR__ . '/../');
require 'vendor/autoload.php';
require 'App.php';
require 'dao/PostDAO.php';

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
    // アプリケーションクラスの生成
    $app = new App($postDAO);
    // リクエストの処理
    $app->handleRequest();
} catch (Exception $e) {
    error_log("Exception caught: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    http_response_code(500);
    echo "Internal Server Error. Please try again later.";
}
