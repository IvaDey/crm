<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/css/auth.css?v=<?=time();?>">
    <link rel="shortcut icon" href="/favicon.png?v=<?=time();?>" type="image/x-icon">
    <script src="/js/libs/jquery-3.3.1.js"></script>
    <script src="/js/auth.js?<?=time();?>"></script>
</head>
<body>
    <div class="wrap">
        <header>
            <h1>IvaDey journal</h1>
            <span>Авторизация</span>
        </header>
        <form method="post">
            <label>
                <input type="text" name="username">
                <img src="/images/login-ico.png">
                <span class="placeholder">Логин</span>
            </label>

            <label>
                <input type="password" name="pass">
                <img src="/images/password-ico.png">
                <span class="placeholder">Пароль</span>
            </label>

            <label class="checkbox">
                <input type="checkbox">
                Запомнить меня
            </label>

            <a href="/recover"><img src="/images/lock-ico.png">Забыли пароль?</a>

            <button id="login">Войти</button>
        </form>
        <footer>
            <a href="/sign_up"><img src="/images/key-ico.png">Нет аккаунта? Зарегистрируйтесь.</a>
        </footer>
    </div>
</body>
</html>