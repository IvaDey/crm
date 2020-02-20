// Данные для записи
let reservationInfo = {
    location: {
        id: null,
        address: null
    },
    service: {
        id: null,
        name: null,
        cost: null,
        duration: null
    },
    master: {
        id: null,
        name: null
    },
    date: null,
    time: null,
    client: {
        name: null,
        phone: null,
        email: null
    },
    isDataValid: function () {
        if (this.location && this.service && this.master && this.date && this.time)
            return true
        else return false
    }
}

let dayNames = [
        'Вс',
        'Пн',
        'Вт',
        'Ср',
        'Чт',
        'Пт',
        'Сб'
    ],
    monthNames = [
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
        ]

let openWidget = function () {
    $('#rbs-widget #rbs-close_widget').fadeTo(1000, 1)
    $('#rbs-widget').css({
        'transform': 'translate(0)',
        'transition': 'transform 1s ease 0s'
    })
}

let closeWidget = function () {
    $(this).fadeOut()
    $('#rbs-widget').css({
        'transform': 'translate(500px)',
        'transition': 'transform 1s ease 0s'
    })
}

let start_load_animation = function () {
    $('#rbs-ajax-load').show()
}
let stop_load_animation = function () {
    $('#rbs-ajax-load').hide()
}

let updateRating = function () {
    $('.rbs-master_rating').each(function (ind, item) {
        let rating = Number($(item).attr('data-rating_value'))
        let rt_size = (rating / 5) * 80
        $(item).children('.rbs-rating_value').css('clip', 'rect(auto, ' + rt_size + 'px, auto, 0)')
    })
}
let act_backToPrevSection = function () {
    $('section.rbs-active_section').hide()
    $($(this).attr('data-prev_section_id')).show();
    $($(this).attr('data-prev_section_id')).addClass('rbs-active_section');

    switch ($(this).attr('data-prev_section_id')) {
        case '#rbs-location': {
            $(this).hide()
            break
        }
        case '#rbs-general': {
            $(this).attr('data-prev_section_id', '#rbs-location')
            break
        }
        case '#rbs-date_selection': {
            $(this).attr('data-prev_section_id', '#rbs-general')
            break
        }
    }
}
let act_openServiceSelection = function () {
    $('#rbs-general').hide()
    $('#rbs-general').removeClass('rbs-active_section')
    $('#rbs-service_selection').show()
    $('#rbs-service_selection').addClass('rbs-active_section')

    // Показываем кнопку назад и задаем ее ссылку
    $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-general')
}
let act_openMasterSelection = function () {
    $('#rbs-general').hide()
    $('#rbs-general').removeClass('rbs-active_section')
    $('#rbs-master_selection').show()
    $('#rbs-master_selection').addClass('rbs-active_section')

    // Показываем кнопку назад и задаем ее ссылку
    $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-general')
}
let act_openDateSelection = function (dateText) {
    $('#rbs-general').hide()
    $('#rbs-general').removeClass('rbs-active_section')
    $('#rbs-date_selection').show()
    $('#rbs-date_selection').addClass('rbs-active_section')

    // Показываем кнопку назад и задаем ее ссылку
    $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-general')
}
let act_openClientInfoSection = function () {
    $('.rbs-reservation_details_body h5').html(reservationInfo.service.name)
    $('.rbs-reservation_details_body .rbs-master_name').html(reservationInfo.master.name)
    $('.rbs-reservation_details_body .rbs-location_address').html(reservationInfo.location.address)
    $('.rbs-reservation_details_body .rbs-service_cost').html(reservationInfo.service.cost + ' руб.')
    $('.rbs-reservation_details_body .rbs-service_duration').html(reservationInfo.service.duration + ' мин')

    $('#rbs-general').hide()
    $('#rbs-general').removeClass('rbs-active_section')
    $('#rbs-client_info').show()
    $('#rbs-client_info').addClass('rbs-active_section')

    // Показываем кнопку назад и задаем ее ссылку
    $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-general')
}

