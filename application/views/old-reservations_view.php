<div id="tabs">
    <span id="tab-reservations_list" class="selected">Журнал записей</span>
    <span id="tab-creating_reservation">Добавить запись</span>
</div>

<div id="tabs-content">
    <div class="tab-body selected" id="body-reservations_list">
        <h2>Все записи</h2>

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

        <table>
            <thead>
            <tr>
                <th rowspan="2">ID</th>
                <th rowspan="2">Дата</th>
                <th rowspan="2">Услуга</th>
                <th rowspan="2">Мастер</th>
                <th colspan="3">Клиент</th>
                <th rowspan="2">Длительность</th>
                <th rowspan="2">Действия</th>
            </tr>
            <tr>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Email</th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($data['reservations_list'] as $reservation) {
                $h = intdiv($reservation['total_duration'], 60);
                $m = $reservation['total_duration'] % 60;
                $total_duration = ($h ? $h . ' ч ' : '') . ($m ? $m . ' мин' : '');
                $reservation_row = "<tr>
                        <td rowspan=\"{$reservation['services_count']}\">{$reservation['reservation_id']}</td>
                        <td rowspan=\"{$reservation['services_count']}\">{$reservation['reservation_date']['date']} {$reservation['reservation_date']['time']}</td>
                        <td>{$reservation['services'][0]['name']}</td>
                        <td rowspan=\"{$reservation['services_count']}\">{$reservation['master']['name']}</td>
                        <td rowspan=\"{$reservation['services_count']}\">{$reservation['client']['name']}</td>
                        <td rowspan=\"{$reservation['services_count']}\">{$reservation['client']['phone']}</td>
                        <td rowspan=\"{$reservation['services_count']}\">{$reservation['client']['email']}</td>
                        <td rowspan=\"{$reservation['services_count']}\">{$total_duration}</td>
                        <td rowspan=\"{$reservation['services_count']}\"><button></button></td>
                    </tr>";

                for ($i = 1; $i < $reservation['services_count']; $i++) {
                    $reservation_row .= "
                    <tr>
                        <td>{$reservation['services'][$i]['name']}</td>
                    </tr>";
                }

                print $reservation_row;
            }
            ?>
            </tbody>
        </table>
    </div>

    <div class="tab-body" id="body-creating_reservation">
        <div id="new-reservation_date">
            <h2>Дата и время записи</h2>

            <div class="location_info">
                <span class="label">Филиал:</span><br>
                <select name="location_id" size="5">
                    <?php
                    foreach ($data['locations'] as $location) {
                        print '<option value="' . $location->id . '">' . $location->name . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="date_info">
                <span class="label">Дата:</span><br>
                <div class="calendar">
                    <input type="hidden" name="date">
                </div>
            </div>

            <div class="time_info">
                <span class="label">Время:</span><br>

                <div class="time_variants_row">
                    <label><input type="radio" name="time" value="9:00"><div class="time_variant">9:00</div></label>
                    <label><input type="radio" name="time" value="9:30"><div class="time_variant">9:30</div></label>
                    <label><input type="radio" name="time" value="10:00"><div class="time_variant">10:00</div></label>
                    <label><input type="radio" name="time" value="10:30"><div class="time_variant">10:30</div></label>
                    <label><input type="radio" name="time" value="11:00"><div class="time_variant">11:00</div></label>
                </div>
                <div class="time_variants_row">
                    <label><input type="radio" name="time" value="11:30"><div class="time_variant">11:30</div></label>
                    <label><input type="radio" name="time" value="12:00"><div class="time_variant">12:00</div></label>
                    <label><input type="radio" name="time" value="12:30"><div class="time_variant">12:30</div></label>
                    <label><input type="radio" name="time" value="13:00"><div class="time_variant">13:00</div></label>
                    <label><input type="radio" name="time" value="13:30"><div class="time_variant">13:30</div></label>
                </div>
                <div class="time_variants_row">
                    <label><input type="radio" name="time" value="14:00"><div class="time_variant">14:00</div></label>
                    <label><input type="radio" name="time" value="14:30"><div class="time_variant">14:30</div></label>
                    <label><input type="radio" name="time" value="15:00"><div class="time_variant">15:00</div></label>
                    <label><input type="radio" name="time" value="15:30"><div class="time_variant">15:30</div></label>
                    <label><input type="radio" name="time" value="16:00"><div class="time_variant">16:00</div></label>
                </div>
                <div class="time_variants_row">
                    <label><input type="radio" name="time" value="16:30"><div class="time_variant">16:30</div></label>
                    <label><input type="radio" name="time" value="17:00"><div class="time_variant">17:00</div></label>
                    <label><input type="radio" name="time" value="17:30"><div class="time_variant">17:30</div></label>
                    <label><input type="radio" name="time" value="18:00"><div class="time_variant">18:00</div></label>
                    <label><input type="radio" name="time" value="18:30"><div class="time_variant">18:30</div></label>
                </div>
                <div class="time_variants_row">
                    <label><input type="radio" name="time" value="19:00"><div class="time_variant">19:00</div></label>
                    <label><input type="radio" name="time" value="19:30"><div class="time_variant">19:30</div></label>
                    <label><input type="radio" name="time" value="20:00"><div class="time_variant">20:00</div></label>
                    <label><input type="radio" name="time" value="20:30"><div class="time_variant">20:30</div></label>
                    <label><input type="radio" name="time" value="21:00"><div class="time_variant">21:00</div></label>
                </div>
            </div>
        </div>

        <div id="new-services_info">
            <h2>Информация об услугах</h2>

            <table>
                <thead>
                <tr>
                    <th>Категория</th>
                    <th>Услуга</th>
                    <th>Сотрудник</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr class="service_editing_row_template ui-helper-hidden">
                    <td data-category_id="1">
                        <select name="category_id">
                            <option selected disabled>Выберите категорию</option>
                            <?php
                            foreach ($data['services_categories'] as $services_category) {
                                print '<option value="' . $services_category->id . '">' . $services_category->name . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td data-service_id="1">
                        <select name="service_id">
                            <option selected disabled>Выберите услугу</option>
                        </select>
                    </td>
                    <td data-master_id="1">
                        <select name="master_id">
                            <option selected disabled>Выберите мастера</option>
                        </select>
                    </td>
                    <td class="ctrl-btn">
                        <button class="save-button" title="Сохранить"></button>
                        <button class="cancel-button" title="Отменить"></button>
                    </td>
                </tr>
                </tbody>
            </table>

            <button id="add_service">Добавить услугу</button>
        </div>

        <div id="new-client_info">
            <h2>Информация о клиенте</h2>

            <label>
                Имя:<br>
                <input type="text" name="name" placeholder="Имя клиента">
            </label>
            <label>
                Телефон:<br>
                <input type="phone" name="phone" placeholder="Телефон клиента">
            </label>
            <label>
                Email:<br>
                <input type="email" name="email" placeholder="Email клиента">
            </label>
        </div>

        <button id="add_reservation">Создать запись</button>
    </div>
</div>

<div id="load-modal-ico">
    <img src="/images/ajax-load-ico.gif">
</div>




































