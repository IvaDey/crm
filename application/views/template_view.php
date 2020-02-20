<!DOCTYPE html>
<html>
<head>
    <title><?=$data['title'];?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="/favicon.png?v=<?=time();?>" type="image/x-icon">
    <link rel="stylesheet" href="/css/template.css?v=<?=time();?>">
    <?php
    if ($data['css_name']) {
        print '<link rel="stylesheet" href="/css/' . $data['css_name'] . '?v=' .time() .'">';
    }
    ?>
    <link rel="stylesheet" href="/css/libs/jquery-ui.css">
    <link rel="stylesheet" href="/css/libs/jquery.formstyler.css">
    <link rel="stylesheet" href="/css/libs/jquery.formstyler.theme.css">
    <link rel="stylesheet" href="/css/libs/jquery.timepicker.css">
    <link rel="stylesheet" href="/css/libs/jquery.fancybox.min.css">
    <link rel="stylesheet" href="/css/libs/clockpicker.css">
    <link rel="stylesheet" href="/css/libs/clockpicker.standalone.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <script src="/js/libs/jquery-3.3.1.js"></script>
    <script src="/js/libs/jquery-ui.js"></script>
    <script src="/js/libs/jquery.formstyler.min.js"></script>
    <script src="/js/libs/jquery.timepicker.js"></script>
    <script src="/js/libs/jquery.fancybox.min.js"></script>
    <script src="/js/libs/clockpicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="/js/template.js?v=<?=time();?>"></script>
    <?php
    if ($data['script_name']) {
        print '<script src="/js/' . $data['script_name'] . '?v=' .time() .'"></script>';
    }
    ?>
