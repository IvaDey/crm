<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/css/sign_up.css?v=<?=time();?>">
    <link rel="shortcut icon" href="/favicon.png?v=<?=time();?>" type="image/x-icon">
    <script src="/js/libs/jquery-3.3.1.js"></script>
    <script src="/js/sign_up.js?<?=time();?>"></script>
</head>
<body>
<div class="wrap">
    <header>
        <h1>IvaDey journal</h1>
        <span>Регистрация</span>
    </header>
    <form method="post">
        <label>
            <input type="text" name="company_name">
            <img src="/images/company-ico.png">
            <span class="placeholder">Название компании</span>
            <div class="status-icon"></div>
            <span class="error-message half"></span>
        </label>
        <label class="half">
            <input type="text" name="name">
            <img src="/images/name-ico.png">
            <span class="placeholder">Имя</span>
            <div class="status-icon"></div>
            <span class="error-message half"></span>
        </label>
        <label class="half">
            <input type="text" name="surname">
            <img src="/images/name-ico.png">
            <span class="placeholder">Фамилия</span>
            <div class="status-icon"></div>
            <span class="error-message half"></span>
        </label>

        <label>
            <input type="text" name="username">
            <img src="/images/login-ico.png">
            <span class="placeholder">Логин</span>
            <div class="status-icon"></div>
            <span class="error-message half"></span>
        </label>

        <label class="half">
            <input type="password" name="pass">
            <img src="/images/password-ico.png">
            <span class="placeholder">Придумайте пароль</span>
            <div class="status-icon"></div>
            <span id="password-error-message" class="error-message"></span>
        </label>

        <label class="half">
            <input type="password" name="re_pass">
            <img src="/images/password-ico.png">
            <span class="placeholder">Повторите пароль</span>
            <div class="status-icon"></div>
        </label>

        <label class="half">
            <input type="phone" name="phone">
            <img src="/images/phone-ico.png">
            <span class="placeholder">Телефон</span>
            <div class="status-icon"></div>
            <span class="error-message half"></span>
        </label>

        <label class="half">
            <input type="email" name="email">
            <img src="/images/email-ico.png">
            <span class="placeholder">Email</span>
            <div class="status-icon"></div>
            <span class="error-message half"></span>
        </label>

        <label class="checkbox">
            <input type="checkbox">
            Согласен с&nbsp;<a href="#">политикой конфиденциальности</a>
            <span class="error-message half"></span>
        </label>

        <label class="checkbox">
            <input type="checkbox">
            Согласен с&nbsp;<a href="#">пользовательским соглашением</a>
            <span class="error-message half"></span>
        </label>

        <button id="sign_up">Зарегистрироваться</button>
    </form>
    <footer>
        <a href="/auth">Уже зарегистрированны? Войдите.</a>
    </footer>
</div>
</body>
</html>