// Запуск и остановка анимации загрузки
let startLoadingAnimation = function () {
    $('#ajax-load').show()
}
let stopLoadingAnimation = function () {
    $('#ajax-load').hide()
}

let remove_specialisation = function () {
    $(this).parent().remove()
}
let add_specialisation = function () {
    let selected_category_id = $(this).val()
    let selected_category_name = $('#categories_list li[data-category_id="' + selected_category_id + '"]').html()

    let specialisation = '<div class="specialisation_row">\n' +
        '                <span data-category_id="' + selected_category_id+ '">' + selected_category_name + '</span>\n' +
        '                <img src="/images/close.png">\n' +
        '            </div>'
    $('.master_specialisations select').before(function () {
        return specialisation
    })

    $('#master_info .specialisation_row img').click(remove_specialisation)

    $(this).val(0)
}

// Ajax-запросы на изменение информации о филиалах
let add_location = function () {
    let location_name = $('#location_editor input[name="name"]').val()
    let location_address = $('#location_editor textarea').val()
    let location_working_hours = {
        1: {
            'open': $('#location_editor input[name="working_start[1]"]').val(),
            'close': $('#location_editor input[name="working_end[1]"]').val()
        },
        2: {
            'open': $('#location_editor input[name="working_start[2]"]').val(),
            'close': $('#location_editor input[name="working_end[2]"]').val()
        },
        3: {
            'open': $('#location_editor input[name="working_start[3]"]').val(),
            'close': $('#location_editor input[name="working_end[3]"]').val()
        },
        4: {
            'open': $('#location_editor input[name="working_start[4]"]').val(),
            'close': $('#location_editor input[name="working_end[4]"]').val()
        },
        5: {
            'open': $('#location_editor input[name="working_start[5]"]').val(),
            'close': $('#location_editor input[name="working_end[5]"]').val()
        },
        6: {
            'open': $('#location_editor input[name="working_start[6]"]').val(),
            'close': $('#location_editor input[name="working_end[6]"]').val()
        },
        7: {
            'open': $('#location_editor input[name="working_start[7]"]').val(),
            'close': $('#location_editor input[name="working_end[7]"]').val()
        }
    }
    let current_modal = this

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/add_location',
        data: {
            location_name: location_name,
            location_address: location_address,
            location_working_hours: location_working_hours
        },
        dataType: 'json',
        method: 'GET',
        success: function (data) {
            let new_location = '<li data-location_id="' + data.new_location_id + '" data-location_address="'
                + location_address + '">' + location_name + '</li>';
            $('#locations_list ul').append(new_location)

            $('#locations_list ul li').click({isNewLocation: false}, open_location_editor)

            $(current_modal).dialog('close');

            stopLoadingAnimation()
        }
    })
}
let change_location_info = function () {
    let location_id = $('#location_editor input[name="location_id"]').val()
    let location_name = $('#location_editor input[name="name"]').val()
    let location_address = $('#location_editor textarea').val()
    let location_working_hours = {
        1: {
            'open': $('#location_editor input[name="working_start[1]"]').val(),
            'close': $('#location_editor input[name="working_end[1]"]').val()
        },
        2: {
            'open': $('#location_editor input[name="working_start[2]"]').val(),
            'close': $('#location_editor input[name="working_end[2]"]').val()
        },
        3: {
            'open': $('#location_editor input[name="working_start[3]"]').val(),
            'close': $('#location_editor input[name="working_end[3]"]').val()
        },
        4: {
            'open': $('#location_editor input[name="working_start[4]"]').val(),
            'close': $('#location_editor input[name="working_end[4]"]').val()
        },
        5: {
            'open': $('#location_editor input[name="working_start[5]"]').val(),
            'close': $('#location_editor input[name="working_end[5]"]').val()
        },
        6: {
            'open': $('#location_editor input[name="working_start[6]"]').val(),
            'close': $('#location_editor input[name="working_end[6]"]').val()
        },
        7: {
            'open': $('#location_editor input[name="working_start[7]"]').val(),
            'close': $('#location_editor input[name="working_end[7]"]').val()
        }
    }
    let current_modal = this

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/change_location_info',
        data: {
            location_id: location_id,
            location_name: location_name,
            location_address: location_address,
            location_working_hours: location_working_hours
        },
        method: 'GET',
        success: function (data) {
            $('#locations_list ul li[data-location_id="' + location_id + '"]').html(location_name)

            $(current_modal).dialog('close');

            stopLoadingAnimation()
        }
    })
}
let delete_location = function () {
    let location_id = $('#location_editor input[name="location_id"]').val()
    let current_modal = this

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/delete_location',
        data: {
            location_id: location_id
        },
        method: 'GET',
        success: function (data) {
            $('#locations_list ul li[data-location_id="' + location_id + '"]').remove()
            $(current_modal).dialog('close');

            stopLoadingAnimation()
        }
    })
}

