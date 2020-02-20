<div class="boxes">
    <section id="revenue-box" class="box-content">
        <h2>Выручка</h2>
        <table>
            <tr>
                <td>Сегодня</td>
                <td>100 руб. <span>(- 2,1%)</span></td>
            </tr>
            <tr>
                <td>Вчера</td>
                <td>100 руб.</td>
            </tr>
            <tr>
                <td>За неделю</td>
                <td>100 руб. <span>(+ 9,3%)</span></td>
            </tr>
            <tr>
                <td>За месяц</td>
                <td>100 руб. <span>(–)</span></td>
            </tr>
        </table>
        <canvas id="revenue-chart"></canvas>
        <div class="chartjs-tooltip" id="tooltip-0"></div>
    </section>

    <section id="visits-box" class="box-content">
        <h2>Количество визитов</h2>
        <table>
            <tr>
                <td>Сегодня</td>
                <td>100 руб. <span>(- 2,1%)</span></td>
            </tr>
            <tr>
                <td>Вчера</td>
                <td>100 руб.</td>
            </tr>
            <tr>
                <td>За неделю</td>
                <td>100 руб. <span>(+ 9,3%)</span></td>
            </tr>
            <tr>
                <td>За месяц</td>
                <td>100 руб. <span>(–)</span></td>
            </tr>
        </table>
        <canvas id="visits-chart"></canvas>
    </section>
</div>

<section id="closest-reservations" class="box-content">
    <div class="calendar">
        <div class="calendar-header">
            <h2>Предстоящие записи</h2>
            <span class="date">14 сентября 2019</span>
            <a href="#modal-creating-new" rel="nofollow" class="openmodal"><button id="add-event">Создать</button></a>
        </div>

        <div class="calendar-body">
            <?php
            for ($i = 8; $i < 24; $i++) {
                print '<div class="calendar-row calendar-body-row' . ($i == 8 ? ' calendar-first-row' : '') . '">';
                print '<div class="time-col"><span class="time-label">' . $i . ':00</span></div>';
                print '<div class="event-col"></div>';
                print '</div>';

                print '<div class="calendar-row calendar-body-row">';
                print '<div class="time-col"></div>';
                print '<div class="event-col"></div>';
                print '</div>';
            }
            ?>

            <div class="calendar-events" data-masters_count="3">
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
                        <div class="master-info">
                            <h3>Мастер</h3>
                            <span class="name">Имя мастера</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                        </div>
                    </div>
                </a>
                <a href="#modal-more-info" rel="nofollow" class="openmodal">
                    <div class="reservation-info-block" data-time="8:30" data-master_num="2" data-duration="90">
                        <h3>Название услуги</h3>
                        <div class="service-meta-info">
                            <span class="time">8:30</span>
                            <span class="duration">1 ч 30 мин</span>
                        </div>
                        <div class="client-info">
                            <h3>Клиент</h3>
                            <span class="name">Имя клиента</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                            <span class="email">mail@example.com</span>
                        </div>
                        <div class="master-info">
                            <h3>Мастер</h3>
                            <span class="name">Имя мастера</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                        </div>
                    </div>
                </a>
                <a href="#modal-more-info" rel="nofollow" class="openmodal">
                    <div class="reservation-info-block" data-time="8:00" data-master_num="3" data-duration="60">
                        <h3>Название услуги</h3>
                        <div class="service-meta-info">
                            <span class="time">8:00</span>
                            <span class="duration">1 ч</span>
                        </div>
                        <div class="client-info">
                            <h3>Клиент</h3>
                            <span class="name">Имя клиента</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                            <span class="email">mail@example.com</span>
                        </div>
                        <div class="master-info">
                            <h3>Мастер</h3>
                            <span class="name">Имя мастера</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                        </div>
                    </div>
                </a>
                <a href="#modal-more-info" rel="nofollow" class="openmodal">
                    <div class="reservation-info-block" data-time="15:30" data-master_num="1" data-duration="150">
                        <h3>Название услуги</h3>
                        <div class="service-meta-info">
                            <span class="time">15:30</span>
                            <span class="duration">2 ч 30 мин</span>
                        </div>
                        <div class="client-info">
                            <h3>Клиент</h3>
                            <span class="name">Имя клиента</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                            <span class="email">mail@example.com</span>
                        </div>
                        <div class="master-info">
                            <h3>Мастер</h3>
                            <span class="name">Имя мастера</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                        </div>
                    </div>
                </a>
                <a href="#modal-more-info" rel="nofollow" class="openmodal">
                    <div class="reservation-info-block" data-time="14:30" data-master_num="1" data-duration="60">
                        <h3>Название услуги</h3>
                        <div class="service-meta-info">
                            <span class="time">14:30</span>
                            <span class="duration">1 ч</span>
                        </div>
                        <div class="client-info">
                            <h3>Клиент</h3>
                            <span class="name">Имя клиента</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                            <span class="email">mail@example.com</span>
                        </div>
                        <div class="master-info">
                            <h3>Мастер</h3>
                            <span class="name">Имя мастера</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                        </div>
                    </div>
                </a>
                <a href="#modal-more-info" rel="nofollow" class="openmodal">
                    <div class="reservation-info-block" data-time="11:30" data-master_num="2" data-duration="30">
                        <h3>Название услуги</h3>
                        <div class="service-meta-info">
                            <span class="time">11:30</span>
                            <span class="duration">30 мин</span>
                        </div>
                        <div class="client-info">
                            <h3>Клиент</h3>
                            <span class="name">Имя клиента</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                            <span class="email">mail@example.com</span>
                        </div>
                        <div class="master-info">
                            <h3>Мастер</h3>
                            <span class="name">Имя мастера</span>
                            <span class="phone">+7 (999) 999-99-99</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="calendar-events">
            <div class="calendar-event"></div>
        </div>
    </div>
</section>

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