</head>
<body>
<div id="wrap">
    <section id="main-menu">
        <header>
            <img id="nav-logo" src="/images/full-logo.png">
        </header>

        <nav>
            <ul>
                <li id="nav-home">
                    <a href="https://rbs-demo.ivadey.ru">
                        <div class="nav-ico"><img src="/images/nav-home-ico.png"></div>
                        Главная
                    </a>
                </li>

                <li id="nav-reservations">
                    <a href="https://rbs-demo.ivadey.ru/reservations">
                        <div class="nav-ico"><img src="/images/nav-reservations-ico.png"></div>
                        Онлайн журнал
                    </a>
                </li>

                <li id="nav-users">
                    <a href="https://rbs-demo.ivadey.ru/users">
                        <div class="nav-ico"><img src="/images/nav-users-ico.png"></div>
                        Клиентская база
                    </a>
                </li>

                <li id="nav-stats" class="parent-menu-item">
                    <div class="main-menu-nav-label">
                        <div class="nav-ico"><img src="/images/nav-stats-ico.png"></div>
                        Статистика
                    </div>

                    <ul class="sub-menu ui-helper-hidden">
                        <li id="sub-nav-stats-local"><a href="/stats/local">Статистика по салону</a></li>
                        <li id="sub-nav-stats-unit"><a href="/stats/unit">Unit экономика</a></li>
                        <li id="sub-nav-stats-employees"><a href="/stats/employees">Отчеты по сотрудниками</a></li>
                    </ul>
                </li>

                <li id="nav-inventory">
                    <a href="https://rbs-demo.ivadey.ru/inventory">
                        <div class="nav-ico"><img src="/images/nav-inventory-ico.png"></div>
                        Товарный учет
                    </a>
                </li>

                <li id="nav-finance" class="parent-menu-item">
                    <div class="main-menu-nav-label">
                        <div class="nav-ico"><img src="/images/nav-finance-ico.png"></div>
                        Финансы
                    </div>

                    <ul class="sub-menu ui-helper-hidden">
                        <li id="sub-nav-finance-accounting"><a href="/">Финансовый учет</a></li>
                        <li id="sub-nav-finance-salary"><a href="/">Рассчет зарплат</a></li>
                    </ul>
                </li>

                <li id="nav-advertising" class="parent-menu-item">
                    <div class="main-menu-nav-label">
                        <div class="nav-ico"><img src="/images/nav-advertising-ico.png"></div>
                        Рекламный кабинет
                    </div>

                    <ul class="sub-menu ui-helper-hidden">
                        <li id="sub-nav-advertising-campaigns"><a href="/">Рекламные кампании</a></li>
                        <li id="sub-nav-advertising-promos"><a href="/">Промопредложения</a></li>
                        <li id="sub-nav-advertising-mailing"><a href="/">Рассылки</a></li>
                        <li id="sub-nav-advertising-funnels"><a href="/">Автоворонки</a></li>
                    </ul>
                </li>

                <li id="nav-widget">
                    <a href="https://rbs-demo.ivadey.ru/widget">
                        <div class="nav-ico"><img src="/images/nav-widget-ico.png"></div>
                        Виджет
                    </a>
                </li>

                <li id="nav-plan">
                    <a href="https://rbs-demo.ivadey.ru/plan">
                        <div class="nav-ico"><img src="/images/nav-plan-ico.png"></div>
                        Тариф
                    </a>
                </li>

                <li id="nav-base_data" class="parent-menu-item">
                    <div class="main-menu-nav-label">
                        <div class="nav-ico"><img src="/images/nav-company_info-ico.png"></div>
                        Базовые данные
                    </div>

                    <ul class="sub-menu ui-helper-hidden">
                        <li id="sub-nav-base_data-about"><a href="/base_data/about">О компании</a></li>
                        <li id="sub-nav-base_data-locations"><a href="/base_data/locations">Список салонов</a></li>
                        <li id="sub-nav-base_data-services"><a href="/base_data/services">Перечень услуг</a></li>
                        <li id="sub-nav-base_data-masters"><a href="/base_data/masters">Мастера</a></li>
                    </ul>
                </li>

                <li id="nav-settings" class="parent-menu-item">
                    <div class="main-menu-nav-label">
                        <div class="nav-ico"><img src="/images/nav-settings-ico.png"></div>
                        Настройки
                    </div>

                    <ul class="sub-menu ui-helper-hidden">
                        <li id="sub-nav-settings-basic"><a href="/settings/basic">Базовые данные</a></li>
                        <li id="sub-nav-settings-about"><a href="/settings/about">Данные о компании</a></li>
                        <li id="sub-nav-settings-integrations"><a href="/settings/integrations">Интеграции</a></li>
                        <li id="sub-nav-settings-notifications"><a href="/settings/notifications">Уведомления</a></li>
                        <li id="sub-nav-settings-accounts"><a href="/settings/accounts">Учетные записи</a></li>
                    </ul>
                </li>
            </ul>

            <script>
                let menu_item = '#' + '<?=$data['menu_item_id'];?>'
                let sub_menu_item = '#' + '<?=$data['sub_menu_item_id'];?>'

                $(menu_item).addClass('selected');
                $(menu_item).addClass('opened');
                if (sub_menu_item != '#')
                    $(sub_menu_item).addClass('selected');
            </script>
        </nav>
    </section>

    <section id="additional-menu">
        <button id="hide-main-menu"></button>
        <h1><?=$data['title'];?></h1>
        <div id="ctr-panel">
            <div id="notifications">
            </div>
            
            <div id="user-menu">
                <span>Иван Иванов</span>
                <img src="/images/masters/default.png">

                <ul id="user-menu_items">
                    <li><a href="/main">Профиль</a></li>
                    <li><a href="/help">Помощь</a></li>
<!--                    <div class="user-menu_items-separator"></div>-->
                    <li><a href="/logout">Выйти</a></li>
                </ul>
            </div>
        </div>
    </section>

    <section id="content">
        <?php
        include_once $content;
        ?>
    </section>

    <div id="ajax-load"></div>
</div>
</body>
</html>
