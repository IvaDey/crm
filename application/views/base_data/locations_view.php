<section id="locations">
    <div class="list">
        <input type="text" name="locationSearchFiled" id="locationSearchFiled" placeholder="Поиск...">
        <ul>
            <li class="selected">Selected item</li>
            <?php
            foreach ($data['locations'] as $location)
            {
                print '<li data-location_id="'.$location->id.'" data-location_address="'.$location->address.'">'.$location->name.'</li>';
            }
            ?>
        </ul>

        <button>Добавить</button>
    </div>

    <form autocomplete="off" class="list_info">
        <h2>
            Название локации
            <img src="/images/edit.png" id="edit-location-info">
        </h2>

        <div>
            <div class="form-row readonly">
                <span class="c1">Название</span>
                <input class="c2 readonly" readonly type="text" name="locationName" placeholder="Название">
                <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
            </div>

            <div class="form-row readonly">
                <span class="c1">Описание</span>
                <textarea autocomplete="off" class="c2 readonly" readonly type="text" name="locationDescription" placeholder="Описание"></textarea>
                <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
            </div>

            <div class="form-row readonly">
                <span class="c1">Адрес</span>
                <input autocomplete="off" class="c2 readonly" readonly type="text" name="locationAddress" placeholder="Адрес">
                <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
            </div>
        </div>

        <div class="working-hours readonly">
            <h3>Время работы</h3>

            <div class="days-working-hours readonly">
                <ul>
                    <li id="day-1">Пн</li>
                    <li id="day-3">Ср</li>
                </ul>

                <div class="working-hours-range">
                    c <span class="start">9:00</span> до <span class="end">21:00</span>
                </div>

                <div class="working-hours-scale">
                    <span class="start">00:00</span>
                    <div class="working-hours-scale-body">
                        <span class="start">9:00</span>
                        <span class="end">21:00</span>
                        <div class="start-time"></div>
                        <div class="end-time"></div>
                    </div>
                    <span class="end">23:59</span>
                </div>
            </div>

            <div class="days-working-hours readonly">
                <ul>
                    <li id="day-2">Вт</li>
                    <li id="day-4">Чт</li>
                </ul>

                <div class="working-hours-range">
                    c <span class="start">9:00</span> до <span class="end">21:00</span>
                </div>

                <div class="working-hours-scale">
                    <span class="start">00:00</span>
                    <div class="working-hours-scale-body">
                        <span class="start">9:00</span>
                        <span class="end">21:00</span>
                        <div class="start-time"></div>
                        <div class="end-time"></div>
                    </div>
                    <span class="end">23:59</span>
                </div>
            </div>

            <div class="days-working-hours readonly">
                <ul>
                    <li id="day-5">Пт</li>
                </ul>

                <div class="working-hours-range">
                    c <span class="start">9:00</span> до <span class="end">21:00</span>
                </div>

                <div class="working-hours-scale">
                    <span class="start">00:00</span>
                    <div class="working-hours-scale-body">
                        <span class="start">9:00</span>
                        <span class="end">21:00</span>
                        <div class="start-time"></div>
                        <div class="end-time"></div>
                    </div>
                    <span class="end">23:59</span>
                </div>
            </div>

            <button class="add-day">Добавить</button>
            <ul id="days-list">
                <li>Понедельник</li>
                <li>Вторник</li>
                <li>Среда</li>
                <li class="disabled">Четверг</li>
                <li>Пятница</li>
                <li>Суббота</li>
                <li>Воскресенье</li>
            </ul>
        </div>

        <div class="employees-list readonly">
            <h3>Сотрудники</h3>

            <div class="employee">
                <button class="remove"></button>

                <img src="/images/masters/default.png">
                <h4 class="name">Ivan Ivanov</h4>
                <span class="role">Парикмахер-стилист</span>
                <p>
                    Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.
                </p>
            </div>

            <div class="employee">
                <button class="remove"></button>

                <img src="/images/masters/master_1.png">
                <h4 class="name">Ivan Ivanov</h4>
                <span class="role">Парикмахер-стилист</span>
                <p>
                    Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.
                </p>
            </div>

            <div class="employee">
                <button class="remove"></button>

                <img src="/images/masters/master_2.png">
                <h4 class="name">Ivan Ivanov</h4>
                <span class="role">Парикмахер-стилист</span>
                <p>
                    Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.
                </p>
            </div>

            <div class="employee">
                <button class="remove"></button>

                <img src="/images/masters/master_3.png">
                <h4 class="name">Ivan Ivanov</h4>
                <span class="role">Парикмахер-стилист</span>
                <p>
                    Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.
                </p>
            </div>

            <div class="employee">
                <button class="remove"></button>

                <img src="/images/masters/master_4.jpg">
                <h4 class="name">Ivan Ivanov</h4>
                <span class="role">Парикмахер-стилист</span>
                <p>
                    Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.
                </p>
            </div>

            <button id="add-employee">Добавить</button>
        </div>
    </form>
</section>




