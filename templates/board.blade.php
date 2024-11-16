<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>掲示板</h1>
    <form method="post" action="">
        <p>
            <label for="name">名前:</label><br>
            <input type="text" id="name" name="name" required>
        </p>
        <p>
            <label for="title">タイトル:</label><br>
            <input type="text" id="title" name="title" required>
        </p>
        <p>
            <label for="content">本文:</label><br>
            <textarea id="content" name="content" rows="5" required></textarea>
        </p>
        <button type="submit">投稿する</button>
    </form>

    <h2>投稿一覧</h2>
    @foreach ($posts as $post)
    <div class="post">
        <h3>{{ $post['title'] }}</h3>
        <p><strong>{{ $post['name'] }}</strong> - {{ $post['created_at'] }}</p>
        <p>{{ $post['content'] }}</p>
    </div>
    @endforeach
</body>

</html>