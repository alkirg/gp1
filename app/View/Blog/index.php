<html>
    <head>
        <title>Блог</title>
        <base href="http://localhost/gp1/html/">
    </head>
    <body>
        <h1>Блог</h1>
        Здравствуйте, <?=$this->user['name']?>!<br>
        <a href="user/logout">Выйти</a>
        <br><br>
        <h2>Записи</h2>
        <?foreach ($this->posts as $post) {?>
        <div class="post">
            <h3><?=$post['title']?></h3>
            <p>
                <strong><?=$post['date_insert']?></strong><br>
                <?=$post['message']?>
            </p>
        </div>
        <?}?>
    </body>
</html>