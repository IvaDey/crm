<div id="tabs">
    <span id="tab-users" class="selected">Пользователи</span>
    <span id="tab-clients">Клиенты</span>
</div>

<div id="tabs-content">
    <div class="tab-body selected" id="body-users">
        <h2>Пользователи – клиенты, зарегистрированные в системе</h2>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Дата регистрации</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($data['usersList']['list'] as $reservation) {
                $monthsName = Array('янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек');
                $registration_date = strtotime($reservation->registration_date);
                $registration_date = date('j', $registration_date) . ' ' . $monthsName[date('n', $registration_date) - 1] . ' ' . date('Y', $registration_date);
                $reservation_row = "<tr>
                        <td>{$reservation->id}</td>
                        <td>{$registration_date}</td>
                        <td>{$reservation->name}</td>
                        <td>{$reservation->surname}</td>
                        <td>{$reservation->phone}</td>
                        <td>{$reservation->email}</td>
                        <td><button></button></td>
                    </tr>";

                print $reservation_row;
            }
            ?>
            </tbody>
        </table>

        <div class="paginator">
            <button class="prev_page">Назад</button>

            <?php
            for ($i = 1; $i <= $data['usersList']['pages_count']; $i++) {
                if ($i == 1)
                    print '<button class="page_number selected">' . $i . '</button>';
                else print '<button class="page_number">' . $i . '</button>';
            }
            ?>

            <button class="next_page">Вперед</button>
        </div>
    </div>

    <div class="tab-body" id="body-clients">
        <h2>Клиенты – не прошедшие процедуру регистрации</h2>

        <table>
            <thead>
            <tr>
                <th rowspan="2">ID</th>
                <th rowspan="2">Имя</th>
                <th rowspan="2">Телефон</th>
                <th rowspan="2">Email</th>
                <th colspan="3">Услуга</th>
            </tr>
            <tr>
                <th>Дата</th>
                <th>Услуга</th>
                <th>Стоимость</th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($data['clientsList']['list'] as $client) {
                if ($client->total_cost) {
                    $total_cost = number_format($client->total_cost, 0, '.', ' ') . ' руб';
                } else {
                    $total_cost = '';
                }
                $reservation_row = "<tr>
                        <td>{$client->id}</td>
                        <td>{$client->name}</td>
                        <td>{$client->phone}</td>
                        <td>{$client->email}</td>
                        <td>{$client->reservation_date}</td>
                        <td>{$client->service_name}</td>
                        <td>{$total_cost}</td>
                    </tr>";

                print $reservation_row;
            }
            ?>
            </tbody>
        </table>

        <div class="paginator">
            <button class="prev_page">Назад</button>

            <?php
            for ($i = 1; $i <= $data['clientsList']['pages_count']; $i++) {
                if ($i == 1)
                    print '<button class="page_number selected">' . $i . '</button>';
                else print '<button class="page_number">' . $i . '</button>';
            }
            ?>

            <button class="next_page">Вперед</button>
        </div>
    </div>
</div>




