let initTimeSection = function (dateText) {
    let currentItem = $('.rbs-day_item.rbs-current')
    let prevCurItem = $('.rbs-day_item.rbs-current').prev()
    let prevPrevItem = $('.rbs-day_item.rbs-current').prev().prev()
    let nextCurItem = $('.rbs-day_item.rbs-current').next()
    let nextNextItem = $('.rbs-day_item.rbs-current').next().next()

    let day = dateText.substr(0, 2)
    let month = Number(dateText.substr(3, 2)) - 1
    let year = dateText.substr(6, 6)
    let date = new Date(year, month, day)

    // Устанвливаем текущий день
    currentItem.children('.rbs-month_name').html(monthNames[date.getMonth()])
    currentItem.children('.rbs-month_day').html(date.getDate())
    currentItem.children('.rbs-day_name').html(dayNames[date.getDay()])
    currentItem.attr('data-date', date.getDate())
    currentItem.attr('data-month', date.getMonth() + 1)
    currentItem.attr('data-year', date.getFullYear())

    // Устанвливаем предыдущий день
    date.setDate(date.getDate() - 1)
    prevCurItem.children('.rbs-month_day').html(date.getDate())
    prevCurItem.children('.rbs-day_name').html(dayNames[date.getDay()])
    prevCurItem.attr('data-date', date.getDate())
    prevCurItem.attr('data-month', date.getMonth() + 1)
    prevCurItem.attr('data-year', date.getFullYear())

    // Устанвливаем предпредыдущий день
    date.setDate(date.getDate() - 1)
    prevPrevItem.children('.rbs-month_day').html(date.getDate())
    prevPrevItem.children('.rbs-day_name').html(dayNames[date.getDay()])
    prevPrevItem.attr('data-date', date.getDate())
    prevPrevItem.attr('data-month', date.getMonth() + 1)
    prevPrevItem.attr('data-year', date.getFullYear())

    // Устанвливаем следующий день
    date.setDate(date.getDate() + 3)
    nextCurItem.children('.rbs-month_day').html(date.getDate())
    nextCurItem.children('.rbs-day_name').html(dayNames[date.getDay()])
    nextCurItem.attr('data-date', date.getDate())
    nextCurItem.attr('data-month', date.getMonth() + 1)
    nextCurItem.attr('data-year', date.getFullYear())

    // Устанвливаем следследующий день
    date.setDate(date.getDate() + 1)
    nextNextItem.children('.rbs-month_day').html(date.getDate())
    nextNextItem.children('.rbs-day_name').html(dayNames[date.getDay()])
    nextNextItem.attr('data-date', date.getDate())
    nextNextItem.attr('data-month', date.getMonth() + 1)
    nextNextItem.attr('data-year', date.getFullYear())
}

let act_locationSelected = function () {
    reservationInfo.location = {
        id: $(this).attr('data-location_id'),
        address: $(this).children('span.rbs-location_address').html()
    }
    $('#rbs-location .rbs-location_item').removeClass('selected_item')
    $(this).addClass('selected_item')

    $('#rbs-location').hide()
    $('#rbs-location').removeClass('rbs-active_section')
    $('#rbs-general').show()
    $('#rbs-general').addClass('rbs-active_section')

    // Показываем кнопку назад и задаем ее ссылку
    $('#rbs-header_top button').show()
    $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-location')
}
let act_serviceSelected = function () {
    $('#rbs-service_selection').hide()
    $('#rbs-service_selection').removeClass('rbs-active_section')
    $('#rbs-general').show()
    $('#rbs-general').addClass('rbs-active_section')

    // Сохраняем выбор
    $('#rbs-general_service h4').attr('data-service_id', $(this).attr('data-service_id'))
    $('#rbs-general_service h4').html($(this).html())
    $('#rbs-general_service h4').removeClass('rbs-title_placeholder')
    reservationInfo.service = {
        id: $(this).attr('data-service_id'),
        name: $(this).html(),
        cost: $(this).attr('data-service_cost'),
        duration: $(this).attr('data-service_duration'),
    }

    // Показываем кнопку назад и задаем ее ссылку
    $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-location')
}
let act_masterSelected = function () {
    $('#rbs-master_selection').hide()
    $('#rbs-master_selection').removeClass('rbs-active_section')
    $('#rbs-general').show()
    $('#rbs-general').addClass('rbs-active_section')

    // Сохраняем выбор
    $('#rbs-general_master h4').attr('data-master_id', $(this).children('.rbs-master_info').children('h4').attr('data-master_id'))
    $('#rbs-general_master h4').html($(this).children('.rbs-master_info').children('h4').html())
    $('#rbs-general_master h4').removeClass('rbs-title_placeholder')
    reservationInfo.master = {
        id: $(this).children('.rbs-master_info').children('h4').attr('data-master_id'),
        name: $(this).children('.rbs-master_info').children('h4').html()
    }

    // Показываем кнопку назад и задаем ее ссылку
    $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-location')
}
let act_dateSelected = function (dateText) {
    $('#rbs-date_selection').hide()
    $('#rbs-date_selection').removeClass('rbs-active_section')
    $('#rbs-time_selection').show()
    $('#rbs-time_selection').addClass('rbs-active_section')

    // Инициализируем секцию выбора времени
    initTimeSection(dateText)

    // Сохраняем выбор
    $('#rbs-general_time h4').attr('data-date_n_time', dateText)
    $('#rbs-general_time h4').html(dateText)
    reservationInfo.date = dateText
    reservationInfo.time = null

    // Показываем кнопку назад и задаем ее ссылку
    $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-date_selection')

    ajaxInitTimeSelection()
}
let act_timeSelected = function () {
    $('#rbs-time_selection').hide()
    $('#rbs-time_selection').removeClass('rbs-active_section')
    $('#rbs-general').show()
    $('#rbs-general').addClass('rbs-active_section')

    // Сохраняем выбор
    $('#rbs-general_time h4').attr('data-date_n_time', $('#rbs-general_time h4').attr('data-date_n_time') + ' ' + $(this).val())
    $('#rbs-general_time h4').html($('#rbs-general_time h4').attr('data-date_n_time'))
    $('#rbs-general_time h4').removeClass('rbs-title_placeholder')
    reservationInfo.time = $(this).val()

    // Показываем кнопку назад и задаем ее ссылку
    $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-date_selection')
}

