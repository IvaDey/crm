$(document).ready(function () {
    // Делаем динамический placeholder
    $('input').focusin(function () {
        $(this).next().next('.placeholder').addClass('top')
    })
    $('input').focusout(function () {
        if ($(this).val() == '')
            $(this).next().next('.placeholder').removeClass('top')
    })
    // $('input').keyup(function () {
    //     if ($(this).val() == '')
    //         $(this).next().next('.placeholder').removeClass('top')
    //     else $(this).next().next('.placeholder').addClass('top')
    // })
})
























