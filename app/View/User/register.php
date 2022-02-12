<html>
    <head>
        <title>Регистрация</title>
        <base href="http://localhost/gp1/html/">
    </head>
    <body>
        <h1>Регистрация</h1>
        <?if ($this->error) {?>
        <p style="color:red;"><?=$this->error?></p>
        <?}?>
        <?if ($this->user) {?>
        Здравствуйте, <?=$this->user['name']?>! Спасибо за регистрацию.<br>
        <a href="">Перейти</a> на главную.
        <?} else {?>
        <form action="user/register" method="post">
            <p><input type="text" name="name" placeholder="Имя" value="<?=$_POST['name']?>"></p>
            <p><input type="text" name="email" placeholder="Почта" value="<?=$_POST['email']?>"></p>
            <p><input type="password" name="password" placeholder="Пароль"></p>
            <p><input type="password" name="confirm_password" placeholder="Повторите пароль"></p>
            <button>Войти</button>
        </form>
        <a href="user/login">Вход</a>
        <?}?>
    </body>
</html>