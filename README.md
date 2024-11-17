# 概要

PHP掲示板のサンプルです。改変、配布などはご自由に。

# 機能

投稿と削除ができます。

# 技術

PHP入門でよく見かけるHTMLとコードの混じった記法が、かえって判りにくく感じている人向け。

- フレームワークなし
- クラスを用いたMVC
- テンプレートエンジンとしてBladeを用います
- 共用サーバへアップロードする前提の構成

# MySQLのテーブル定義

```
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## License
These codes are licensed under CC0.
[![CC0](http://i.creativecommons.org/p/zero/1.0/88x31.png "CC0")](http://creativecommons.org/publicdomain/zero/1.0/deed.ja)
