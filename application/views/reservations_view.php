<header>
    <div class="filters">
        <input type="text" name="date" placeholder="-- дата --">
        <select name="location_id">
            <option value="" selected>-- Выберите филиал --</option>
            <?php
            foreach ($data['locations'] as $location) {
                print '<option value="' . $location->id . '">' . $location->name . '</option>';
            }
            ?>
        </select>
        <select name="service_id">
            <option value="" selected>-- Выберите услугу --</option>
            <?php
            foreach ($data['services'] as $service) {
                print '<option value="' . $service->id . '" data-service_category="'
                    .$service->category_id . '">' . $service->name . '</option>';
            }
            ?>
        </select>
        <select name="master_id">
            <option value="" selected>-- Выберите мастера --</option>
            <?php
            foreach ($data['masters'] as $master) {
                print '<option value="' . $master['id'] . '" data-location_id="'
                    .$master['location_id'] . '">' . $master['name'] . '</option>';
            }
            ?>
        </select>
        <select name="status_id">
            <option value="" selected>-- Выберите стутс --</option>
            <option value="1">Предстоящая</option>
            <option value="2">В процессе</option>
            <option value="3">Отмененная</option>
            <option value="4">Завершенная</option>
        </select>
    </div>
</header>

<main class="calendar">
    <div class="calendar-ctl-panel">
        <span>14 сентября, Суббота</span>
        <a href="#modal-export" rel="nofollow" class="openmodal"><button id="export-btn">Экоспортировать</button></a>
        <a href="#modal-creating-new" rel="nofollow" class="openmodal"><button id="add-event">Добавить запись</button></a>
    </div>

    <div class="calendar-body">
        <div class="calendar-row calendar-header-row">
            <div class="time-col"></div>
            <div class="master-col"><img src="/images/masters/default.png">Master 1</div>
            <div class="master-col"><img src="/images/masters/default.png">Master 2</div>
            <div class="master-col"><img src="/images/masters/default.png">Master 3</div>
            <div class="master-col"><img src="/images/masters/default.png">Master 4</div>
            <div class="master-col"><img src="/images/masters/default.png">Master 5</div>
        </div>

        <?php
        for ($i = 8; $i < 24; $i++) {
            print '<div class="calendar-row calendar-body-row">';
            print '<div class="time-col"><span class="time-label">' . $i . ':00</span></div>';
            print '<div class="master-col"></div>';
            print '<div class="master-col"></div>';
            print '<div class="master-col"></div>';
            print '<div class="master-col"></div>';
            print '<div class="master-col"></div>';
            print '</div>';

            print '<div class="calendar-row calendar-body-row">';
            print '<div class="time-col"></div>';
            print '<div class="master-col"></div>';
            print '<div class="master-col"></div>';
            print '<div class="master-col"></div>';
            print '<div class="master-col"></div>';
            print '<div class="master-col"></div>';
            print '</div>';
        }
        ?>

        <div class="calendar-events">
            <a href="#modal-more-info" rel="nofollow" class="openmodal">
                <div class="reservation-info-block" data-time="8:00" data-master_num="1" data-duration="90">
                    <h3>Название услуги</h3>
                    <div class="service-meta-info">
                        <span class="time">14:30</span>
                        <span class="duration">1 ч 30 мин</span>
                    </div>
                    <div class="client-info">
                        <h3>Клиент</h3>
                        <span class="name">Имя клиента</span>
                        <span class="phone">+7 (999) 999-99-99</span>
                        <span class="email">mail@example.com</span>
                    </div>
                </div>
            </a>
            <a href="#modal-more-info" rel="nofollow" class="openmodal">
                <div class="reservation-info-block" data-time="15:00" data-master_num="1" data-duration="150">
                    <h3>Название услуги</h3>
                    <div class="service-meta-info">
                        <span class="time">15:00</span>
                        <span class="duration">2 ч 30 мин</span>
                    </div>
                    <div class="client-info">
                        <h3>Клиент</h3>
                        <span class="name">Имя клиента</span>
                        <span class="phone">+7 (999) 999-99-99</span>
                        <span class="email">mail@example.com</span>
                    </div>
                </div>
            </a>
            <a href="#modal-more-info" rel="nofollow" class="openmodal">
                <div class="reservation-info-block" data-time="10:00" data-master_num="2" data-duration="90">
                    <h3>Название услуги</h3>
                    <div class="service-meta-info">
                        <span class="time">10:00</span>
                        <span class="duration">1 ч 30 мин</span>
                    </div>
                    <div class="client-info">
                        <h3>Клиент</h3>
                        <span class="name">Имя клиента</span>
                        <span class="phone">+7 (999) 999-99-99</span>
                    </div>
                </div>
            </a>
            <a href="#modal-more-info" rel="nofollow" class="openmodal">
                <div class="reservation-info-block" data-time="17:30" data-master_num="1" data-duration="60">
                    <h3>Название услуги</h3>
                    <div class="service-meta-info">
                        <span class="time">17:30</span>
                        <span class="duration">1 ч</span>
                    </div>
                    <div class="client-info">
                        <h3>Клиент</h3>
                        <span class="name">Имя клиента</span>
                        <span class="phone">+7 (999) 999-99-99</span>
                        <span class="email">mail@example.com</span>
                    </div>
                </div>
            </a>
            <a href="#modal-more-info" rel="nofollow" class="openmodal">
                <div class="reservation-info-block" data-time="15:30" data-master_num="3" data-duration="30">
                    <h3>Очень длинное название услуги</h3>
                    <div class="service-meta-info">
                        <span class="time">15:30</span>
                        <span class="duration">30 мин</span>
                    </div>
                    <div class="client-info">
                        <h3>Клиент</h3>
                        <span class="name">Имя клиента</span>
                        <span class="phone">+7 (999) 999-99-99</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>