// Ajax-запросы на изменение информации о категориях услуг
let add_category = function () {
    let category_name = $('#category_editor input[name="name"]').val()
    let current_modal = this

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/add_category',
        data: {
            category_name: category_name
        },
        dataType: 'json',
        method: 'GET',
        success: function (data) {
            let new_category = '<li data-category_id="' + data.new_category_id  + '">' + category_name + '</li>';
            $('#categories_list ul').append(new_category)

            $('#categories_list ul li').click(show_category_services)
            $('#categories_list ul li').dblclick({isNewCategory: false}, open_category_editor)

            $(current_modal).dialog('close');

            stopLoadingAnimation()
        }
    })
}
let change_category_info = function () {
    let category_id = $('#category_editor input[name="category_id"]').val()
    let category_name = $('#category_editor input[name="name"]').val()
    let current_modal = this

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/change_category_info',
        data: {
            category_id: category_id,
            category_name: category_name
        },
        method: 'GET',
        success: function (data) {
            $('#categories_list ul li[data-category_id="' + category_id + '"]').html(category_name)

            $(current_modal).dialog('close');

            stopLoadingAnimation()
        }
    })
}
let delete_category = function () {
    let category_id = $('#category_editor input[name="category_id"]').val()
    let current_modal = this

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/delete_category',
        data: {
            category_id: category_id
        },
        method: 'GET',
        success: function (data) {
            $('#categories_list ul li[data-category_id="' + category_id + '"]').remove()
            $(current_modal).dialog('close');

            stopLoadingAnimation()
        }
    })
}

// Ajax-запросы на изменение информации об услугах
let add_service = function () {
    let name = $('#service_editor input[name="name"]').val()
    let description = $('#service_editor textarea').val()
    let category_id = $('#service_editor select').val()
    let price = $('#service_editor input[name="price"]').val()
    let duration = $('#service_editor input[name="duration"]').val()
    let current_modal = this

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/add_service',
        data: {
            name: name,
            description: description,
            category_id: category_id,
            price: price,
            duration: duration
        },
        dataType: 'json',
        method: 'GET',
        success: function (data) {
            let new_service = '<li ' +
                'data-service_id="' + data.new_service_id + '" ' +
                'data-service_description="' + description + '" ' +
                'data-service_price="' + price + '" ' +
                'data-service_duration="' + duration + '">' + name + '</li>';
            $('#services_list ul').append(new_service)

            $('#services_list ul li').click({isNewLocation: false}, open_service_editor)

            $(current_modal).dialog('close');

            stopLoadingAnimation()
        }
    })
}
let change_service_info = function () {
    let id = $('#service_editor input[name="service_id"]').val()
    let name = $('#service_editor input[name="name"]').val()
    let description = $('#service_editor textarea').val()
    let category_id = $('#service_editor select').val()
    let price = $('#service_editor input[name="price"]').val()
    let duration = $('#service_editor input[name="duration"]').val()
    let current_modal = this

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/change_service_info',
        data: {
            id: id,
            name: name,
            description: description,
            category_id: category_id,
            price: price,
            duration: duration
        },
        method: 'GET',
        success: function (data) {
            let serviceItem = '#services_list ul li[data-service_id="' + id + '"]'
            $(serviceItem).html(name)
            $(serviceItem).attr('data-service_description', description)
            $(serviceItem).attr('data-service_price', price)
            $(serviceItem).attr('data-service_duration', duration)

            $(current_modal).dialog('close');

            stopLoadingAnimation()
        }
    })
}
let delete_service = function () {
    let id = $('#service_editor input[name="service_id"]').val()
    let current_modal = this

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/delete_service',
        data: {
            id: id
        },
        method: 'GET',
        success: function (data) {
            $('#services_list ul li[data-service_id="' + id + '"]').remove()
            $(current_modal).dialog('close');

            stopLoadingAnimation()
        }
    })
}

