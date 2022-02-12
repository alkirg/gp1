<html>
    <head>
        <title>Последние 20 записей</title>
        <base href="http://localhost/gp1/html/">
    </head>
    <body>
        <h1>Последние 20 записей блога</h1>
        <p><a href="">На главную</a></p>
        <?foreach ($this->posts as $post) {?>
        <div class="post">
            <h3><?=$post['title']?></h3>
            <p>
                <strong><?=$post['date_insert']?></strong><br>
                <?=$post['message']?><br>
                <strong>Автор:</strong> <?=$post['author']?>
                <?if ($this->admin) {?>
                <br><a href="blog/delete?id=<?=$post['id']?>" class="remove">Удалить</a>
                <?}?>
            </p>
        </div>
        <?}?>
    </body>
    <script src="script.js"></script>
</html>