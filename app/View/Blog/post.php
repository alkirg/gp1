<html>
    <head>
        <title>Новый пост</title>
        <base href="http://localhost/gp1/html/">
    </head>
    <body>
        <h1>Новый пост</h1>
        <?if ($this->error) {?>
        <p style="color:red;"><?=$this->error?></p>
        <?}?>
        <form action="blog/post" method="post">
            <p><input type="text" name="title" placeholder="Заголовок" value="<?=$_POST['title']?>"></p>
            <p><textarea name="message" placeholder="Текст" rows="20" cols="50"><?=$_POST['message']?></textarea></p>
            <p>Добавить изображение:<br><input type="file" name="image"></p>
            <button>Добавить</button>
        </form>
    </body>
</html>