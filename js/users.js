let apiUrl = 'https://rbs-demo.ivadey.ru/'

// Запуск и остановка анимации загрузки
let startLoadingAnimation = function () {
    $('#ajax-load').show()
}
let stopLoadingAnimation = function () {
    $('#ajax-load').hide()
}

// Переключение страницы с пользователями
let changeUsersPage = function (page) {
    startLoadingAnimation()

    $.ajax({
        url: apiUrl + 'users/getUsers',
        data: {
            offset: page
        },
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#body-users tbody').html('')
            data.usersList.list.forEach(function (item, ind) {
                clientRow = "<tr>" +
                    "<td>" + item.id + "</td>" +
                    "<td>" + item.registration_date + "</td>" +
                    "<td>" + item.name + "</td>" +
                    "<td>" + item.surname + "</td>" +
                    "<td>" + item.phone + "</td>" +
                    "<td>" + item.email + "</td>" +
                    "<td><button></button></td>" +
                    "</tr>"

                $('#body-users tbody').append(clientRow)
            })

            stopLoadingAnimation()
        }
    })
}
// Переключение страницы с клиентами
let changeClientsPage = function (page) {
    startLoadingAnimation()

    $.ajax({
        url: apiUrl + 'users/getClients',
        data: {
            offset: page
        },
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#body-clients tbody').html('')
            data.clientsList.list.forEach(function (item, ind) {
                clientRow = "<tr>" +
                    "<td>" + item.id + "</td>" +
                    "<td>" + item.name + "</td>" +
                    "<td>" + item.phone + "</td>" +
                    "<td>" + item.email + "</td>" +
                    "<td>" + item.reservation_date + "</td>" +
                    "<td>" + item.service_name + "</td>" +
                    "<td>" + item.total_cost + "</td>" +
                    "</tr>"

                $('#body-clients tbody').append(clientRow)
            })

            stopLoadingAnimation()
        }
    })
}

$(document).ready(function () {
    // Обработка переключения вкладок
    $('#tab-users').click(function () {
        $('#tab-users').addClass('selected')
        $('#tab-clients').removeClass('selected')

        $('#body-users').addClass('selected')
        $('#body-clients').removeClass('selected')
    })
    $('#tab-clients').click(function () {
        $('#tab-users').removeClass('selected')
        $('#tab-clients').addClass('selected')

        $('#body-users').removeClass('selected')
        $('#body-clients').addClass('selected')
    })

    // Переключение страниц на вкладке с пользователями
    $('#body-users .paginator .prev_page').click(function () {
        let prev = $('#body-users .paginator .selected').prev('.page_number')

        if (prev.length) {
            changeUsersPage(prev.html())
            $('#body-users .paginator .page_number').removeClass('selected')
            prev.addClass('selected')
        }
    })
    $('#body-users .paginator .page_number').click(function () {
        changeUsersPage($(this).html())
        $('#body-users .paginator .page_number').removeClass('selected')
        $(this).addClass('selected')
    })
    $('#body-users .paginator .next_page').click(function () {
        let next = $('#body-users .paginator .selected').next('.page_number')

        if (next.length) {
            changeUsersPage(next.html())
            $('#body-users .paginator .page_number').removeClass('selected')
            next.addClass('selected')
        }
    })

    // Переключение страниц на вкладке с клиентами
    $('#body-clients .paginator .prev_page').click(function () {
        let prev = $('#body-clients .paginator .selected').prev('.page_number')

        if (prev.length) {
            changeClientsPage(prev.html())
            $('#body-clients .paginator .page_number').removeClass('selected')
            prev.addClass('selected')
        }
    })
    $('#body-clients .paginator .page_number').click(function () {
        changeClientsPage($(this).html())
        $('#body-clients .paginator .page_number').removeClass('selected')
        $(this).addClass('selected')
    })
    $('#body-clients .paginator .next_page').click(function () {
        let next = $('#body-clients .paginator .selected').next('.page_number')

        if (next.length) {
            changeClientsPage(next.html())
            $('#body-clients .paginator .page_number').removeClass('selected')
            next.addClass('selected')
        }
    })
})






















