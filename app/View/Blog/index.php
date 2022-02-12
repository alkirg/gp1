<html>
    <head>
        <title>Блог</title>
        <base href="http://localhost/gp1/html/">
    </head>
    <body>
        <h1>Блог</h1>
        Здравствуйте, <?=$this->user['name']?>!<br>
        <a href="blog/posts">Последние 20 записей блога</a><br>
        <a href="user/logout">Выйти</a>
        <br><br>
        <h2>Мои записи</h2>
        <p><a href="blog/post">Добавить новую запись</a></p>
        <?foreach ($this->posts as $post) {?>
        <div class="post">
            <h3><?=$post['title']?></h3>
            <p>
                <strong><?=$post['date_insert']?></strong><br>
                <?=$post['message']?>
            </p>
            <?if ($this->admin) {?>
            <a href="blog/delete?id=<?=$post['id']?>" class="remove">Удалить</a>
            <?}?>
        </div>
        <?}?>
        <script src="script.js"></script>
    </body>
</html>