// Ajax загрузка виджера
// Инициализация
let ajaxInitLocations = function () {
    start_load_animation()

    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/get_locations',
        dataType: 'json',
        success: function (data) {
            let locationsSection = $('#rbs-location')
            locationsSection.html('')

            // Проверяем если нет ошибок и данные есть

            // Заполняем виджет данными
            data.forEach(function (item, ind) {
                let location = '<div class="rbs-location_item" data-location_id="' + item.id + '">\n' +
                    '                    <h4>' + item.name + '</h4>\n' +
                    '                    <span class="rbs-location_address">' + item.address + '</span>\n' +
                    '                </div>'
                locationsSection.append(location)
            })

            $('.rbs-location_item').click(act_locationSelected)
            stop_load_animation()
        }
    })
}
let ajaxInitTimeSelection = function () {
    start_load_animation()

    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/reservations/get_available_times',
        data: {
            date: reservationInfo.date,
            location_id: reservationInfo.location.id,
            service_id: reservationInfo.service.id
        },
        dataType: 'json',
        success: function (data) {
            let timeSelectionBody = $('.rbs-time_selection_body')
            timeSelectionBody.html('')

            // Проверяем если нет ошибок и данные есть
            // console.log(data)

            // Если мастера уже выбрали, то выводим доступное время только для этого мастера
            // Если мастера не выбрали, то сформируем список всех возможных вариантов и выведем его
            if (reservationInfo.master_id) {
                // Проверим есть ли доступное время
                if (data[reservationInfo.master_id]) {
                    data[reservationInfo.master_id].forEach(function (item, ind) {
                        let timeItem = '<label>' +
                            '<input type="radio" name="time" value="' + item + '">' +
                            '<div class="rbs-time_variant">' + item + '</div>' +
                            '</label>'
                        timeSelectionBody.append(timeItem)
                    })
                } else {
                    timeSelectionBody.append('<span>На выбранную дату доступного мастера нет. Попробуйте выбрать другого мастера или день.</span>')
                }
            } else {
                // Формируем список вариантов
                let timeVariants = new Object()

                var isEmpty = true
                for (master in data) {
                    data[master].forEach(function (item, ind) {
                        timeVariants[item] = item
                        isEmpty = false
                    })
                }

                // Проверим есть ли доступные варианты
                if (isEmpty) {
                    timeSelectionBody.append('<span>На выбранную дату доступного мастера нет. Попробуйте выбрать другого мастера или день.</span>')
                } else {
                    for (item in timeVariants) {
                        let timeItem = '<label>' +
                            '<input type="radio" name="time" value="' + item + '">' +
                            '<div class="rbs-time_variant">' + item + '</div>' +
                            '</label>'
                        timeSelectionBody.append(timeItem)
                    }
                }
            }

            $('#rbs-time_selection .rbs-time_selection_body input').click(act_timeSelected)
            stop_load_animation()
        }
    })
}
let ajaxAddReservation = function () {
    start_load_animation()

    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/reservations/add_reservation',
        data: {
            location_id: reservationInfo.location.id,
            reservation_date: {
                date: reservationInfo.date,
                time: reservationInfo.time
            },
            services: [
                {
                    service_id: reservationInfo.service.id,
                    master_id: reservationInfo.master.id
                }
            ],
            client: reservationInfo.client
        },
        dataType: 'json',
        type: 'GET',
        success: function (data) {
            $('#rbs-client_info').hide()
            $('#rbs-reservation_status').show()
            // Проверяем код ошибкии
            // Если 0, то все норм и выводим сообщение об успешной записи с детальной информацией
            // Иначе, если кто-то опередил пользователя, то выводим сообщение об ошибке
            $('#rbs-reservation_status h4').html('Вы успешно записаны!')

            stop_load_animation()
        }
    })
}
// Инициализация услуг

