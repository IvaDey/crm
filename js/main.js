let eventBlockPosition = {
    left: null,
    top: null
}

// Запуск и остановка анимации загрузки
let startLoadingAnimation = function () {
    $('#ajax-load').show()
}
let stopLoadingAnimation = function () {
    $('#ajax-load').hide()
}

// Построение графиков
let createRevenueChart = function () {
    let chartBox = $('#revenue-chart')[0].getContext('2d')

    // let labels = Array()
    // $('#revenue-stats-data ul.labels li').each(function (ind, item) {
    //     labels.push($(item).html())
    // })
    //
    // let dataset = Array()
    // $('#revenue-stats-data ul.dataset li').each(function (ind, item) {
    //     dataset.push($(item).html())
    // })

    let labels = ['8.09', '9.09', '10.09', '11.09', '12.09', '13.09', '14.09']
    let dataset = [80, 100, 90, 120, 110, 95, 105]

    let reservationsStats = new Chart(chartBox, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Выручка',
                data: dataset,
                backgroundColor: 'rgba(0, 172, 255, 0.2)',
                borderColor: 'rgba(0, 172, 255, 1)',
                borderWidth: 1,
                pointStyle: 'circle',
                pointRadius: '1'
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        // beginAtZero: true,
                        min: 60,
                        max: 140,
                        display: false
                    },
                    gridLines: {
                        display: true,
                        drawBorder: false,
                        drawOnChartArea: false,
                        drawTicks: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: true,
                        drawBorder: true,
                        drawOnChartArea: false,
                        drawTicks: false
                    }
                }]
            },
            legend: {
                display: false
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
let createVisitsChart = function () {
    let chartBox = $('#visits-chart')[0].getContext('2d')

    // let labels = Array()
    // $('#visits-stats-data ul.labels li').each(function (ind, item) {
    //     labels.push($(item).html())
    // })
    //
    // let dataset = Array()
    // $('#visits-stats-data ul.dataset li').each(function (ind, item) {
    //     dataset.push($(item).html())
    // })

    let labels = ['8.09', '9.09', '10.09', '11.09', '12.09', '13.09', '14.09']
    let dataset = [80, 100, 90, 120, 110, 95, 105]

    let reservationsStats = new Chart(chartBox, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Количество клиентов',
                data: dataset,
                backgroundColor: 'rgba(0, 172, 255, 0.2)',
                borderColor: 'rgba(0, 172, 255, 1)',
                borderWidth: 1,
                pointStyle: 'circle',
                pointRadius: '1'
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        // beginAtZero: true,
                        min: 60,
                        max: 140,
                        display: false
                    },
                    gridLines: {
                        display: true,
                        drawBorder: false,
                        drawOnChartArea: false,
                        drawTicks: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: true,
                        drawBorder: true,
                        drawOnChartArea: false,
                        drawTicks: false
                    }
                }]
            },
            legend: {
                display: false
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            }
        }
    });
}

// Расстановка карточек записей на календарь
let setEvents =function () {
    let masterColumnWidth = 172         // Ширина колонки мастера
    let calendarRowHeight = 48          // Высота рядя в календаре (промежуток в 30 мин)

    let dayStart = new Date('1/01/2001 8:00')     // Начало рабочего дня

    $('.reservation-info-block').each(function (ind, item) {
        let time = '1/01/2001 ' + $(item).attr('data-time')
        let master = $(item).attr('data-master_num')
        let duration = $(item).attr('data-duration')
        let mastersCount = $(item).parent().parent().attr('data-masters_count')     // Получаем количество мастеров

        // Устанавливаем отступ сверху
        let eventTime = new Date(Date.parse(time))
        let timeSteps = (eventTime.getHours() - dayStart.getHours()) * 2 + eventTime.getMinutes() / 30 - 1
        $(item).css('top', (timeSteps * calendarRowHeight + 52) + 'px')

        // Устанавливаем отступ слева
        // $(item).css('left', ((master - 1) * masterColumnWidth + 52) + 'px')
        $(item).css('left', 'calc(52px + ((100% - 52px)/' + mastersCount + ' - 8px)*' + (master - 1) + ')')

        // Устанавливаем высоту
        $(item).css('min-height', (duration / 30 * 48 - 8) + 'px')

        // Устанавливаем ширину
        $(item).css('width', 'calc((100% - 52px)/' + mastersCount + ' - 12px)')
    })
}

$(document).ready(function () {
    createRevenueChart()
    createVisitsChart()

    // Обраотка модальных окон
    $('.openmodal').fancybox({
        modal: true,
        afterClose: function (instance, current) {
            this.preventDefault()   // Цель достигнута, хотя это и не работает – данный вызов вызывает ошибку, которая
                                    // не блокирует дальнейшее выполнение и прыжка не происходит. Необходимо более
                                    // надежное и правильное решение
        }
    })
    $('.modal .modal-close').click(function () {
        $.fancybox.close()
    })

    $('.modal input.date').datepicker({
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        dayNamesMin: [
            'Вс',
            'Пн',
            'Вт',
            'Ср',
            'Чт',
            'Пт',
            'Сб'
        ],
        monthNames: [
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь'
        ],
        showOtherMonths: true,
        selectOtherMonths: true
    })
    $('.modal input.time').clockpicker({
        donetext: 'Done',
        autoclose: true
    });

    // Выставляем события на календаре
    setEvents()

    $('.reservation-info-block').mouseenter(function (e) {
        // Запоминаем текущее расположение карточки события
        eventBlockPosition.left = $(this).offset().left
        eventBlockPosition.top = $(this).offset().top

        let blockWidth = $('.reservation-info-block').width() + 20 > 250 ? $('.reservation-info-block').width() + 20 : 250
        let calBodyWidth = $('.calendar-body').width()

        let calBodyPos = {
            left: $('.calendar-body').offset().left,
            top: $('.calendar-body').offset().top
        }

        // Получаем координаты миши
        let mX = e.clientX
        let mY = e.clientY

        // Выставляем новые координаты для блока по горизонтали
        if (eventBlockPosition.left + blockWidth > calBodyPos.left + calBodyWidth) {
            if ($('.reservation-info-block').width() + 20 < 250)
                $(this).offset({left: eventBlockPosition.left - (blockWidth - $('.reservation-info-block').width() - 20)})
        } else if (eventBlockPosition.left - calBodyPos.left > $('.reservation-info-block').width() + 20) {
            $(this).offset({left: eventBlockPosition.left - (blockWidth - $('.reservation-info-block').width() - 20)/2})
        }
    })
    $('.reservation-info-block').mouseleave(function () {
        // Восстанавливаем исходные координаты карточки события
        // Временное решение заключается в запоминании исходных параметров и восстановлении по ним
        // Но по хорошему необходимо по новой их пересчитывать, так как может быть смещение
        $(this).offset({left: eventBlockPosition.left})
    })
})
























