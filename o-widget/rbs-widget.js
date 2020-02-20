let rbsWidget = new Object({
    // Константы
    _rbsURL: 'https://rbs-demo.ivadey.ru/o-widget',
    _dayNames: [
        'Вс',
        'Пн',
        'Вт',
        'Ср',
        'Чт',
        'Пт',
        'Сб'
    ],
    _monthNames: [
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

    // ------------------------------------------------------------

    // Данные
    _reservationInfo: {
        location: {
            id: null,
            address: null
        },
        service: {
            id: null,
            name: null,
            cost: null,
            duration: null,
            category_id: null
        },
        master: {
            id: null,
            name: null
        },
        reservation_date: {
            date: null,
            time: null
        },
        client: {
            name: null,
            phone: null,
            email: null
        },
        isDataValid: function () {
            if (this.location && this.service && this.master && this.reservation_date.date && this.reservation_date.time)
                return true
            else return false
        }
    },
    _signUpValidateStatus: {
        login: false,
        password: false,
        name: false,
        phone: false,
        email: true,
        policyAgreement: false,
        termsAgreement: false,
        isAllValid: function () {
            return this.login && this.password && this.name && this.phone && this.email && this.policyAgreement && this.termsAgreement
        }
    },

    // ------------------------------------------------------------

    // Вспомогательные методы
    // Запуск и остановка анимации загрузки
    _startLoadingAnimation: function () {
        $('#rbs-ajax-load').show()
    },
    _stopLoadingAnimation: function () {
        $('#rbs-ajax-load').hide()
    },
    
    // Перемещение по секциям
    // Возврат в предыдущую секцию
    _backToPrevSection: function () {
        $('section.rbs-active_section').hide()
        $($(this).attr('data-prev_section_id')).show();
        $($(this).attr('data-prev_section_id')).addClass('rbs-active_section');

        switch ($(this).attr('data-prev_section_id')) {
            case '#rbs-location': {
                $(this).hide()
                // Меняем заголовок в шапке виджета
                $('#rbs-header_bottom h3').html('Онлайн запись')
                break
            }
            case '#rbs-general': {
                $(this).attr('data-prev_section_id', '#rbs-location')
                // Меняем заголовок в шапке виджета
                $('#rbs-header_bottom h3').html('Онлайн запись')
                break
            }
            case '#rbs-date_selection': {
                $(this).attr('data-prev_section_id', '#rbs-general')
                break
            }
        }
    },
    // Открытие секции с выбором услуги
    _openServiceSelection: function () {
        // Сперва проверим заполнено ли значение
        // Если да, то просто удаяляем его
        if ($('#rbs-general_service').hasClass('filled')) {
            rbsWidget._deleteServiceChoice()
            return
        }

        $('#rbs-general').hide()
        $('#rbs-general').removeClass('rbs-active_section')
        $('#rbs-service_selection').show()
        $('#rbs-service_selection').addClass('rbs-active_section')

        // Меняем заголовок в шапке виджета
        $('#rbs-header_bottom h3').html('Выбор услуги')

        // Показываем кнопку назад и задаем ее ссылку
        $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-general')
    },
    // Открытие секции с выбором мастера
    _openMasterSelection: function () {
        // Сперва проверим заполнено ли значение
        // Если да, то просто удаяляем его
        if ($('#rbs-general_master').hasClass('filled')) {
            rbsWidget._deleteMasterChoice()
            return
        }

        $('#rbs-general').hide()
        $('#rbs-general').removeClass('rbs-active_section')
        $('#rbs-master_selection').show()
        $('#rbs-master_selection').addClass('rbs-active_section')

        // Меняем заголовок в шапке виджета
        $('#rbs-header_bottom h3').html('Выбор мастера')

        // Показываем кнопку назад и задаем ее ссылку
        $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-general')
    },
    // Открытие секции с календарем и выбором даты
    _openDateSelection: function (dateText) {
        // Сперва проверим заполнено ли значение
        // Если да, то просто удаяляем его
        if ($('#rbs-general_time').hasClass('filled')) {
            rbsWidget._deleteTimeChoice()
            return
        }

        // Сперва проверим, что выбрана услуга, иначе ловить ничего
        if (!rbsWidget._reservationInfo.service.id) {
            alert('Сперва необходимо выбрать услугу')
            return
        }

        $('#rbs-general').hide()
        $('#rbs-general').removeClass('rbs-active_section')
        $('#rbs-date_selection').show()
        $('#rbs-date_selection').addClass('rbs-active_section')

        // Меняем заголовок в шапке виджета
        $('#rbs-header_bottom h3').html('Выбор даты и времени')

        // Показываем кнопку назад и задаем ее ссылку
        $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-general')
    },
    // Открытие финальной секции с вводом данных клиента и записью
    _openClientInfoSection: function () {
        $('.rbs-reservation_details_body h5').html(rbsWidget._reservationInfo.service.name)
        $('.rbs-reservation_details_body .rbs-master_name').html(rbsWidget._reservationInfo.master.name)
        $('.rbs-reservation_details_body .rbs-location_address').html(rbsWidget._reservationInfo.location.address)
        $('.rbs-reservation_details_body .rbs-service_cost').html(rbsWidget._reservationInfo.service.cost + ' руб.')
        $('.rbs-reservation_details_body .rbs-service_duration').html(rbsWidget._reservationInfo.service.duration + ' мин')

        $('#rbs-general').hide()
        $('#rbs-general').removeClass('rbs-active_section')
        $('#rbs-client_info').show()
        $('#rbs-client_info').addClass('rbs-active_section')

        // Меняем заголовок в шапке виджета
        $('#rbs-header_bottom h3').html('Данные для записи')

        // Показываем кнопку назад и задаем ее ссылку
        $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-general')
    },
    // Открытие личного кабинета (авторизация или сам личный кабинет)
    _openUserLkSection: function () {
        if (getCookie('rbsUserAccessToken')) {
            rbsWidget._openLk()
        } else {
            rbsWidget._openAuthForm()
        }

        // Показываем кнопку назад и задаем ее ссылку
        $('#rbs-header_top button').show()
        $('#rbs-header_top button').attr('data-prev_section_id', '#' + $('.rbs-active_section').attr('id'))

        $('.rbs-active_section').hide()
        $('.rbs-active_section').removeClass('rbs-active_section')
        $('#rbs-user_lk').show()
        $('#rbs-user_lk').addClass('rbs-active_section')

        $('#rbs-open_menu').removeClass('rbs-active_menu')
    },

    // Удаление выбора услуги
    _deleteServiceChoice: function () {
        rbsWidget._reservationInfo.service = {
            id: null,
            name: null,
            cost: null,
            duration: null,
            category_id: null
        }

        $('#rbs-general_service').removeClass('filled')
        $('#rbs-general_service h4').html('Выберите услугу')
        $('#rbs-general_service h4').addClass('rbs-title_placeholder')
    },
    // Удалени выбора мастера
    _deleteMasterChoice: function () {
        rbsWidget._reservationInfo.master = {
            id: null,
            name: null
        }

        $('#rbs-general_master').removeClass('filled')
        $('#rbs-general_master h4').html('Выберите мастера')
        $('#rbs-general_master h4').addClass('rbs-title_placeholder')
    },
    // Удаление выбора времени
    _deleteTimeChoice: function () {
        rbsWidget._reservationInfo.reservation_date = {
            date: null,
            time: null
        }

        $('#rbs-general_time').removeClass('filled')
        $('#rbs-general_time h4').html('Выберите время')
        $('#rbs-general_time h4').addClass('rbs-title_placeholder')

        // Обновляем список мастеров
        rbsWidget._ajaxInitMasters()
    },

    // Обработка смены даты в секции выбора времени даты
    _timeSectionChangeDate: function () {
        let date = $(this).attr('data-date')
        if (date.length == 1)
            date = '0' + date
        let month = $(this).attr('data-month')
        if (month.length == 1)
            month = '0' + month
        let year = $(this).attr('data-year')

        // Сохраняем результат
        $('#rbs-general_time h4').attr('data-date_n_time', date + '.' + month + '.' + year)
        rbsWidget._reservationInfo.reservation_date.date = date + '.' + month + '.' + year
        rbsWidget._reservationInfo.reservation_date.time = null

        rbsWidget._initTimeSectionHeader(date + '.' + month + '.' + year)
        rbsWidget._ajaxInitTimeSelection()
    },
    _timeSectionPrevDay: function () {
        $('.rbs-day_item.rbs-current').prev().click()
    },
    _timeSectionNextDay: function () {
        $('.rbs-day_item.rbs-current').next().click()
    },

    // Открытие виджета
    _openWidget: function () {
        $('#rbs-widget #rbs-close_widget').css({
            'height': '64px',
            'transition': 'height 0.5s ease 0s'
        })
        $('#rbs-widget').css({
            'height': '100%',
            'transition': 'height 0.5s ease 0s'
        })
        $('#rbs-open_menu').show('slow')
    },
    // Закрытие виджета
    _closeWidget: function () {
        $(this).css({
            'height': '0',
            'transition': 'height 0.5s ease 0s'
        })
        $('#rbs-widget').css({
            'height': '0',
            'transition': 'height 0.5s ease 0s'
        })
        $('#rbs-open_menu').removeClass('rbs-active_menu')
        $('#rbs-open_menu').hide('slow')
    },

    // Работа со списком мастеров
    // Отрисовка пятизвездочного рейтинга
    _updateRating: function () {
        $('.rbs-master_rating').each(function (ind, item) {
            let rating = Number($(item).attr('data-rating_value'))
            let rt_size = (rating / 5) * 80
            $(item).children('.rbs-rating_value').css('clip', 'rect(auto, ' + rt_size + 'px, auto, 0)')
        })
    },
    // Открытие описания мастера
    _openMasterDescription: function (e) {
        $(this).parent().parent().children('.rbs-master_description').show()
        e.stopPropagation()
    },
    // Закрытие описания мастера
    _closeMasterDescription: function (e) {
        $(this).parent().hide()
        e.stopPropagation()
    },

    // Валидация данных
    _validateClientInfo: function () {
        let dataValid = true
        $('#rbs-error_message').html('')

        // Валидация имени
        if (!$('#rbs-client_info input[name="name"]').val()) {
            $('#rbs-error_message').append('Укажите как к вам обращаться<br>')
            $('#rbs-error_message').show()
            $('#rbs-client_info input[name="name"]').addClass('rbs-data_error')
            dataValid = false
        }

        // Валидация телефона
        if (!$('#rbs-client_info input[name="phone"]').val()) {
            $('#rbs-error_message').append('Укажите ваш контактный номер телефона<br>')
            $('#rbs-error_message').show()
            $('#rbs-client_info input[name="phone"]').addClass('rbs-data_error')
            dataValid = false
        } else {
            let reg = /^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/
            let phone = $('#rbs-client_info input[name="phone"]').val()

            if (!reg.test(phone)) {
                $('#rbs-error_message').append('Номер телефона содержит ошибку<br>')
                $('#rbs-error_message').show()
                $('#rbs-client_info input[name="phone"]').addClass('rbs-data_error')
                dataValid = false
            }
        }

        // Валидация email
        if ($('#rbs-client_info input[name="email"]').val()) {
            let reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/
            let email = $('#rbs-client_info input[name="email"]').val()

            if (!reg.test(email)) {
                $('#rbs-error_message').append('Данный email адрес содержит ошибку<br>')
                $('#rbs-error_message').show()
                $('#rbs-client_info input[name="email"]').addClass('rbs-data_error')
                dataValid = false
            }
        }

        // Валидация согласия с пользовательским соглашением
        if (!$('#rbs-client_info input[type="checkbox"]').is(':checked')) {
            $('#rbs-error_message').append('Вам необходимо согласитья с пользовательским соглашением<br>')
            $('#rbs-error_message').show()
            dataValid = false
        }

        return dataValid
    },
    _validateSignUpForm: function () {
        // Валидация логина (проверка на уникальность)
        $('#rbs-signup_form input[name="login"]').keyup(function () {
            $.ajax({
                url: 'https://rbs-demo.ivadey.ru/users/check_username',
                data: {
                    login: $('#rbs-signup_form input[name="login"]').val(),
                    access_token: 'widget-token'
                },
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data.error_code) {
                        $('#rbs-signup_form input[name="login"]').addClass('data-error')
                        $('#rbs-signup_form input[name="login"]').parent().next('span.rbs-error_message').html('Данный логин уже занят')
                        rbsWidget._signUpValidateStatus.login = false
                    } else {
                        $('#rbs-signup_form input[name="login"]').removeClass('data-error')
                        $('#rbs-signup_form input[name="login"]').parent().next('span.rbs-error_message').html('')
                        rbsWidget._signUpValidateStatus.login = true
                    }
                }
            })
        })

        // Валидация пароля (проверка на совпадение)
        $('#rbs-signup_form input[name="password"]').change(function () {
            let password = $('#rbs-signup_form input[name="password"]').val()
            let password_rep = $('#rbs-signup_form input[name="password_rep"]').val()

            if (password == password_rep || !password_rep) {
                $('#rbs-signup_form input[name="password"]').removeClass('data-error')
                $('#rbs-signup_form input[name="password_rep"]').removeClass('data-error')
                $('#rbs-signup_form input[name="password"]').parent().next('span.rbs-error_message').html('')
                rbsWidget._signUpValidateStatus.password = true
            } else {
                $('#rbs-signup_form input[name="password"]').addClass('data-error')
                $('#rbs-signup_form input[name="password_rep"]').addClass('data-error')
                $('#rbs-signup_form input[name="password"]').parent().next('span.rbs-error_message').html('Пароли не совпадают')
                rbsWidget._signUpValidateStatus.password = false
            }
        })
        $('#rbs-signup_form input[name="password_rep"]').change(function () {
            let password = $('#rbs-signup_form input[name="password"]').val()
            let password_rep = $('#rbs-signup_form input[name="password_rep"]').val()

            if (password == password_rep) {
                $('#rbs-signup_form input[name="password"]').removeClass('data-error')
                $('#rbs-signup_form input[name="password_rep"]').removeClass('data-error')
                $('#rbs-signup_form input[name="password"]').parent().next('span.rbs-error_message').html('')
                rbsWidget._signUpValidateStatus.password = true
            } else {
                $('#rbs-signup_form input[name="password"]').addClass('data-error')
                $('#rbs-signup_form input[name="password_rep"]').addClass('data-error')
                $('#rbs-signup_form input[name="password"]').parent().next('span.rbs-error_message').html('Пароли не совпадают')
                rbsWidget._signUpValidateStatus.password = false
            }
        })

        // Проверка имени
        $('#rbs-signup_form input[name="name"]').keyup(function () {
            if ($(this).val()) {
                $('#rbs-signup_form input[name="name"]').removeClass('data-error')
                $('#rbs-signup_form input[name="name"]').parent().next('span.rbs-error_message').html('')
                rbsWidget._signUpValidateStatus.name = true
            } else {
                $('#rbs-signup_form input[name="name"]').addClass('data-error')
                $('#rbs-signup_form input[name="name"]').parent().next('span.rbs-error_message').html('Введите имя')
                rbsWidget._signUpValidateStatus.name = false
            }
        })

        // Валидация номера телефона
        $('#rbs-signup_form input[name="phone"]').keyup(function () {
            if (!$('#rbs-signup_form input[name="phone"]').val()) {
                $('#rbs-signup_form input[name="phone"]').addClass('data-error')
                $('#rbs-signup_form input[name="phone"]').parent().next('span.rbs-error_message').html('Введите номер телефона')
                rbsWidget._signUpValidateStatus.phone = false
            } else {
                let reg = /^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/
                let phone = $('#rbs-signup_form input[name="phone"]').val()

                if (!reg.test(phone)) {
                    $('#rbs-signup_form input[name="phone"]').addClass('data-error')
                    $('#rbs-signup_form input[name="phone"]').parent().next('span.rbs-error_message').html('Введите номер телефона')
                    rbsWidget._signUpValidateStatus.phone = false
                } else {
                    $('#rbs-signup_form input[name="phone"]').removeClass('data-error')
                    $('#rbs-signup_form input[name="phone"]').parent().next('span.rbs-error_message').html('')
                    rbsWidget._signUpValidateStatus.phone = true
                }
            }
        })

        // Валидация email
        $('#rbs-signup_form input[name="email"]').keyup(function () {
            let reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/
            let email = $('#rbs-signup_form input[name="email"]').val()

            if (!email) {
                $('#rbs-signup_form input[name="email"]').removeClass('data-error')
                $('#rbs-signup_form input[name="email"]').parent().next('span.rbs-error_message').html('')
                rbsWidget._signUpValidateStatus.email = true
            } else {
                if (!reg.test(email)) {
                    $('#rbs-signup_form input[name="email"]').addClass('data-error')
                    $('#rbs-signup_form input[name="email"]').parent().next('span.rbs-error_message').html('Некорректный email адрес')
                    rbsWidget._signUpValidateStatus.email = false
                } else {
                    $('#rbs-signup_form input[name="email"]').removeClass('data-error')
                    $('#rbs-signup_form input[name="email"]').parent().next('span.rbs-error_message').html('')
                    rbsWidget._signUpValidateStatus.email = true
                }
            }
        })

        // Валидация согласия с политикой конфиденциальности
        $('#rbs-signup_form input[name="policy-agreement"]').change(function () {
            if (!$('#rbs-signup_form input[name="policy-agreement"]').is(':checked')) {
                $('#rbs-signup_form input[name="policy-agreement"]').parent().next('span.rbs-error_message').html('Вам необходимо согласитья с политикой конфиденциальности')
                rbsWidget._signUpValidateStatus.policyAgreement = false
            } else {
                $('#rbs-signup_form input[name="policy-agreement"]').parent().next('span.rbs-error_message').html('')
                rbsWidget._signUpValidateStatus.policyAgreement = true
            }
        })

        // Валидация согласия с пользовательским соглашением
        $('#rbs-signup_form input[name="terms-agreement"]').change(function () {
            if (!$('#rbs-signup_form input[name="terms-agreement"]').is(':checked')) {
                $('#rbs-signup_form input[name="terms-agreement"]').parent().next('span.rbs-error_message').html('Вам необходимо согласитья с пользовательским соглашением')
                rbsWidget._signUpValidateStatus.termsAgreement = false
            } else {
                $('#rbs-signup_form input[name="terms-agreement"]').parent().next('span.rbs-error_message').html('')
                rbsWidget._signUpValidateStatus.termsAgreement = true
            }
        })
    },
    // Маска ввода номера телефона
    _setPhoneMask: function (elem) {
        // Устанавливаем в value нашу маску, когда получаем фокус и если данных еще нет
        elem.focus(function () {
            if (!elem.val()) {
                elem.next().addClass('head_hint')
                elem.val('+7 (___) ___-__-__')
            }
        })

        // Обрабатываем ввод
        elem.keydown(function (e) {
            reg = /\+7|\(|\)|\s|-|_/g
            let phone = elem.val().replace(reg, '')

            // Если это цифра, то...
            if (e.which >= 48 && e.which <=57) {
                // Проверим длину текущего номер
                // Если он уже полностью введен, то продолжать не будем
                if (phone.length < 10) {
                    phone += String.fromCharCode(e.which)
                }
            } else if (e.which == 8) {
                // Если это backspace, то удаляем послуднюю цифру из номера
                // При условии, что он не пустой
                if (phone.length > 0)
                    phone = phone.slice(0, phone.length - 1)
            } else if (e.which == 9 ) {
                return
            }

            let value = '+7 ('
            value += phone[0] ? phone[0] : '_'
            value += phone[1] ? phone[1] : '_'
            value += phone[2] ? phone[2] : '_'
            value += ') '
            value += phone[3] ? phone[3] : '_'
            value += phone[4] ? phone[4] : '_'
            value += phone[5] ? phone[5] : '_'
            value += '-'
            value += phone[6] ? phone[6] : '_'
            value += phone[7] ? phone[7] : '_'
            value += '-'
            value += phone[8] ? phone[8] : '_'
            value += phone[9] ? phone[9] : '_'

            $(this).val(value)
            this.selectionStart = value.indexOf('_')
            this.selectionEnd = value.indexOf('_')

            return false
        })

        // Когда теряем фокус, то удаляем value, если ничего не ввели
        elem.blur(function () {
            let reg = /^\+7\s\(_{3}\)\s_{3}-_{2}-_{2}$/
            let phone = elem.val()

            if (reg.test(phone)) {
                elem.val('')
                elem.next().removeClass('head_hint')
            }
        })
    },

    // Подключение необходимых файлов и библиотек
    _includeFiles: function () {
        let head = window.document.getElementsByTagName('head')[0]

        // Подключаем основные стили виджета
        let cssLink = document.createElement( "link" )
        cssLink.href = this._rbsURL + '/rbs-widget.css'
        cssLink.type = "text/css"
        cssLink.rel = "stylesheet"
        head.appendChild(cssLink)
    },

    // ------------------------------------------------------------

    // Генерация элементов HTML шаблона
    _createHeaderTop: function () {
        let headerTopHTML = '<div id="rbs-header_top">\n' +
            '            <button class="ui-helper-hidden" data-prev_section_id=""></button>\n' +
            '            <div class="rbs-logo">\n' +
            '                <img src="' + this._rbsURL + '/images/header-logo.png" class="rbs-logo_mini">\n' +
            '                <span>IvaDey journal</span>\n' +
            '            </div>\n' +
            '        </div>'

        return headerTopHTML
    },
    _createHeaderBottom: function () {
        let headerBottom = '<div id="rbs-header_bottom">\n' +
            '            <h3>Онлайн запись</h3>\n' +
            '        </div>'

        return headerBottom
    },
    _createLocationSection: function () {
        let locationSection = '<section id="rbs-location" class="rbs-active_section">\n' +
            '            </section>'

        return locationSection
    },
    _createGeneralSection: function () {
        let generalSection = '<section class="ui-helper-hidden" id="rbs-general">\n' +
            '                <div id="rbs-general_service" class="rbs-general_item">\n' +
            '                    <h4 class="rbs-title_placeholder">Выберите услугу</h4>\n' +
            '                    <span class="rbs-general_item_description"></span>\n' +
            '                </div>\n' +
            '                <div id="rbs-general_master" class="rbs-general_item">\n' +
            '                    <h4 class="rbs-title_placeholder">Выберите мастера</h4>\n' +
            '                    <span class="rbs-general_item_description"></span>\n' +
            '                </div>\n' +
            '                <div id="rbs-general_time" class="rbs-general_item">\n' +
            '                    <h4 class="rbs-title_placeholder">Выберите время</h4>\n' +
            '                    <span class="rbs-general_item_description"></span>\n' +
            '                </div>\n' +
            '\n' +
            '                <button>Оформить визит</button>\n' +
            '            </section>'

        return generalSection
    },
    _createServicesSection: function () {
        let servicesSection = '<section class="ui-helper-hidden" id="rbs-service_selection">\n' +
            '                <div class="rbs-services_group" data-category_id="1">\n' +
            '                    <h4 class="opened">Женские стрижки</h4>\n' +
            '                    <div class="rbs-services_group_body">\n' +
            '                        <div class="rbs-service_item">\n' +
            '                            <h5 data-service_id="1" data-service_cost="1000" data-service_duration="45">Классическая стрижка</h5>\n' +
            '                            <p class="rbs-service_description">Классическая стрижки, идите в жопу</p>\n' +
            '                            <button></button><div class="rbs-service_info">\n' +
            '                                <span class="rbs-service_cost">1000 руб.</span>\n' +
            '                                <span class="rbs-service_duration rbs-time_ico">45 мин</span>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                        <div class="rbs-service_item">\n' +
            '                            <h5 data-service_id="10" data-service_cost="1200" data-service_duration="60">Укладка</h5>\n' +
            '                            <p class="rbs-service_description">Укладка волос</p>\n' +
            '                            <button></button><div class="rbs-service_info">\n' +
            '                                <span class="rbs-service_cost">1200 руб.</span>\n' +
            '                                <span class="rbs-service_duration rbs-time_ico">60 мин</span>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '                <div class="rbs-services_group" data-category_id="2">\n' +
            '                    <h4>Мужские стрижки</h4>\n' +
            '                    <div class="ui-helper-hidden rbs-services_group_body">\n' +
            '                        <div class="rbs-service_item">\n' +
            '                            <h5 data-service_id="2" data-service_cost="700" data-service_duration="30">Классическая стрижка</h5>\n' +
            '                            <p class="rbs-service_description">Классическая стрижка</p>\n' +
            '                            <button></button><div class="rbs-service_info">\n' +
            '                                <span class="rbs-service_cost">700 руб.</span>\n' +
            '                                <span class="rbs-service_duration rbs-time_ico">30 мин</span>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </section>'

        return servicesSection
    },
    _createMastersSection: function () {
        let mastersSection = '<section class="ui-helper-hidden" id="rbs-master_selection">\n' +
            '            </section>'

        return mastersSection
    },
    _createDateSection: function () {
        let dateSection = '<section class="ui-helper-hidden" id="rbs-date_selection">\n' +
            '                <input type="hidden" name="date">\n' +
            '                <div id="rbs-date_calendar"></div>\n' +
            '            </section>'

        return dateSection
    },
    _createTimeSection: function () {
        let timeSection = '<section class="ui-helper-hidden" id="rbs-time_selection">\n' +
            '                <div class="rbs-time_selection_header">\n' +
            '                    <button class="rbs-prev-day"></button>\n' +
            '                    <div class="rbs-time_selection rbs-day_item">\n' +
            '                        <span class="rbs-month_day">18</span>\n' +
            '                        <span class="rbs-day_name">Чт</span>\n' +
            '                    </div>\n' +
            '                    <div class="rbs-time_selection rbs-day_item">\n' +
            '                        <span class="rbs-month_day">19</span>\n' +
            '                        <span class="rbs-day_name">Пт</span>\n' +
            '                    </div>\n' +
            '                    <div class="rbs-time_selection rbs-day_item rbs-current">\n' +
            '                        <span class="rbs-month_name">Июль</span>\n' +
            '                        <span class="rbs-month_day">20</span>\n' +
            '                        <span class="rbs-day_name">Сб</span>\n' +
            '                    </div>\n' +
            '                    <div class="rbs-time_selection rbs-day_item">\n' +
            '                        <span class="rbs-month_day">20</span>\n' +
            '                        <span class="rbs-day_name">Вс</span>\n' +
            '                    </div>\n' +
            '                    <div class="rbs-time_selection rbs-day_item">\n' +
            '                        <span class="rbs-month_day">21</span>\n' +
            '                        <span class="rbs-day_name">Пн</span>\n' +
            '                    </div>\n' +
            '                    <button class="rbs-next-day"></button>\n' +
            '                </div>\n' +
            '                <div class="rbs-time_selection_body">\n' +
            '                                        <label><input type="radio" name="time" value="9:00"><div class="rbs-time_variant">9:00</div></label>\n' +
            '                                        <label><input type="radio" name="time" value="9:30"><div class="rbs-time_variant">9:30</div></label>\n' +
            '                                        <label><input type="radio" name="time" value="10:00"><div class="rbs-time_variant">10:00</div></label>\n' +
            '                </div>\n' +
            '            </section>'

        return timeSection
    },
    _createClientSection: function () {
        let clientSection = '<section class="ui-helper-hidden" id="rbs-client_info">\n' +
            '                <div class="rbs-reservation_details">\n' +
            '                    <h4>Посмотреть детали</h4>\n' +
            '                    <div class="rbs-reservation_details_body">\n' +
            '                        <h5>Service name</h5>\n' +
            '                        <span class="rbs-master_name">Jhon</span>,\n' +
            '                        <span class="rbs-location_address">ул. Каспийская, д.3</span>\n' +
            '                        <div>\n' +
            '                            <span class="rbs-service_cost">1 000 руб.</span>\n' +
            '                            <span class="rbs-service_duration">45 мин</span> <!-- Иконку часов можно добавить при помощи ::before-->\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '\n' +
            '                <label>Имя:<br><input type="text" name="name" placeholder="Тимофей"></label>\n' +
            '                <label>Телефон:<br><input type="text" name="phone" placeholder="+7 (999) 999-99-99"></label>\n' +
            '                <label>Email:<br><input type="email" name="email" placeholder="mail@domen.com"></label>\n' +
            '                <!--                <label>Комментарий к записи:<br><textarea name="user_comment"></textarea></label>-->\n' +
            '                <label><input type="checkbox">Я принимаю <a href="#">условия пользовательского соглашения</a></label>\n' +
            '\n' +
            '                <button id="rbs-sign_up">Записаться</button>\n' +
            '            </section>'

        return clientSection
    },
    _createStatusSection: function () {
        let statusSection = '<section class="ui-helper-hidden" id="rbs-reservation_status">\n' +
            '                <h4>Посмотреть детали</h4>\n' +
            '                <div class="rbs-reservation_status_body">\n' +
            // '                <div class="rbs-reservation_details_body">\n' +
            // '                    <h5>Service name</h5>\n' +
            // '                    <span class="rbs-master_name">Jhon</span>,\n' +
            // '                    <span class="rbs-location_address">ул. Каспийская, д.3</span>\n' +
            // '                    <div>\n' +
            // '                        <span class="rbs-service_cost">1 000 руб.</span>\n' +
            // '                        <span class="rbs-service_duration">45 мин</span>\n' +
            // '                    </div>\n' +
            '                </div>\n' +
            '            </section>'

        return statusSection
    },
    _createUserLkSection: function () {
        let statusSection = '<section class="ui-helper-hidden" id="rbs-user_lk"></section>'

        return statusSection
    },
    _createMain: function () {
        let mainHTML = '<main>'

        mainHTML += this._createLocationSection()
        mainHTML += this._createGeneralSection()
        mainHTML += this._createServicesSection()
        mainHTML += this._createMastersSection()
        mainHTML += this._createDateSection()
        mainHTML += this._createTimeSection()
        mainHTML += this._createClientSection()
        mainHTML += this._createStatusSection()
        mainHTML += this._createUserLkSection()

        mainHTML += '<div id="rbs-error_message"></div>'
        mainHTML += '<div id="rbs-ajax-load"></div></main>'

        return mainHTML
    },
    _createFooter: function () {
        let footerHTML = '<footer>\n' +
            '            Сделано <a href="http://ivadey.ru/widget.php" target="_blank">IvaDey journal</a>\n' +
            '        </footer>'

        return footerHTML
    },
    _createUserMenu: function () {
        let userMenu = '<button id="rbs-open_menu"><span></span></button>'
        userMenu += '<div id="rbs-menu_body">'
        userMenu += '<h4>Меню</h4>'
        userMenu += '<ul>'
        userMenu += '<li id="rbs-open_lk">Личный кабинет</li>'
        userMenu += '</ul>'
        userMenu += '</div>'

        return userMenu
    },

    // Генерация HTML обертки и инициализация
    _createWidgetWrap: function () {
        let widgetHTML = '<div id="rbs-widget">\n' +
            '    <div id="rbs-widget-wrap">'

        widgetHTML += this._createHeaderTop()
        widgetHTML += this._createHeaderBottom()
        widgetHTML += this._createMain()
        widgetHTML += this._createFooter()
        widgetHTML += this._createUserMenu()

        widgetHTML += '</div>'
        widgetHTML += '<button id="rbs-close_widget"></button>'
        widgetHTML += '</div>'

        $('body').append(widgetHTML)
    },

    // ------------------------------------------------------------
    // Работа с меню и личным кабинетом пользователя
    // Открытие меню
    _openMenu: function () {
        $(this).toggleClass('rbs-active_menu')
    },
    // Открытие личного кабинета (или перенаправление на форму авторизации)
    _openLk: function () {
        let userAccessToken = getCookie('rbsUserAccessToken')
        if (userAccessToken) {
            let lk = '<h4>Hi there</h4>' +
                '<button onclick="rbsWidget._logout();">Выйти</button>'
            $('#rbs-user_lk').html(lk)

            // Меняем заголовок в шапке виджета
            $('#rbs-header_bottom h3').html('Личный кабинет')
        } else {
            rbsWidget._openAuthForm()
        }
    },
    // Открытие формы авторизации
    _openAuthForm: function () {
        // Форма авторизации
        let authSection = '<div id="rbs-auth_form">'
        authSection += '<form>'
        authSection += '<label><img src="https://rbs-demo.ivadey.ru/o-widget/images/login-ico.png"><input type="text" name="login"><span>Логин</span></label>'
        authSection += '<label><img src="https://rbs-demo.ivadey.ru/o-widget/images/password-ico.png"><input type="password" name="password"><span>Пароль</span></label>'
        authSection += '<button>Войти</button>'
        authSection += '</form>'
        authSection += '<a href="#" id="rbs-recover">Забыли пароль?</a>'
        authSection += '<a href="#" id="rbs-signup">Регистрация</a>'
        authSection += '</div>'

        $('#rbs-user_lk').html(authSection)

        $('#rbs-recover').click(function () {
            alert('Данная функция временно недоступна')
        })
        $('#rbs-signup').click(rbsWidget._openSignUpForm)
        $('#rbs-auth_form form button').click(rbsWidget._auth)

        // Делаем динамический placeholder
        $('#rbs-auth_form input').keyup(function () {
            if ($(this).val() == '')
                $(this).next().removeClass('head_hint')
            else $(this).next().addClass('head_hint')
        })

        // Меняем заголовок в шапке виджета
        $('#rbs-header_bottom h3').html('Авторизация')
    },
    // Открытие формы регистрации
    _openSignUpForm: function () {
        // Форма регистрации
        let signUpSection = '<div id="rbs-signup_form">'
        signUpSection += '<form>'
        signUpSection += '<label><img src="https://rbs-demo.ivadey.ru/o-widget/images/login-ico.png"><input type="text" name="login"><span>Придумайте логин</span></label>'
        signUpSection += '<span class="rbs-error_message"></span>'
        signUpSection += '<label><img src="https://rbs-demo.ivadey.ru/o-widget/images/password-ico.png"><input type="password" name="password"><span>Придумайте пароль</span></label>'
        signUpSection += '<span class="rbs-error_message"></span>'
        signUpSection += '<label><img src="https://rbs-demo.ivadey.ru/o-widget/images/password-ico.png"><input type="password" name="password_rep"><span>Повторите пароль</span></label>'
        signUpSection += '<span class="rbs-error_message"></span>'
        signUpSection += '<label><img src="https://rbs-demo.ivadey.ru/o-widget/images/name-ico.png"><input type="text" name="name"><span>Имя</span></label>'
        signUpSection += '<span class="rbs-error_message"></span>'
        signUpSection += '<label><img src="https://rbs-demo.ivadey.ru/o-widget/images/name-ico.png"><input type="text" name="surname"><span>Фамилия</span></label>'
        signUpSection += '<span class="rbs-error_message"></span>'
        signUpSection += '<label><img src="https://rbs-demo.ivadey.ru/o-widget/images/phone-ico.png"><input type="text" name="phone"><span>Номер телефона</span></label>'
        signUpSection += '<span class="rbs-error_message"></span>'
        signUpSection += '<label><img src="https://rbs-demo.ivadey.ru/o-widget/images/email-ico.png"><input type="email" name="email"><span>Email</span></label>'
        signUpSection += '<span class="rbs-error_message"></span>'
        signUpSection += '<label class="agreement-checks"><input type="checkbox" name="policy-agreement">Согласен с&nbsp;<a href="https://ivadey.ru/user-policy">политикой конифденциальности</a></label>'
        signUpSection += '<span class="rbs-error_message"></span>'
        signUpSection += '<label class="agreement-checks"><input type="checkbox" name="terms-agreement">Согласен с&nbsp;<a href="https://ivadey.ru/user-terms">пользовательским соглашением</a></label>'
        signUpSection += '<span class="rbs-error_message"></span>'
        signUpSection += '<button>Зарегистрироваться</button>'
        signUpSection += '</form>'
        signUpSection += '</div>'

        $('#rbs-user_lk').html(signUpSection)

        rbsWidget._setPhoneMask($('#rbs-signup_form form input[name="phone"]'))
        rbsWidget._validateSignUpForm()
        $('#rbs-signup_form form button').click(rbsWidget._signUp)

        // Делаем динамический placeholder
        $('#rbs-signup_form input').keyup(function () {
            if ($(this).val() == '')
                $(this).next().removeClass('head_hint')
            else $(this).next().addClass('head_hint')
        })

        // Меняем заголовок в шапке виджета
        $('#rbs-header_bottom h3').html('Регистрация')
    },
    // Авторизация
    _auth: function () {
        let login = $('#rbs-auth_form input[name="login"]').val()
        let password= $('#rbs-auth_form input[name="password"]').val()

        rbsWidget._startLoadingAnimation()

        $.ajax({
            url: 'https://rbs-demo.ivadey.ru/users/login',
            data: {
                login: login,
                password: password,
                access_token: 'widget-token'
            },
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data.error_code == 0) {
                    setCookie('rbsUserAccessToken', data.access_token)
                    rbsWidget._openLk()
                } else {
                    alert('Неправльные логин или пароль')
                }

                rbsWidget._stopLoadingAnimation()
            }
        })

        return false
    },
    // Регистрация
    _signUp: function () {
        if (!rbsWidget._signUpValidateStatus.isAllValid()) {
            if (!rbsWidget._signUpValidateStatus.login) {
                $('#rbs-signup_form input[name="login"]').addClass('data-error')
                $('#rbs-signup_form input[name="login"]').parent().next('span.rbs-error_message').html('Введите login')
            }
            if (!rbsWidget._signUpValidateStatus.password) {
                $('#rbs-signup_form input[name="password"]').addClass('data-error')
                $('#rbs-signup_form input[name="password"]').parent().next('span.rbs-error_message').html('Введите Пароль')
            }
            if (!rbsWidget._signUpValidateStatus.name) {
                $('#rbs-signup_form input[name="name"]').addClass('data-error')
                $('#rbs-signup_form input[name="name"]').parent().next('span.rbs-error_message').html('Введите имя')
            }
            if (!rbsWidget._signUpValidateStatus.phone) {
                $('#rbs-signup_form input[name="phone"]').addClass('data-error')
                $('#rbs-signup_form input[name="phone"]').parent().next('span.rbs-error_message').html('Введите телефон')
            }
            if (!rbsWidget._signUpValidateStatus.email) {
                $('#rbs-signup_form input[name="email"]').addClass('data-error')
                $('#rbs-signup_form input[name="email"]').parent().next('span.rbs-error_message').html('Введите корректный email')
            }
            if (!rbsWidget._signUpValidateStatus.policyAgreement) {
                $('#rbs-signup_form input[name="policy-agreement"]').addClass('data-error')
                $('#rbs-signup_form input[name="policy-agreement"]').parent().next('span.rbs-error_message').html('Вам необходимо согласитья с политикой конфиденциальности')
            }
            if (!rbsWidget._signUpValidateStatus.termsAgreement) {
                $('#rbs-signup_form input[name="terms-agreement"]').addClass('data-error')
                $('#rbs-signup_form input[name="terms-agreement"]').parent().next('span.rbs-error_message').html('Вам необходимо согласитья с пользовательским соглашением')
            }
            return false
        }

        let login = $('#rbs-signup_form input[name="login"]').val()
        let password = $('#rbs-signup_form input[name="password"]').val()
        let name = $('#rbs-signup_form input[name="name"]').val()
        let surname = $('#rbs-signup_form input[name="surname"]').val()
        let phone = $('#rbs-signup_form input[name="phone"]').val()
        let email = $('#rbs-signup_form input[name="email"]').val()

        $.ajax({
            url: 'https://rbs-demo.ivadey.ru/users/signup',
            data: {
                login: login,
                password: password,
                name: name,
                surname: surname,
                phone: phone,
                email: email,
                access_token: 'widget-token'
            },
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data.error_code == 0) {
                    document.cookie = 'rbsUserAccessToken=' + data.access_token
                    rbsWidget._openLk()
                } else {
                    alert('Что-то не так. Позже будет больше инфы')
                }
            }
        })

        return false
    },
    // Деавторизация
    _logout: function () {
        setCookie('rbsUserAccessToken', '0', {'max-age': 0})
        // rbsWidget._openUserLkSection()
        $('#rbs-header_top button').click() // Временный костыль, так как может быть ситуация, когда предыдущий экран часть ЛК
    },

    // ------------------------------------------------------------

    // Обработчики различных событий
    // Выбор филиала
    _locationSelected: function () {
        rbsWidget._reservationInfo.location = {
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

        // Подгружаем мастеров
        rbsWidget._ajaxInitMasters()

        // Меняем заголовок в шапке виджета
        $('#rbs-header_bottom h3').html('Онлайн запись')
    },
    // Выбор услуги
    _serviceSelected: function () {
        $('#rbs-service_selection').hide()
        $('#rbs-service_selection').removeClass('rbs-active_section')
        $('#rbs-general').show()
        $('#rbs-general').addClass('rbs-active_section')

        // Сохраняем выбор
        $('#rbs-general_service h4').attr('data-service_id', $(this).attr('data-service_id'))
        $('#rbs-general_service h4').html($(this).html())
        $('#rbs-general_service h4').removeClass('rbs-title_placeholder')
        rbsWidget._reservationInfo.service = {
            id: $(this).attr('data-service_id'),
            name: $(this).html(),
            cost: $(this).attr('data-service_cost'),
            duration: $(this).attr('data-service_duration'),
            category_id: $(this).attr('data-category_id')
        }

        $('#rbs-general_service').removeClass('rbs-data_error')
        $('#rbs-general_service').addClass('filled')

        // Показываем кнопку назад и задаем ее ссылку
        $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-location')

        // Подгружаем мастеров
        rbsWidget._ajaxInitMasters()

        // Меняем заголовок в шапке виджета
        $('#rbs-header_bottom h3').html('Онлайн запись')
    },
    // Выбор мастера
    _masterSelected: function () {
        $('#rbs-master_selection').hide()
        $('#rbs-master_selection').removeClass('rbs-active_section')
        $('#rbs-general').show()
        $('#rbs-general').addClass('rbs-active_section')

        // Сохраняем выбор
        $('#rbs-general_master h4').attr('data-master_id', $(this).children('.rbs-master_info').children('h4').attr('data-master_id'))
        $('#rbs-general_master h4').html($(this).children('.rbs-master_info').children('h4').html())
        $('#rbs-general_master h4').removeClass('rbs-title_placeholder')
        rbsWidget._reservationInfo.master = {
            id: $(this).children('.rbs-master_info').children('h4').attr('data-master_id'),
            name: $(this).children('.rbs-master_info').children('h4').html()
        }

        $('#rbs-general_master').addClass('filled')
        $('#rbs-general_master').removeClass('rbs-data_error')

        // Показываем кнопку назад и задаем ее ссылку
        $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-location')

        // Меняем заголовок в шапке виджета
        $('#rbs-header_bottom h3').html('Онлайн запись')
    },
    // Выбор даты
    _dateSelected: function (dateText) {
        $('#rbs-date_selection').hide()
        $('#rbs-date_selection').removeClass('rbs-active_section')
        $('#rbs-time_selection').show()
        $('#rbs-time_selection').addClass('rbs-active_section')

        // Инициализируем секцию выбора времени
        rbsWidget._initTimeSectionHeader(dateText)

        // Сохраняем выбор
        $('#rbs-general_time h4').attr('data-date_n_time', dateText)
        $('#rbs-general_time h4').html(dateText)
        rbsWidget._reservationInfo.reservation_date.date = dateText
        rbsWidget._reservationInfo.reservation_date.time = null

        // Показываем кнопку назад и задаем ее ссылку
        $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-date_selection')

        rbsWidget._ajaxInitTimeSelection()
    },
    // Выбор времени
    _timeSelected: function () {
        $('#rbs-time_selection').hide()
        $('#rbs-time_selection').removeClass('rbs-active_section')
        $('#rbs-general').show()
        $('#rbs-general').addClass('rbs-active_section')

        // Сохраняем выбор
        $('#rbs-general_time h4').attr('data-date_n_time', $('#rbs-general_time h4').attr('data-date_n_time') + ' ' + $(this).val())
        $('#rbs-general_time h4').html($('#rbs-general_time h4').attr('data-date_n_time'))
        $('#rbs-general_time h4').removeClass('rbs-title_placeholder')
        rbsWidget._reservationInfo.reservation_date.time = $(this).val()

        // Обновлуяем доступных мастеров, если никто не был выбран
        if (!rbsWidget._reservationInfo.master.id) {
            rbsWidget._ajaxInitMasters()
        }

        $('#rbs-general_time').addClass('filled')
        $('#rbs-general_time').removeClass('rbs-data_error')

        // Показываем кнопку назад и задаем ее ссылку
        $('#rbs-header_top button').attr('data-prev_section_id', '#rbs-date_selection')

        // Меняем заголовок в шапке виджета
        $('#rbs-header_bottom h3').html('Онлайн запись')
    },
    // Запись клиента
    _signUpReservation: function () {
        rbsWidget._reservationInfo.client.name = $('#rbs-client_info input[name="name"]').val()
        rbsWidget._reservationInfo.client.phone = $('#rbs-client_info input[name="phone"]').val()
        rbsWidget._reservationInfo.client.email = $('#rbs-client_info input[name="email"]').val()

        rbsWidget._ajaxAddReservation()
    },

    // Обработка работы слайдеров (спойлеров вообще-то...)
    _activateSliders: function () {
        // Слайдер категории услуг
        $('.rbs-services_group h4').click(function () {
            $(this).toggleClass('opened')
            $(this).next().slideToggle()
        })
        // Слайдер подробного описания услуги
        $('.rbs-service_item p + button').click(function () {
            $(this).prev().toggleClass('opened')
        })
    },

    // ------------------------------------------------------------

    // Инициализация секций виджета, в т.ч. ajax инициализация
    // Инициализация секции с выбором филиала
    _ajaxInitLocations: function () {
        rbsWidget._startLoadingAnimation()

        $.ajax({
            url: 'https://rbs-demo.ivadey.ru/main/get_locations',
            data: {
                access_token: 'widget-token'
            },
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

                $('.rbs-location_item').click(rbsWidget._locationSelected)
                rbsWidget._stopLoadingAnimation()
            }
        })
    },
    // Инициализация секции со списком услуг
    _ajaxInitServices: function () {
        $.ajax({
            url: 'https://rbs-demo.ivadey.ru/main/get_grouped_services',
            data: {
                access_token: 'widget-token'
            },
            dataType: 'json',
            success: function (data) {
                let servicesSection = $('#rbs-service_selection')
                servicesSection.html('')

                let isFirst = true
                for (key in data) {
                    let serviceGroup = '<div class="rbs-services_group">'
                    if (isFirst) {
                        serviceGroup += '<h4 class="opened">' + data[key].category_name + '</h4>'

                        serviceGroup += '<div class="rbs-services_group_body">'

                        data[key].services_group.forEach(function (service, ind) {
                            serviceGroup += '<div class="rbs-service_item">'
                            serviceGroup += '<h5 data-service_id="' + service.id + '" data-service_cost="' + service.price + '" ' +
                                'data-service_duration="' + service.duration + '" data-category_id="' + key + '">' +
                                service.name + '</h5>'
                            if (service.description) {
                                serviceGroup += '<p class="rbs-service_description">' + service.description + '</p>'
                                serviceGroup += '<button></button>'
                            } else {
                                serviceGroup += '<p class="rbs-service_description"></p>'
                            }
                            serviceGroup += '<div class="rbs-service_info">'
                            serviceGroup += '<span class="rbs-service_cost">' + service.price + ' руб.</span>'
                            serviceGroup += '<span class="rbs-service_duration rbs-time_ico">' + service.duration + ' мин</span>'
                            serviceGroup += '</div>'
                            serviceGroup += '</div>'
                        })

                        isFirst = false
                    } else {
                        serviceGroup += '<h4>' + data[key].category_name + '</h4>'

                        serviceGroup += '<div class="ui-helper-hidden rbs-services_group_body">'

                        data[key].services_group.forEach(function (service, ind) {
                            serviceGroup += '<div class="rbs-service_item">'
                            serviceGroup += '<h5 data-service_id="' + service.id + '" data-service_cost="' + service.price + '" ' +
                                'data-service_duration="' + service.duration + '" data-category_id="' + key + '">' +
                                service.name + '</h5>'
                            serviceGroup += '<p class="rbs-service_description">Классическая стрижки, идите в жопу</p>'
                            serviceGroup += '<button></button><div class="rbs-service_info">'
                            serviceGroup += '<span class="rbs-service_cost">' + service.price + ' руб.</span>'
                            serviceGroup += '<span class="rbs-service_duration rbs-time_ico">' + service.duration + ' мин</span>'
                            serviceGroup += '</div>'
                            serviceGroup += '</div>'
                        })
                    }

                    serviceGroup += '</div>'
                    serviceGroup += '</div>'

                    servicesSection.append(serviceGroup)
                }

                // Установка необходимых обработчиков
                // Активация слайдеров
                rbsWidget._activateSliders()
                // Выбор услуги
                $('.rbs-service_item h5').click(rbsWidget._serviceSelected)
            }
        })
    },
    // Инициализация секции со списком мастеров из выбранной локации
    _ajaxInitMasters: function () {
        rbsWidget._startLoadingAnimation()

        $.ajax({
            url: 'https://rbs-demo.ivadey.ru/reservations/get_masters',
            data: {
                location_id: rbsWidget._reservationInfo.location.id,
                category_id: rbsWidget._reservationInfo.service.category_id,
                service_id: rbsWidget._reservationInfo.service.id,
                reservation_date: rbsWidget._reservationInfo.reservation_date,
                access_token: 'widget-token'
            },
            dataType: 'json',
            success: function (data) {
                let mastersSection = $('#rbs-master_selection')
                mastersSection.html('')

                data.forEach(function (master, ind) {
                    masterItem = '<div class="rbs-master_item">'
                    masterItem += '<div class="rbs-master_avatar">'
                    // masterItem += '<img class="rbs-master_photo" src="' + rbsWidget._rbsURL + '/images/masters/' + master.photo + '">'
                    masterItem += '<img class="rbs-master_photo" src="https://rbs-demo.ivadey.ru/images/masters/' + master.photo + '">'
                    masterItem += '<button class="rbs-get_master_description_btn"></button>'
                    masterItem += '<div class="rbs-master_rating" data-rating_value="' + master.rating + '">'
                    masterItem += '<img src="' + rbsWidget._rbsURL + '/images/rating-empty.png">'
                    masterItem += '<img src="' + rbsWidget._rbsURL + '/images/rating-full.png" class="rbs-rating_value">'
                    masterItem += '</div>'
                    masterItem += '</div>'
                    masterItem += '<div class="rbs-master_info">'
                    masterItem += '<h4 data-master_id="' + master.id + '">' + master.name + '</h4>'
                    masterItem += '<span class="rbs-master_reviews_link">0 отзывов</span>'
                    masterItem += '</div>'
                    masterItem += '<div class="rbs-master_closest_available_time">'
                    masterItem += '<h5>Ближайшие сеансы <span>' + master.closest_available_time.date + '</span></h5>'
                    master.closest_available_time.time_items.forEach(function (timeItem, ind) {
                        masterItem += '<span>' + timeItem + '</span>'
                    })
                    masterItem += '</div>'
                    masterItem += '<div class="ui-helper-hidden rbs-master_description"><button>Закрыть</button>' + master.description + '</div>'
                    masterItem += '<div class="ui-helper-hidden rbs-master-reviews"></div>'
                    masterItem += '</div>'

                    mastersSection.append(masterItem)
                })

                // Установка необходимых обработчиков
                // Выбор мастера
                $('.rbs-master_item').click(rbsWidget._masterSelected)

                // Открытия описания мастера
                $('button.rbs-get_master_description_btn').click(rbsWidget._openMasterDescription)
                // Закрытие описания мастера
                $('.rbs-master_description button').click(rbsWidget._closeMasterDescription)

                // Отрисовка рейтинга
                rbsWidget._updateRating()

                rbsWidget._stopLoadingAnimation()
            }
        })
    },
    // Инициализация header'a секции с выбором времени записи
    _initTimeSectionHeader: function (dateText) {
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
        currentItem.children('.rbs-month_name').html(rbsWidget._monthNames[date.getMonth()])
        currentItem.children('.rbs-month_day').html(date.getDate())
        currentItem.children('.rbs-day_name').html(rbsWidget._dayNames[date.getDay()])
        currentItem.attr('data-date', date.getDate())
        currentItem.attr('data-month', date.getMonth() + 1)
        currentItem.attr('data-year', date.getFullYear())

        // Устанвливаем предыдущий день
        date.setDate(date.getDate() - 1)
        prevCurItem.children('.rbs-month_day').html(date.getDate())
        prevCurItem.children('.rbs-day_name').html(rbsWidget._dayNames[date.getDay()])
        prevCurItem.attr('data-date', date.getDate())
        prevCurItem.attr('data-month', date.getMonth() + 1)
        prevCurItem.attr('data-year', date.getFullYear())

        // Устанвливаем предпредыдущий день
        date.setDate(date.getDate() - 1)
        prevPrevItem.children('.rbs-month_day').html(date.getDate())
        prevPrevItem.children('.rbs-day_name').html(rbsWidget._dayNames[date.getDay()])
        prevPrevItem.attr('data-date', date.getDate())
        prevPrevItem.attr('data-month', date.getMonth() + 1)
        prevPrevItem.attr('data-year', date.getFullYear())

        // Устанвливаем следующий день
        date.setDate(date.getDate() + 3)
        nextCurItem.children('.rbs-month_day').html(date.getDate())
        nextCurItem.children('.rbs-day_name').html(rbsWidget._dayNames[date.getDay()])
        nextCurItem.attr('data-date', date.getDate())
        nextCurItem.attr('data-month', date.getMonth() + 1)
        nextCurItem.attr('data-year', date.getFullYear())

        // Устанвливаем следследующий день
        date.setDate(date.getDate() + 1)
        nextNextItem.children('.rbs-month_day').html(date.getDate())
        nextNextItem.children('.rbs-day_name').html(rbsWidget._dayNames[date.getDay()])
        nextNextItem.attr('data-date', date.getDate())
        nextNextItem.attr('data-month', date.getMonth() + 1)
        nextNextItem.attr('data-year', date.getFullYear())

        // Устанавливаем/снимаем ограничения на выбор даты
        date.setDate(date.getDate() - 2)
        // Получаем текущую, предыдущую и предпредыдущую дату
        let curDate = new Date()
        // Если текущая дата совпдает с выбранной, то больше назад двигаться нельзя
        if (curDate.getDate() == date.getDate() && curDate.getMonth() == date.getMonth() && curDate.getFullYear() == date.getFullYear()) {
            $('button.rbs-prev-day').addClass('ui-state-disabled')
            prevPrevItem.addClass('ui-state-disabled')
            prevCurItem.addClass('ui-state-disabled')
        } else if (curDate.getDate() == date.getDate() - 1 && curDate.getMonth() == date.getMonth() && curDate.getFullYear() == date.getFullYear()) {
            // Иначе если текущая дата является вчерашней для выбранной, то мы запрещаем выбор только предпредыдущей даты
            $('button.rbs-prev-day').removeClass('ui-state-disabled')
            prevPrevItem.addClass('ui-state-disabled')
            prevCurItem.removeClass('ui-state-disabled')
        } else {
            // Иначе никаких ограничений нет
            $('button.rbs-prev-day').removeClass('ui-state-disabled')
            prevPrevItem.removeClass('ui-state-disabled')
            prevCurItem.removeClass('ui-state-disabled')
        }
    },
    // Вывод актуальных вариантов времени для записи в выбранную дату
    _ajaxInitTimeSelection: function () {
        rbsWidget._startLoadingAnimation()

        $.ajax({
            url: 'https://rbs-demo.ivadey.ru/reservations/get_available_times',
            data: {
                date: rbsWidget._reservationInfo.reservation_date.date,
                location_id: rbsWidget._reservationInfo.location.id,
                service_id: rbsWidget._reservationInfo.service.id,
                master_id: rbsWidget._reservationInfo.master.id,
                access_token: 'widget-token'
            },
            dataType: 'json',
            success: function (data) {
                let timeSelectionBody = $('.rbs-time_selection_body')
                timeSelectionBody.html('')

                // Проверяем если нет ошибок и данные есть
                if (data.error_code) {
                    timeSelectionBody.append('<span>Произошла ошибка, перезагрузите страницу.</span>')
                    rbsWidget._stopLoadingAnimation()
                    return
                }

                // Если мастера уже выбрали, то выводим доступное время только для этого мастера
                // Если мастера не выбрали, то сформируем список всех возможных вариантов и выведем его
                if (rbsWidget._reservationInfo.master_id) {
                    // Проверим есть ли доступное время
                    if (data[rbsWidget._reservationInfo.master_id]) {
                        data[rbsWidget._reservationInfo.master_id].forEach(function (item, ind) {
                            let timeItem = '<label>' +
                                '<input type="radio" name="time" value="' + item + '">' +
                                '<div class="rbs-time_variant">' + item + '</div>' +
                                '</label>'
                            timeSelectionBody.append(timeItem)
                        })
                    } else {
                        timeSelectionBody.append('<span>На выбранную дату доступного времени для записи нет. Попробуйте выбрать другого мастера или день.</span>')
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
                        Object.keys(timeVariants).sort().forEach(function (key) {
                            let timeItem = '<label>' +
                                '<input type="radio" name="time" value="' + key + '">' +
                                '<div class="rbs-time_variant">' + key + '</div>' +
                                '</label>'
                            timeSelectionBody.append(timeItem)
                        })
                    }
                }

                $('#rbs-time_selection .rbs-time_selection_body input').click(rbsWidget._timeSelected)
                rbsWidget._stopLoadingAnimation()
            }
        })
    },

    // Добавление записи
    _ajaxAddReservation: function () {
        // Валидируем данные
        // Если вернется false, то есть не все валидно, то ничего не отправляем
        if (!this._validateClientInfo()) {
            return
        }
        $('#rbs-error_message').hide()

        rbsWidget._startLoadingAnimation()

        $.ajax({
            url: 'https://rbs-demo.ivadey.ru/reservations/add_reservation',
            data: {
                location_id: rbsWidget._reservationInfo.location.id,
                reservation_date: rbsWidget._reservationInfo.reservation_date,
                services: [
                    {
                        service_id: rbsWidget._reservationInfo.service.id,
                        master_id: rbsWidget._reservationInfo.master.id
                    }
                ],
                client: rbsWidget._reservationInfo.client,
                access_token: 'widget-token'
            },
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                $('#rbs-client_info').hide()
                $('#rbs-reservation_status').show()
                $('#rbs-reservation_status').addClass('rbs-active_section')
                // Проверяем код ошибкии
                // Если 0, то все норм и выводим сообщение об успешной записи с детальной информацией
                // Иначе, если кто-то опередил пользователя, то выводим сообщение об ошибке
                $('#rbs-reservation_status h4').html('Вы успешно записаны!')
                let resultMessage = '<span class="name">Дата: </span><span class="body">' + rbsWidget._reservationInfo.reservation_date.date + '</span>' +
                    '<span class="name">Время: </span><span class="body">' + rbsWidget._reservationInfo.reservation_date.time + '</span>' +
                    '<span class="name">Адрес: </span><span class="body">' + rbsWidget._reservationInfo.location.address + '</span>' +
                    '<span class="name">Услуга: </span><span class="body">' + rbsWidget._reservationInfo.service.name + '</span>' +
                    '<span class="name">Мастер: </span><span class="body">' + rbsWidget._reservationInfo.master.name + '</span>' +
                    '<span class="name">Стоимость: </span><span class="body">' + rbsWidget._reservationInfo.service.cost + '</span>'
                $('#rbs-reservation_status .rbs-reservation_status_body').html(resultMessage)

                rbsWidget._stopLoadingAnimation()
            }
        })
    },

    // ------------------------------------------------------------
    
    // Установка основных обработчиков
    _setEventsHandler: function () {
        // Перемещение назад (в предыдущую секцию
        $('#rbs-header_top button').click(this._backToPrevSection)
        // Открытие секции с выбором услуги
        $('#rbs-general_service').click(this._openServiceSelection)
        // Открытие секции с выбором мастера
        $('#rbs-general_master').click(this._openMasterSelection)
        // Открытие секции с выбором даты записи
        $('#rbs-general_time').click(this._openDateSelection)
        // Открытие финальной секции с вводом данных клиента и записью
        $('#rbs-general button').click(function () {
            if (rbsWidget._reservationInfo.isDataValid())
                rbsWidget._openClientInfoSection()
            else {
                if (!rbsWidget._reservationInfo.service.id)
                    $('#rbs-general_service').addClass('rbs-data_error')
                if (!rbsWidget._reservationInfo.master.id)
                    $('#rbs-general_master').addClass('rbs-data_error')
                if (!(rbsWidget._reservationInfo.reservation_date.date && rbsWidget._reservationInfo.reservation_date.time))
                    $('#rbs-general_time').addClass('rbs-data_error')
            }
        })

        // Выбор услуги
        $('.rbs-service_item h5').click(this._serviceSelected)
        // Выбор мастера
        $('.rbs-master_item').click(this._masterSelected)

        // Работа с шапкой секции выбора времени записи (навигация по датам)
        $('.rbs-day_item').click(this._timeSectionChangeDate)
        $('#rbs-time_selection button.rbs-prev-day').click(this._timeSectionPrevDay)
        $('#rbs-time_selection button.rbs-next-day').click(this._timeSectionNextDay)

        // Обработка слайдеров
        // Слайдер категории услуг
        this._activateSliders()
        // Слайдер деталей записи в финальной секции с данными клиента
        $('.rbs-reservation_details h4').click(function (e) {
            $(this).toggleClass('opened')
            $(this).next().slideToggle()
        })

        // Убираем красную рамку ошибки данных при редактировании input
        $('#rbs-client_info input').keypress(function () {
            $(this).removeClass('rbs-data_error')
        })
        // Устанавливаем маску на поле ввода номера телефона
        this._setPhoneMask($('#rbs-client_info input[name="phone"]'))

        // Запись клиента
        $('#rbs-sign_up').click(this._signUpReservation)

        // Закрытие виджета
        $('#rbs-close_widget').click(this._closeWidget)

        // Обработчики меню и личного кабинета пользователя
        // Открытие/закрытие меню пользователя
        $('#rbs-open_menu').click(this._openMenu)
        // Открытие личного кабинета
        $('#rbs-open_lk').click(this._openUserLkSection)
    },

    // ------------------------------------------------------------

    init: function () {
        // Подключаем необходимые файлы и библиотеки
        this._includeFiles()

        // Создаем обертку виджета
        this._createWidgetWrap()

        // Инициализируем виджет календаря
        $('#rbs-date_calendar').datepicker({
            altField: '.calendar input[name="date"]',
            dateFormat: 'dd.mm.yy',
            firstDay: 1,
            minDate: 0,
            dayNamesMin: rbsWidget._dayNames,
            monthNames: rbsWidget._monthNames,
            showOtherMonths: true,
            selectOtherMonths: true,
            onSelect: function(dateText, inst) {
                rbsWidget._dateSelected(dateText)
            }
        })

        // Инициализируем виджет данными
        this._ajaxInitLocations()
        this._ajaxInitServices()
        // this._ajaxInitMasters()

        // Устанавливаем обработчики событий
        this._setEventsHandler()

        // Устанавливаем обработчик открытия виджета на внешний элемент в нужным ID
        $('#rbs-open_widget').click(this._openWidget)
    }
})

$(document).ready(function () {
    rbsWidget.init()
    // $('#rbs-error_message').html('Error message')
})

function setCookie(name, value, options = {}) {

    options = {
        path: '/',
        'max-age': 3600 * 24 * 3,
        // secure: true
        ...options
    };

    // if (options.expires.toUTCString) {
    //     options.expires = options.expires.toUTCString();
    // }

    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

    for (let optionKey in options) {
        updatedCookie += "; " + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += "=" + optionValue;
        }
    }

    document.cookie = updatedCookie;
}
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}













