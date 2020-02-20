// Запуск и остановка анимации загрузки
let startLoadingAnimation = function () {
    $('#ajax-load').show()
}
let stopLoadingAnimation = function () {
    $('#ajax-load').hide()
}

let setGcalendarModal = function () {
    $('#gcalendar-settings-modal').dialog({
        modal:true,
        width: 620,
        autoOpen: false,
        resizable:false,
        closeOnEscape: true,
        buttons:{
            "Добавить": function(){
                if (!($('#gcalendar-integration p').html() == 'Not integrated')) {
                    alert('Интеграция уже настроена')
                    $(this).dialog( "close" );
                    return
                }

                $.ajax({
                    url: 'https://rbs-demo.ivadey.ru/settings/set_gcalendar_integration',
                    data: {
                        auth_code: $('#gcalendar-settings-modal textarea').val()
                    },
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        if (data.error_code) {
                            alert('Произошла ошибка! Перепроверьте код!')
                        } else {
                            $('#gcalendar-integration p').html('Current account: ' + data.gcalendar_owner)
                            $('#gcalendar-settings-modal').html('Интеграция уже произведена')
                            $('#gcalendar-settings-modal').dialog('close')
                        }
                    }
                })
            },
            'Отменить': function(){
                $(this).dialog( "close" );
            }
        }
    })
}
let openGcalendarSettings = function () {
    $('#gcalendar-settings-modal').dialog('open')
}

$(document).ready(function () {
    setGcalendarModal()
    $('#gcalander-open-settings').click(openGcalendarSettings)
})