<html>
    <head>
        <title>Вход</title>
        <base href="http://localhost/gp1/html/">
    </head>
    <body>
        <h1>Вход</h1>
        <?if ($this->error) {?>
        <p style="color:red;"><?=$this->error?></p>
        <?}?>
        <?if ($this->user) {?>
        Здравствуйте, <?=$this->user['name']?>!<br>
        <a href="">Перейти</a> на главную.
        <?} else {?>
        <form action="user/login" method="post">
            <p><input type="text" name="login" placeholder="Логин" value="<?=$_POST['login']?>"></p>
            <p><input type="password" name="password" placeholder="Пароль"></p>
            <button>Войти</button>
        </form>
        <a href="user/register">Регистрация</a>
        <?}?>
    </body>
</html>