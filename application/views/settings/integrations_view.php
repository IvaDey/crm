<section id="gcalendar-integration">
    <h2>Интеграция с гугл календарем</h2>
    <?php
    if ($data['gcalendar']['is_authorized'])
        echo '<p>Current account: ' . $data['gcalendar']['is_authorized'] . '</p>';
    else echo '<p>Not integrated</p>';
    ?>
    <button id="gcalander-open-settings">Настроить</button>

    <div id="gcalendar-settings-modal" title="Интеграция с google календарем">
        <?php
        if (!$data['gcalendar']['is_authorized']) {
            echo '<p>Пройдите по <a href="' . $data['gcalendar']['authLink'] . '" target="_blank">ссылке</a> и авторизуйтесь в рабочем google аккаунте и вставке код в поле ниже.</p>';
            echo '<a href="https://rbs-demo.ivadey.ru/settings/instruction-of-gcalendar-integration">Подробная инструкция.</a>';
            echo '<textarea></textarea>';
        }
        else echo '<p>Интеграция уже произведена</p>';
        ?>
    </div>
</section>