// Методы обработки (ajax-запросы на добавление, изменение, удаление и пр.) информации о мастерах
let add_master = function () {
    startLoadingAnimation()

    let name = $('#master_info .general_info_body input[name="name"]').val()
    let description = $('#master_info .general_info_body textarea').val()
    let location_id = $('#master_info .general_info_body select[name="location_id"]').val()
    let working_hours = new Object()
    let specialisations = new Object()

    $('#master_info .day_working_hours').each(function (ind, item) {
        working_hours[ind + 1] = {
            'open': $(item).children('input[name="working_start[' + (ind + 1) +']"]').val(),
            'close': $(item).children('input[name="working_end[' + (ind + 1) +']"]').val()
        }
    })
    $('#master_info .specialisation_row').each(function (ind, item) {
        specialisations[ind + 1] = $(item).children('span').attr('data-category_id')
    })

    //-----
    let master_info = new FormData()
    master_info.append('name', name)
    master_info.append('description', description)
    if ($('#master_info .master_avatar input[name="master_avatar"]')[0].files.length) {
        master_info.append('add_photo', 'true')
        master_info.append('photo', $('#master_info .master_avatar input[name="master_avatar"]')[0].files[0])
    } else {
        master_info.append('add_photo', '')
    }
    master_info.append('location_id', location_id)
    master_info.append('working_hours', JSON.stringify(working_hours))
    master_info.append('specialisations', JSON.stringify(specialisations))

    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/add_master',
        data: master_info,
        processData: false,
        contentType: false,
        dataType: 'json',
        method: 'POST',
        success: function (data) {
            let new_master = '<li class="selected" ' +
                'data-master_id="' + data.new_master.new_master_id + '">' +
                '<img src="/images/masters/' + data.new_master.new_master_avatar + '">' + name + '</li>';
            $('#masters_list ul').append(new_master)

            if (data.new_master.calendar_link) {
                $('#gcalendar p').html('<a href="' + data.new_master.calendar_link + '" target="_blank">Перейти</a>')
            } else {
                $('#gcalendar p').html('Персональный календарь не создан. <a>Создать</a>')
            }

            $('#masters_list ul li').click({isNewItem: false}, open_master_editor)
            $('#master_info button.save').html('Сохранить изменения')
            $('#master_info button.save').off('click')
            $('#master_info button.save').on('click', change_master_info)
            $('#master_info button.delete').show()
            $('#master_info button.cancel').hide()
            $('#gcalendar').show()

            $('#gcalendar p a').click(add_master_calendar)
            stopLoadingAnimation()
        }
    })
}
let change_master_info = function () {
    let id = $('#masters_list ul li.selected').attr('data-master_id')
    let name = $('#master_info .general_info_body input[name="name"]').val()
    let description = $('#master_info .general_info_body textarea').val()
    let location_id = $('#master_info .general_info_body select[name="location_id"]').val()
    let working_hours = new Object()
    let specialisations = new Object()

    $('#master_info .day_working_hours').each(function (ind, item) {
        working_hours[ind + 1] = {
            'open': $(item).children('input[name="working_start[' + (ind + 1) +']"]').val(),
            'close': $(item).children('input[name="working_end[' + (ind + 1) +']"]').val()
        }
    })
    $('#master_info .specialisation_row').each(function (ind, item) {
        specialisations[ind + 1] = $(item).children('span').attr('data-category_id')
    })

    //-----
    let master_info = new FormData()
    master_info.append('id', id)
    master_info.append('name', name)
    master_info.append('description', description)
    if ($('#master_info .master_avatar input[name="master_avatar"]')[0].files.length) {
        master_info.append('add_photo', 'true')
        master_info.append('photo', $('#master_info .master_avatar input[name="master_avatar"]')[0].files[0])
    } else {
        master_info.append('add_photo', '')
    }
    master_info.append('location_id', location_id)
    master_info.append('working_hours', JSON.stringify(working_hours))
    master_info.append('specialisations', JSON.stringify(specialisations))

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/change_master_info',
        data: master_info,
        processData: false,
        contentType: false,
        dataType: 'json',
        method: 'POST',
        success: function (data) {
            // let master_item = '<img src=/images/masters/default.png>' + name
            $('#masters_list ul li.selected img').attr('src', '/images/masters/' + data.new_photo)
            // И еще надо менять миниатюру фотографии

            stopLoadingAnimation()
        }
    })
}
let delete_master = function () {
    let id = $('#masters_list ul li.selected').attr('data-master_id')
    let delete_calendar = $('#deleting-master-apply input[name="delete_calendar"]')[0].checked
    startLoadingAnimation()

    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/delete_master',
        data: {
            id: id,
            delete_calendar: delete_calendar
        },
        method: 'GET',
        success: function (data) {
            // Удаляем мастера из меню
            let id = $('#masters_list ul li.selected').remove()

            // Скрываем все все поля
            $('#content #master_info .general_info').hide()
            $('#content #master_info .working_hours').hide()
            $('#gcalendar').hide()
            $('#content #master_info .master_specialisations').hide()
            $('#content #master_info .buttons').hide()

            // Показываем уведомление
            $('#master_info p.alert-center').css('display', 'flex')

            stopLoadingAnimation()
        }
    })
}
let cancel_adding_master = function () {
    close_master_editor()
}
let add_master_calendar = function () {
    if ($(this).attr('href')) {
        return
    } else {
        // В перспективе надо добавить проверку на наличие интеграции с гугл календарем
        // А пока просто создаем
        startLoadingAnimation()

        $.ajax({
            url: 'https://rbs-demo.ivadey.ru/main/add_master_calendar',
            data: {
                id: $('#masters_list li.selected').attr('data-master_id'),
                name: $('#masters_list li.selected').attr('data-master_name')
            },
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (!data.error_code) {
                    $('#gcalendar p').html('<a href="' + data.gcal + '" target="_blank">Перейти</a>')
                }

                stopLoadingAnimation()
            }
        })
    }
}

