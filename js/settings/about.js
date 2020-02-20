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
    $('#company_info form').change(function () {
        $('#company_info button').removeClass('ui-helper-hidden')
    })
    $('#update_company_info').click(updateCompanyInfo)
})