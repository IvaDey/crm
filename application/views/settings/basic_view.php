<div id="locations_list">
    <h2>Филиалы</h2>
    <ul>
        <?php
        foreach ($data['locations'] as $location)
        {
            print '<li data-location_id="'.$location->id.'" data-location_address="'.$location->address.'">'.$location->name.'</li>';
        }
        ?>
    </ul>
    <button>Добавить</button>
</div>

<div id="services">
    <div id="categories_list">
        <h2>Категории услуг</h2>
        <ul>
            <?php
            foreach ($data['service_categories'] as $category)
            {
                print '<li data-category_id="'.$category->id.'">'.$category->name.'</li>';
            }
            ?>
        </ul>
        <button>Добавить</button>
    </div>

    <div id="services_list">
        <h2>Список услуг</h2>
         <p class="alert-center">Выберите категорию или создайте услугу</p>
        <button>Добавить</button>
    </div>
</div>

<div id="masters">
    <div id="masters_list">
        <h2>Список сотрудников</h2>
        <ul>
            <?php
            foreach ($data['masters'] as $master)
            {
                print '<li data-master_id="'.$master->id.'" data-master_name="'.$master->name.'" data-master_description="'.$master->description.'">'
                    .'<img src="/images/masters/'.$master->photo.'">'
                    .$master->name.'</li>';
            }
            ?>
        </ul>
        <button>Добавить</button>
    </div>

    <div id="master_info">
        <h2>Подробная информация</h2>

        <p class="alert-center">Выберите мастера или добавьте нового</p>

        <div class="general_info">
            <div class="master_avatar">
                <img src="/images/masters/default.png">
                <input type="file" name="master_avatar" accept="image/jpeg, image/gif, image/png">
                <p>Изменить</p>
            </div>

            <div class="general_info_body">
                <span>Имя:</span><input type="text" name="name" placeholder="Имя сотрудника">
                <span>Подробнее:</span><textarea placeholder="Информация о сотруднике"></textarea>
                <span>Филиал:</span>
                <select name="location_id">
                    <?php
                    foreach ($data['locations'] as $location)
                    {
                        print '<option value="'.$location->id.'">'.$location->name.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="working_hours">
            <h3>Время работы:</h3>
<!--            <label><input type="checkbox" checked> Совпадает со временем работы салона</label>-->

            <div>
                <span class="day_name">Понедельник</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[1]"> до <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[1]"></span>
                <span class="day_name">Вторник</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[2]"> до <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[2]"></span>
                <span class="day_name">Среда</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[3]"> до <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[3]"></span>
                <span class="day_name">Четверг</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[4]"> до <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[4]"></span>
                <span class="day_name">Пятница</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[5]"> до <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[5]"></span>
                <span class="day_name">Суббота</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[6]"> до <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[6]"></span>
                <span class="day_name">Воскресенье</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[7]"> до <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[7]"></span>
            </div>
        </div>

        <div id="bottom-master-right-column">
            <div id="gcalendar">
                <h3>Персональный календарь</h3>
                <p>Персональный календарь не создан. <a>Создать</a></p>
            </div>

            <div class="master_specialisations">
                <h3>Специализации:</h3>

                <?php
    //            <div class="specialisation_row">
    //                <span data-category_id="1">Lorem ipsum dolor</span>
    //                <img src="/images/close.png">
    //            </div>
    //            <div class="specialisation_row">
    //                <span data-category_id="2">Lorem ipsum dolor</span>
    //                <img src="/images/close.png">
    //            </div>
                ?>

                <select>
                    <option value="0" disabled>Добавить</option>
                    <?php
                    foreach ($data['service_categories'] as $category)
                    {
                        print '<option value="'.$category->id.'">'.$category->name.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="buttons">
            <button class="save">Сохранить</button>
            <button class="delete">Удалить</button>
            <button class="cancel">Отменить</button>
        </div>

        <div id="deleting-master-apply" class="modal" title="Подтвердите удаление">
            <p>
                Подтвердите удаление карточки сотрудника – данное действие нельзя будет отменить<br>
                Данные о записях к данному сотруднику будут сохраненны, в том числе предстоящие
            </p>
            <label><input type="checkbox" name="delete_calendar" checked>Удалить персональный календарь в google аккаунте салона</label>
        </div>
    </div>
</div>

<!-- Модальные окна -->
<!-- Добавление новой / редактирирование существующей категории -->
<div class="modal" id="category_editor" title="Новая категория">
    <span>Название:</span>
    <input type="text" name="name" placeholder="Названине категории">
    <input type="hidden" name="category_id" value="">
</div>

<!-- Добавление нового / редактирование существующего филиала -->
<div class="modal" id="location_editor" title="Новый филиал">
    <span>Название:</span>
    <input type="text" name="name" placeholder="Названине филиала">
    <input type="hidden" name="location_id" value="">

    <span>Адрес:</span><br>
    <textarea placeholder="Адрес филиала"></textarea>

    <div class="working_hours">
        <h3>Время работы:</h3>

        <div>
            <span class="day_name">Понедельник</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[1]"> по <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[1]"></span>
            <span class="day_name">Вторник</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[2]"> по <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[2]"></span>
            <span class="day_name">Среда</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[3]"> по <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[3]"></span>
            <span class="day_name">Четверг</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[4]"> по <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[4]"></span>
            <span class="day_name">Пятница</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[5]"> по <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[5]"></span>
            <span class="day_name">Суббота</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[6]"> по <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[6]"></span>
            <span class="day_name">Воскресенье</span><span class="day_working_hours">с <input type="text" class="time_start" autocomplete="off" name="working_start[7]"> по <input type="text" class="time_end" autocomplete="off" autocomplete="off" autocomplete="off" name="working_end[7]"></span>
        </div>
    </div>
</div>


<!-- Добавление новой / редактировароние существующей услуги -->
<div class="modal" id="service_editor" title="Новая услуга">
    <span>Название:</span>
    <input type="text" name="name" placeholder="Названине услуги">
    <input type="hidden" name="service_id" value="">

    <span>Описание:</span><br>
    <textarea placeholder="Описание услуги"></textarea><br>

    <span>Категория:</span><br>
    <select name="category_id">
        <?php
        foreach ($data['service_categories'] as $category)
        {
            print '<option value="'.$category->id.'">'.$category->name.'</option>';
        }
        ?>
    </select><br>

    <span>Стоимость:</span>
    <input type="text" name="price" placeholder="1000"> руб<br>

    <span>Длительность:</span>
    <input type="text" name="duration" placeholder="45"> мин
</div>