<div id="modal-export" class="modal">
    <header>
        <h6>Экспорт журнала</h6>
        <img src="/images/close-ico.png" class="modal-close">
    </header>

    <main>
        <input style="position: absolute; opacity: 0; z-index: -1">

        <div class="modal-row">
            <span class="modal-row-name">Начало периода:</span>
            <div class="modal-row-content">
                <input type="text" name="export-start-date" value="12.09.2019" class="date">
                <input type="text" name="export-start-time" value="12:00" class="time">
            </div>
        </div>
        <div class="modal-row">
            <span class="modal-row-name">Конец периода:</span>
            <div class="modal-row-content">
                <input type="text" name="export-end-date" class="empty date">
                <input type="text" name="export-end-time" class="empty time">
            </div>
        </div>
        <div class="modal-row">
            <span class="modal-row-name">Салон:</span>
            <div class="modal-row-content">
                <ul>
                    <li class="modal-add-item">Добавить</li> <!-- Скрывать, если класс empty -->
                </ul>
            </div>
        </div>
        <div class="modal-row">
            <span class="modal-row-name">Мастер:</span>
            <div class="modal-row-content">
                <ul>
                    <li>Master 1</li>
                    <li>Master 2</li>
                    <a href="#modal-choosing-master" rel="nofollow" class="openmodal"><li class="modal-add-item">Добавить</li></a>
                </ul>
            </div>
        </div>
        <div class="modal-row">
            <span class="modal-row-name">Услуга:</span>
            <div class="modal-row-content">
                <ul>
                    <li>Service 1</li>
                    <li>Service 2</li>
                    <li>Service 3</li>
                    <li>Service 4</li>
                    <li>Service 5</li>
                    <li>Service 6</li>
                    <li>Service 7</li>
                    <li>Service 8</li>
                    <li>Service 9</li>
                    <li>Service 10</li>
                    <li>Service 11</li>
                    <li>Service 12</li>
                    <li>Service 13</li>
                    <li>Service 14</li>
                    <li>Service 15</li>
                    <li>Service 16</li>
                    <li>Service 17</li>
                    <li>Service 18</li>
                    <li>Service 19</li>
                    <a href="#modal-choosing-service" rel="nofollow" class="openmodal"><li class="modal-add-item">Добавить</li></a>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <button class="modal-ok-btn">Экспортировать</button>
        <button class="modal-cancel-btn modal-close">Отменить</button>
    </footer>
