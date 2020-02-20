// Запуск и остановка анимации загрузки
let startLoadingAnimation = function () {
    $('#ajax-load').show()
}
let stopLoadingAnimation = function () {
    $('#ajax-load').hide()
}

let rd = false
$(document).ready(function () {
    $('#edit-location-info').click(function () {
        if (rd) {
            $('.c2').attr('readonly', 'true')
            $('.c2').addClass('readonly')
            $('.form-row').addClass('readonly')
            $('.working-hours').addClass('readonly')
            $('.days-working-hours').addClass('readonly')
            $('.employees-list').addClass('readonly')

            $('.days-working-hours ul li.add-day').remove()

            rd = false
        } else {
            $('.c2').removeAttr('readonly')
            $('.c2').removeClass('readonly')
            $('.form-row').removeClass('readonly')
            $('.working-hours').removeClass('readonly')
            $('.days-working-hours').removeClass('readonly')
            $('.employees-list').removeClass('readonly')

            $('.days-working-hours ul').append('<li class="add-day">Добавить</li>')
            $('.days-working-hours ul li.add-day').click(function () {
                alert('hi')
            })

            // Перемещаем фокус на первое поле ввода
            $('.c2')[0].focus()

            rd = true
        }


        // $('#edit_company_info').hide()
        // $('#update_company_info').show()
        // $('#cancel').show()
    })

    $('.form-row textarea').keyup(function () {
        console.log(this.scrollHeight)
        if (this.scrollHeight != this.clientHeight)
            this.style.height = this.scrollHeight + 'px';
    })

    $('#days-list li').click(function () {
        if (!$(this).hasClass('disabled'))
            $(this).toggleClass('selected')
    })





    // Дикий костыль из-за chrome
    // Чтобы он не лез со своими подсказками адреса и пришлось обернуть
    // весь блок в тег form и установить у него autocomplete="off", так как
    // на аналогичный тег у элемента он не реагирует
    // Соответственно теперь любая кнопка вызывает отправку форму, а нам это нахер не сдалось
    $('form button').click(function () {
        return false
    })
})