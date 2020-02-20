<!--<h1>Статистика</h1>-->

<section>
    <h2>Количество записавшихся</h2>
    <div id="reservations-stats-data" class="stats-data">
        <ul class="labels">
            <?php
            foreach ($data['reservations_stats'] as $reservations_stat) {
                print '<li>' . $reservations_stat['date'] . '</li>';
            }
            ?>
        </ul>
        <ul class="dataset">
            <?php
            foreach ($data['reservations_stats'] as $reservations_stat) {
                print '<li>' . $reservations_stat['reservations_count'] . '</li>';
            }
            ?>
        </ul>
    </div>
    <canvas id="reservations_stats"></canvas>
</section>

<section>
    <h2>Количество клиентов</h2>
    <div id="visits-stats-data" class="stats-data">
        <ul class="labels">
            <?php
            foreach ($data['visits_stats'] as $visits_stat) {
                print '<li>' . $visits_stat['date'] . '</li>';
            }
            ?>
        </ul>
        <ul class="dataset">
            <?php
            foreach ($data['visits_stats'] as $visits_stat) {
                print '<li>' . $visits_stat['visits_count'] . '</li>';
            }
            ?>
        </ul>
    </div>
    <canvas id="visits_stats"></canvas>
</section>

<section>
    <h2>Выручка</h2>
    <div id="revenue-stats-data" class="stats-data">
        <ul class="labels">
            <?php
            foreach ($data['revenue_stats'] as $revenue_stat) {
                print '<li>' . $revenue_stat['date'] . '</li>';
            }
            ?>
        </ul>
        <ul class="dataset">
            <?php
            foreach ($data['revenue_stats'] as $revenue_stat) {
                print '<li>' . $revenue_stat['revenue'] . '</li>';
            }
            ?>
        </ul>
    </div>
    <canvas id="revenue_stats"></canvas>
    <div class="chartjs-tooltip" id="tooltip-0"></div>
</section>