$(document).ready(function () {
    $('#rbs-header_top button').click(act_backToPrevSection)

    $('#rbs-general_service').click(act_openServiceSelection)
    $('#rbs-general_master').click(act_openMasterSelection)
    $('#rbs-general_time').click(act_openDateSelection)
    $('.rbs-service_item h5').click(act_serviceSelected)
    $('.rbs-master_item').click(act_masterSelected)
    $('#rbs-date_calendar').datepicker({
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
        selectOtherMonths: true,
        onSelect: function(dateText, inst) {
            act_dateSelected(dateText)
        }
    })
    $('#rbs-time_selection .rbs-time_selection_body input').click(act_timeSelected)
    $('.rbs-day_item').click(function () {
        let date = $(this).attr('data-date')
        if (date.length == 1)
            date = '0' + date
        let month = $(this).attr('data-month')
        if (month.length == 1)
            month = '0' + month
        let year = $(this).attr('data-year')

        // Сохраняем результат
        $('#rbs-general_time h4').attr('data-date_n_time', date + '.' + month + '.' + year)
        reservationInfo.date = date + '.' + month + '.' + year
        reservationInfo.time = null

        initTimeSection(date + '.' + month + '.' + year)
        ajaxInitTimeSelection()
    })
    $('#rbs-time_selection button.rbs-prev-day').click(function () {
        console.log('hi')
        $('.rbs-day_item.rbs-current').prev().click()
    })
    $('#rbs-time_selection button.rbs-next-day').click(function () {
        console.log('hi')
        $('.rbs-day_item.rbs-current').next().click()
    })

    $('.rbs-services_group h4').click(function () {
        $(this).toggleClass('opened')
        $(this).next().slideToggle()
    })
    $('.rbs-reservation_details h4').click(function () {
        $(this).toggleClass('opened')
        $(this).next().slideToggle()
    })
    $('.rbs-service_item p + button').click(function () {
        $(this).prev().toggleClass('opened')
    })

    $('#rbs-sign_up').click(function () {
        reservationInfo.client.name = $('#rbs-client_info input[name="name"]').val()
        reservationInfo.client.phone = $('#rbs-client_info input[name="phone"]').val()
        reservationInfo.client.email = $('#rbs-client_info input[name="email"]').val()

        ajaxAddReservation()
    })

    // выставляем рейтинг
    updateRating()

    // Создаем календарь
    $('#rbs-date_calendar').datepicker({
        altField: '.calendar input[name="date"]',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        minDate: 0,
        dayNamesMin: dayNames,
        monthNames: monthNames,
        showOtherMonths: true,
        selectOtherMonths: true
    })

    $('#rbs-close_widget').click(closeWidget)

    $('#rbs-general button').click(function () {
        if (reservationInfo.isDataValid())
            act_openClientInfoSection()
        else {
            if (!reservationInfo.service_id)
                $('#rbs-general_service').css('border', '2px solid #ff0000')
            if (!reservationInfo.master_id)
                $('#rbs-general_master').css('border', '2px solid #ff0000')
            if (!(reservationInfo.date && reservationInfo.time))
                $('#rbs-general_time').css('border', '2px solid #ff0000')
        }
    })

    $('#open_widget').click(openWidget)

    ajaxInitLocations()
})

