// Методы обработки модальных окон
let open_location_editor = function (eventObject) {
    if (eventObject.data.isNewItem) {
        // Очищаем модальное окно от старых данных
        $('#location_editor input').val('')
        $('#location_editor textarea').val('')
        $('#location_editor div input.time_start').val('9:00')
        $('#location_editor div input.time_end').val('20:00')

        $('#location_editor').dialog('option', 'buttons', {
            "Сохранить": add_location,
            "Отменить": function () {
                $(this).dialog("close")
            }
        })

        $('#location_editor').dialog('open')
    } else {
        startLoadingAnimation()
        // Загружаем инфу о филиале и инициализируем новыми значениями
        $.ajax({
            url: 'https://rbs-demo.ivadey.ru/main/get_location',
            data: {
                location_id: $(this).attr('data-location_id')
            },
            dataType: 'json',
            method: 'GET',
            success: function (data) {
                $('#location_editor input[name="name"]').val(data.location_name)
                $('#location_editor input[name="location_id"]').val(data.location_id)
                $('#location_editor textarea').val(data.location_address)

                data.location_working_hours.forEach(function (item, i) {
                    $('#location_editor input[name="working_start[' + item.day_id + ']"]').val(item.open_at)
                    $('#location_editor input[name="working_end[' + item.day_id + ']"]').val(item.close_at)
                })

                $('#location_editor').dialog('option', 'buttons', {
                    "Сохранить": change_location_info,
                    "Удалить": delete_location,
                    "Отменить": function () {
                        $(this).dialog("close")
                    }
                })

                $('#location_editor').dialog('option', 'title', data.location_name)
                $('#location_editor').dialog('open')

                stopLoadingAnimation()
            }
        })
    }
}
let open_category_editor = function (eventObject) {
    if (eventObject.data.isNewItem) {
        $('#category_editor input').val('')

        $('#category_editor').dialog('option', 'buttons', {
            "Сохранить": add_category,
            "Отменить": function () {
                $(this).dialog("close")
            }
        })

        $('#category_editor').dialog('open')
    } else {
        $('#category_editor input[name="name"]').val($(this).html())
        $('#category_editor input[name="category_id"]').val($(this).attr('data-category_id'))

        $('#category_editor').dialog('option', 'buttons', {
            "Сохранить": change_category_info,
            "Удалить": delete_category,
            "Отменить": function () {
                $(this).dialog("close")
            }
        })

        $('#category_editor').dialog('open')
    }
}
let open_service_editor = function (eventObject) {
    if (eventObject.data.isNewItem) {
        // Очищаем модальное окно от старых данных
        $('#service_editor input').val('')
        $('#service_editor textarea').val('')
        $('#service_editor select').val($('#categories_list ul li.selected').attr('data-category_id'))

        $('#service_editor').dialog('option', 'buttons', {
            "Сохранить": add_service,
            "Отменить": function () {
                $(this).dialog("close")
            }
        })

        $('#service_editor').dialog('open')
    } else {
        $('#service_editor input[name="name"]').val($(this).html())
        $('#service_editor input[name="service_id"]').val($(this).attr('data-service_id'))
        $('#service_editor textarea').val($(this).attr('data-service_description'))
        $('#service_editor select').val($('#categories_list ul li.selected').attr('data-category_id'))
        $('#service_editor input[name="price"]').val($(this).attr('data-service_price'))
        $('#service_editor input[name="duration"]').val($(this).attr('data-service_duration'))

        $('#service_editor').dialog('option', 'buttons', {
            "Сохранить": change_service_info,
            "Удалить": delete_service,
            "Отменить": function () {
                $(this).dialog("close")
            }
        })

        $('#service_editor').dialog('open')
    }
}
let open_master_editor = function (eventObject) {
    if (eventObject.data.isNewItem) {
        // Очищаем все поля
        $('#masters_list ul li').removeClass('selected')
        $('#master_info .master_avatar img').attr('src', '/images/masters/default.png')
        $('#master_info input').val('')
        $('#master_info div input.time_start').val('9:00')
        $('#master_info div input.time_end').val('20:00')
        $('#master_info textarea').val('')
        $('#master_info .specialisation_row').remove()
        $('#master_info select[name="location_id"]').val($('#locations_list ul li').attr('data-Location_id'))

        // Скрываем уведомление
        $('#master_info p.alert-center').hide()

        // Отображаем все поля
        $('#content #master_info .general_info').css('display', 'flex')
        $('#content #master_info .working_hours').show()
        $('#bottom-master-right-column').show()
        $('#gcalendar').hide()
        $('#content #master_info .master_specialisations').show()
        $('#content #master_info .buttons').css('display', 'flex')

        // Меняем кнопки и поведение кнопки "сохранить"
        $('#master_info button.save').html('Добавить')
        $('#master_info button.delete').hide()
        $('#master_info button.cancel').show()
        $('#master_info button.save').off('click')
        $('#master_info button.save').on('click', add_master)
    } else {
        startLoadingAnimation()

        // Меняем выделенный пункт меню
        $('#masters_list ul li').removeClass('selected')
        $(this).addClass('selected')

        // Меняем кнопки и поведение кнопки "сохранить"
        $('#master_info button.save').html('Сохранить изменения')
        $('#master_info button.save').off('click')
        $('#master_info button.save').on('click', change_master_info)
        $('#master_info button.delete').show()
        $('#master_info button.cancel').hide()

        // Загружаем данные
        $.ajax({
            url: 'https://rbs-demo.ivadey.ru/main/get_master',
            data: {
                id: $(this).attr('data-master_id')
            },
            dataType: 'json',
            method: 'GET',
            success: function (data) {
                // Очищаем все поля
                $('#master_info input').val('')
                $('#master_info textarea').val('')
                $('#master_info .specialisation_row').remove()

                if (data) {
                    $('.master_avatar img').attr('src', '/images/masters/' + data.photo)

                    $('.general_info_body input[name="name"]').val(data.name)
                    $('.general_info_body textarea').val(data.description)
                    $('.general_info_body select').val(data.location_id)

                    data.working_hours.forEach(function (item, i) {
                        $('#master_info .working_hours input[name="working_start[' + item.day + ']"]').val(item.start)
                        $('#master_info .working_hours input[name="working_end[' + item.day + ']"]').val(item.end)
                    })

                    if (data.calendar_link) {
                        $('#gcalendar p').html('<a href="' + data.calendar_link + '" target="_blank">Перейти</a>')
                    } else {
                        $('#gcalendar p').html('Персональный календарь не создан. <a>Создать</a>')
                    }

                    data.specialisations.forEach(function (item, i) {
                        let location_name = $('#categories_list li[data-category_id="' + item.category_id + '"]').html()
                        let specialisation = '<div class="specialisation_row">\n' +
                            '                <span data-category_id="' + item.category_id + '">' + location_name + '</span>\n' +
                            '                <img src="/images/close.png">\n' +
                            '            </div>'
                        $('.master_specialisations select').before(function () {
                            return specialisation
                        })
                    })

                    // Устанвливаем необходимые обработчики
                    $('#master_info .specialisation_row img').click(remove_specialisation)

                    // Скрываем уведомление
                    $('#master_info p.alert-center').hide()

                    // Отображаем все поля
                    $('#content #master_info .general_info').css('display', 'flex')
                    $('#content #master_info .working_hours').show()
                    $('#bottom-master-right-column').show()
                    $('#gcalendar').show()
                    $('#content #master_info .master_specialisations').show()
                    $('#content #master_info .buttons').css('display', 'flex')

                    $('#gcalendar p a').click(add_master_calendar)
                } else {
                    $('#services_list h2').after(function () {
                        return '<p class="alert-center">Выберите категорию</p>'
                    })
                }

                stopLoadingAnimation()
            }
        })
    }
}
let open_deleting_master_apply = function () {
    $('#deleting-master-apply').dialog('option', 'buttons', {
        'Подтвердить': function () {
            $(this).dialog('close')
            delete_master()
        },
        'Отменить': function () {
            $(this).dialog('close')
        }
    })

    $('#deleting-master-apply').dialog('open')
}
let close_master_editor = function () {
    // Очищаем все поля
    $('#masters_list ul li').removeClass('selected')

    // Показыванм уведомление
    $('#master_info p.alert-center').show()

    // Скрываем все поля
    $('#content #master_info .general_info').css('display', 'none')
    $('#content #master_info .working_hours').hide()
    $('#content #master_info .master_specialisations').hide()
    $('#content #master_info .buttons').css('display', 'none')

    // Меняем кнопки и поведение кнопки "сохранить"
    $('#master_info button.save').html('Добавить')
    $('#master_info button.delete').hide()
    $('#master_info button.cancel').show()
    $('#master_info button.save').off('click')
    $('#master_info button.save').on('click', add_master)
}
let show_category_services = function () {
    $('#categories_list ul li').removeClass('selected')
    $(this).addClass('selected')

    startLoadingAnimation()
    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/main/get_services',
        data: {
            category_id: $(this).attr('data-category_id')
        },
        dataType: 'json',
        method: 'GET',
        success: function (data) {
            $('#services_list ul').remove()
            $('#services_list p').remove()

            if (data) {
                var services = '<ul>'

                data.forEach(function (item, i) {
                    services += '<li data-service_id="' + item.id + '" data-service_description="' + item.description + '" '
                    services += 'data-service_duration="' + item.duration + '" data-service_price="' + item.price + '">'
                    services += item.name + '</li>'
                })
                services += '</ul>'

                $('#services_list h2').after(function () {
                    return services
                })

                $('#services_list ul li').click({isNewItem: false}, open_service_editor)
            } else {
                $('#services_list h2').after(function () {
                    return '<p class="alert-center">Выберите категорию или создайте услугу</p>'
                })
            }

            stopLoadingAnimation()
        }
    })
}