</div>
<div id="modal-creating-new" class="modal">
    <header>
        <h6>Создание новой записи</h6>
        <img src="/images/close-ico.png" class="modal-close">
    </header>

    <main>
        <input style="position: absolute; opacity: 0; z-index: -1">

        <div class="modal-row">
            <span class="modal-row-name">Время:</span>
            <div class="modal-row-content">
                <input type="text" name="reservation-date" class="empty date" placeholder="1.01.2020">
                <input type="text" name="reservation-time" class="empty time" placeholder="12:00">
            </div>
        </div>
        <div class="modal-row">
            <span class="modal-row-name">Салон:</span>
            <div class="modal-row-content">
                <input type="text" name="location_name" class="empty address" placeholder="Выберите салон">
            </div>
        </div>
        <div class="modal-row">
            <span class="modal-row-name">Услуга:</span>
            <div class="modal-row-content">
                <a href="#modal-choosing-service" rel="nofollow" class="openmodal"><input type="text" name="service_name" class="empty service" placeholder="Выберите услугу"></a>
            </div>
        </div>
        <div class="modal-row">
            <span class="modal-row-name">Мастер:</span>
            <div class="modal-row-content">
                <a href="#modal-choosing-master" rel="nofollow" class="openmodal"><input type="text" name="master_name" class="empty person" placeholder="Выберите мастера"></a>
            </div>
        </div>
        <div class="modal-row">
            <span class="modal-row-name">Клиент:</span>
            <div class="modal-row-content">
                <input type="text" name="client_name" class="empty name" placeholder="Имя клиента">
                <input type="text" name="client_phone" class="empty phone" placeholder="Номер телефона клиента">
                <input type="text" name="client_email" class="empty email" placeholder="Email клиента">
            </div>
        </div>
    </main>

    <footer>
        <button class="modal-ok-btn">Записать</button>
        <button class="modal-cancel-btn modal-close">Отменить</button>
    </footer>
</div>
<div id="modal-more-info" class="modal">
    <header>
        <h6>Название услуги</h6>
        <img src="/images/close-ico.png" class="modal-close">
    </header>

    <main>
        <div class="modal-row">
            <span class="modal-row-name">Время:</span>
            <div class="modal-row-content">
                <span class="date">29.09.2019 12:00</span>
                <span class="duration">1 ч 30 мин</span>
            </div>
        </div>
        <div class="modal-row">
            <span class="modal-row-name">Клиент:</span>
            <div class="modal-row-content">
                <span class="name">Имя клиента</span>
                <span class="phone">+7 (999) 999-99-99</span>
                <span class="email">mail@example.com</span>
            </div>
        </div>
        <div class="modal-row">
            <span class="modal-row-name">Мастер:</span>
            <div class="modal-row-content">
                <span class="name">Имя мастера</span>
                <span class="address">ул. Тульская, д. 8</span>
                <span class="phone">+7 (999) 999-99-99</span>
                <span class="email">master@example.com</span>
            </div>
        </div>
    </main>

    <footer>
        <button class="modal-ok-btn">Изменить</button>
        <button class="modal-cancel-btn modal-close">Отменить</button>
    </footer>
