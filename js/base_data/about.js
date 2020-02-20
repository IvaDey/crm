// Запуск и остановка анимации загрузки
let startLoadingAnimation = function () {
    $('#ajax-load').show()
}
let stopLoadingAnimation = function () {
    $('#ajax-load').hide()
}

let updateCompanyInfo = function() {
    let name = $('#company_info form input[name="name"]').val()
    let description = $('#company_info form textarea[name="description"]').val()
    let address = $('#company_info form textarea[name="address"]').val()
    let phone = $('#company_info form input[name="phone"]').val()
    let email = $('#company_info form input[name="email"]').val()

    $.ajax({
        url: 'https://rbs-demo.ivadey.ru/settings/update_company_info',
        data: {
            name: name,
            description: description,
            address: address,
            phone: phone,
            email: email
        },
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.error_code) {
                alert('Произошла ошибка')
            } else {
                $('#company_info button').addClass('ui-helper-hidden')
                alert('Данные успешно обновлены')
            }
        }
    })

    return false
}

$(document).ready(function () {
    $('#edit_company_info').click(function () {
        $('.c2').removeAttr('readonly')
        $('.c2').removeClass('readonly')
        $('.form-row').removeClass('readonly')

        $('#edit_company_info').hide()
        $('#update_company_info').show()
        $('#cancel').show()

        return false
    })
    $('#update_company_info').click(function () {
        $('.c2').attr('readonly', true)
        $('.c2').addClass('readonly')
        $('.form-row').addClass('readonly')

        $('#edit_company_info').show()
        $('#update_company_info').hide()
        $('#cancel').hide()

        return false
    })
    $('#cancel').click(function () {
        $('.c2').attr('readonly', true)
        $('.c2').addClass('readonly')
        $('.form-row').addClass('readonly')

        $('#edit_company_info').show()
        $('#update_company_info').hide()
        $('#cancel').hide()

        return false
    })
})