// Запуск и остановка анимации загрузки
let startLoadingAnimation = function () {
    $('#ajax-load').show()
}
let stopLoadingAnimation = function () {
    $('#ajax-load').hide()
}

let createReservationsStatsChart = function () {
    let chartBox = $('#reservations_stats')[0].getContext('2d')

    let labels = Array()
    $('#reservations-stats-data ul.labels li').each(function (ind, item) {
        labels.push($(item).html())
    })

    let dataset = Array()
    $('#reservations-stats-data ul.dataset li').each(function (ind, item) {
        dataset.push($(item).html())
    })

    let reservationsStats = new Chart(chartBox, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Количество записей',
                data: dataset,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            }
        }
    });
}
let createClientsStatsChart = function () {
    let chartBox = $('#visits_stats')[0].getContext('2d')

    let labels = Array()
    $('#visits-stats-data ul.labels li').each(function (ind, item) {
        labels.push($(item).html())
    })

    let dataset = Array()
    $('#visits-stats-data ul.dataset li').each(function (ind, item) {
        dataset.push($(item).html())
    })

    let reservationsStats = new Chart(chartBox, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Количество клиентов',
                data: dataset,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            }
        }
    });
}
let createRevenueStatsChart = function () {
    let chartBox = $('#revenue_stats')[0].getContext('2d')

    let labels = Array()
    $('#revenue-stats-data ul.labels li').each(function (ind, item) {
        labels.push($(item).html())
    })

    let dataset = Array()
    $('#revenue-stats-data ul.dataset li').each(function (ind, item) {
        dataset.push($(item).html())
    })

    let reservationsStats = new Chart(chartBox, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Выручка',
                data: dataset,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(tooltipItem, data) {
                        let label = data.datasets[tooltipItem.datasetIndex].label || '';

                        if (label) {
                            label += ': ';
                        }
                        label += new Intl.NumberFormat('ru-RU').format(tooltipItem.yLabel) + ' руб'
                        return label;
                    }
                }
            }
        }
    });
}


$(document).ready(function () {
    createReservationsStatsChart()
    createClientsStatsChart()
    createRevenueStatsChart()
})
























