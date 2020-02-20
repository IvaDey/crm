let start_load_animation = function () {
    $('#ajax-load').show()
}
let stop_load_animation = function () {
    $('#ajax-load').hide()
}

let ajax_filters = function () {
    let date = $('.filters input[name="date"]').val()
    let location = $('.filters select[name="location_id"]').val()
    let service = $('.filters select[name="service_id"]').val()
    let master = $('.filters select[name="master_id"]').val()
    let status = $('.filters select[name="status_id"]').val()

    let filters = new Object()

    if (date) {
        filters.reservation_date = date
    }
    if (location) {
        filters.location_id = location
    }
    if (service) {
        filters.service_id = service
    }
    if (master) {
        filters.master_id = master
    }
    if (status) {
        filters.status_id = status
    }

    $('#body-reservations_list table tbody').html('')
    start_load_animation()

    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/reservations/get_reservations',
        data: filters,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (reservation_id in data) {
                data[reservation_id].services.forEach(function (item, ind) {
                    let reservation_row = '<tr>' +
                        '<td>' + data[reservation_id].reservation_id + '</td>' +
                        '<td>' + data[reservation_id].reservation_date.date + ' ' + data[reservation_id].reservation_date.time + '</td>' +
                        '<td>' + item.name + '</td>' +
                        '<td>' + data[reservation_id].master.name + '</td>' +
                        '<td>' + data[reservation_id].client.name + '</td>' +
                        '<td>' + data[reservation_id].client.phone + '</td>' +
                        '<td>' + data[reservation_id].client.email + '</td>' +
                        '<td>' + data[reservation_id].total_duration + '</td>' +
                        '<td><button></button></td>';
                    $('#body-reservations_list table tbody').append(reservation_row)

                    // Цепляем обаботчик на кнопку
                })
            }

            stop_load_animation()
        }
    })
}

let setEvents =function () {
    let masterColumnWidth = 250         // Ширина колонки мастера
    let calendarRowHeight = 48          // Высота рядя в календаре (промежуток в 30 мин)

    let dayStart = new Date('1/01/2001 8:00')     // Начало рабочего дня

    $('.reservation-info-block').each(function (ind, item) {
        let time = '1/01/2001 ' + $(item).attr('data-time')
        let master = $(item).attr('data-master_num')
        let duration = $(item).attr('data-duration')

        // Устанавливаем отступ сверху
        let eventTime = new Date(Date.parse(time))
        let timeSteps = (eventTime.getHours() - dayStart.getHours()) * 2 + eventTime.getMinutes() / 30
        $(item).css('top', (timeSteps * calendarRowHeight + 52) + 'px')

        // Устанавливаем отступ слева
        $(item).css('left', ((master - 1) * masterColumnWidth + 52) + 'px')

        // Устанавливаем высоту
        $(item).css('min-height', (duration / 30 * 48 - 8) + 'px')
    })
}

$(document).ready(function () {
    // Кастомизация элементов ввода данных
    $('.filters input[name="date"]').datepicker({
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
    $('#new-reservation_date .calendar').datepicker({
        altField: '.calendar input[name="date"]',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        minDate: 0,
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

    $('.filters select').styler()

    // Обработка фильтров
    // Обработка изменения даты
    $('.filters input[name="date"]').change(ajax_filters)
    // Обработка изменения филиала
    $('.filters select[name="location_id"]').change(ajax_filters)
    // Обработка изменения услуги
    $('.filters select[name="service_id"]').change(ajax_filters)
    // Обработка изменения мастера
    $('.filters select[name="master_id"]').change(ajax_filters)
    // Обработка изменения статуса
    $('.filters select[name="status_id"]').change(ajax_filters)

    // Обраотка модальных окон
    $('.openmodal').fancybox({
        modal: true
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
    // Окно экспорта

    // Окно создания записи

    // Подробная информация о записи

    // Окно выбора мастера

    // Окно выбора услуги

    // Выставляем события на календаре
    setEvents()
})






