</div>
<div id="modal-choosing-service" class="modal modal-selection-form">
    <header>
        <h6>Выбор услуги</h6>
        <img src="/images/close-ico.png" class="modal-close">
    </header>

    <main>
        <input type="text" name="search_field" placeholder="Начните набирать название услуги…">

        <div class="variants">
            <div class="variants-group">
                <span class="variants-group-header">Название категории услуг</span>
                <ul>
                    <li>Услуга 1</li>
                    <li>Услуга 2</li>
                    <li>Услуга 3</li>
                    <li>Услуга 4</li>
                    <li>Услуга 5</li>
                    <li>Услуга 6</li>
                    <li>Услуга 7</li>
                    <li class="selected">Услуга 8</li>
                    <li>Услуга 9</li>
                    <li>Услуга 10</li>
                </ul>
            </div>
            <div class="variants-group">
                <span class="variants-group-header">Название категории услуг</span>
                <ul>
                    <li>Услуга 1</li>
                    <li>Услуга 2</li>
                    <li>Услуга 3</li>
                    <li>Услуга 4</li>
                </ul>
            </div>
            <div class="variants-group">
                <span class="variants-group-header">Название категории услуг</span>
                <ul>
                    <li>Услуга 1</li>
                    <li>Услуга 2</li>
                    <li>Услуга 3</li>
                    <li>Услуга 4</li>
                    <li>Услуга 5</li>
                    <li>Услуга 6</li>
                    <li>Услуга 7</li>
                    <li>Услуга 8</li>
                    <li>Услуга 9</li>
                    <li>Услуга 10</li>
                </ul>
            </div>
            <div class="variants-group">
                <span class="variants-group-header">Название категории услуг</span>
                <ul>
                    <li>Услуга 1</li>
                    <li>Услуга 2</li>
                    <li>Услуга 3</li>
                    <li>Услуга 4</li>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <button class="modal-ok-btn">Выбрать</button> <!-- Имеет смысл только при множественном выборе -->
        <button class="modal-cancel-btn modal-close">Отменить</button>
    </footer>
</div>
<div id="modal-choosing-master" class="modal modal-selection-form">
    <header>
        <h6>Выбор мастера</h6>
        <img src="/images/close-ico.png" class="modal-close">
    </header>

    <main>
        <input type="text" name="search_field" placeholder="Начните набирать имя мастера или филиала…">

        <div class="variants">
            <div class="variants-group">
                <span class="variants-group-header">Название филиала</span>
                <ul>
                    <li>Мастер 1</li>
                    <li>Мастер 2</li>
                    <li>Мастер 3</li>
                    <li>Мастер 4</li>
                    <li>Мастер 5</li>
                    <li>Мастер 6</li>
                    <li>Мастер 7</li>
                    <li class="selected">Мастер 8</li>
                    <li>Мастер 9</li>
                    <li>Мастер 10</li>
                </ul>
            </div>
            <div class="variants-group">
                <span class="variants-group-header">Название филиала</span>
                <ul>
                    <li>Мастер 1</li>
                    <li>Мастер 2</li>
                    <li>Мастер 3</li>
                    <li>Мастер 4</li>
                </ul>
            </div>
            <div class="variants-group">
                <span class="variants-group-header">Название филиала</span>
                <ul>
                    <li>Мастер 1</li>
                    <li>Мастер 2</li>
                    <li>Мастер 3</li>
                    <li>Мастер 4</li>
                    <li>Мастер 5</li>
                    <li>Мастер 6</li>
                    <li>Мастер 7</li>
                    <li>Мастер 8</li>
                    <li>Мастер 9</li>
                    <li>Мастер 10</li>
                </ul>
            </div>
            <div class="variants-group">
                <span class="variants-group-header">Название филиала</span>
                <ul>
                    <li>Мастер 1</li>
                    <li>Мастер 2</li>
                    <li>Мастер 3</li>
                    <li>Мастер 4</li>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <button class="modal-ok-btn">Выбрать</button> <!-- Имеет смысл только при множественном выборе -->
        <button class="modal-cancel-btn modal-close">Отменить</button>
    </footer>
</div>



