$(document).ready(function () {
    $('.master_specialisations select').val(0)
    $('.master_specialisations select').change(add_specialisation)
    $('#master_info .master_avatar p').click(function () {
            $('#master_info .master_avatar input').click()
        })
    $('#master_info .master_avatar input').change(function (e) {
        let preview = new FileReader()

        preview.onload = function (photo) {
            let img_preview_url = photo.target.result;
            $('#master_info .master_avatar img').attr('src', img_preview_url)
        }

        preview.readAsDataURL(e.target.files[0])
    })
    
    // Создание модальных окон
    $('.modal').dialog({
        modal: true,
        autoOpen: false,
        closeOnEscape: true,
        width: 750,
        resizable: false
    })

    $('#locations_list button').click({isNewItem: true}, open_location_editor)
    $('#locations_list ul li').click({isNewItem: false}, open_location_editor)

    $('#categories_list button').click({isNewItem: true}, open_category_editor)
    $('#categories_list ul li').click(show_category_services)
    $('#categories_list ul li').dblclick({isNewItem: false}, open_category_editor)


    $('#services_list button').click({isNewItem: true}, open_service_editor)
    $('#services_list ul li').click({isNewItem: false}, open_service_editor)

    $('#masters_list button').click({isNewItem: true}, open_master_editor)
    $('#masters_list ul li').click({isNewItem: false}, open_master_editor)

    $('#master_info .buttons .delete').click(open_deleting_master_apply)
    $('#master_info .buttons .cancel').click(cancel_adding_master)

    $('.time_start').timepicker({
        timeFormat: 'HH:mm',
        interval: 30,
        minTime: '6',
        maxTime: '14:00',
        defaultTime: '9',
        startTime: '9:00',
        dynamic: true,
        dropdown: true,
        scrollbar: true
    })
    $('.time_end').timepicker({
        timeFormat: 'HH:mm',
        interval: 30,
        minTime: '14',
        maxTime: '23:00',
        defaultTime: '20',
        startTime: '20:00',
        dynamic: true,
        dropdown: true,
        scrollbar: true
    })

    // $('select').styler()
})
























