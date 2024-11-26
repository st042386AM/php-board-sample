<?php
set_include_path(__DIR__ . '/../');
require 'vendor/autoload.php';
require 'src/database.php'; // データベース接続関数の読み込み
require 'src/App.php'; // アプリケーションクラスの読み込み
require 'src/PostDAO.php'; // DAO(Data Access Object)クラスの読み込み

// アプリはここから開始
try {
    // データベース接続
    $config = include __DIR__ . '/../config/config.php';
    $pdo = createPDO($config);

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
