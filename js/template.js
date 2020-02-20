$(document).ready(function () {
    $('#main-menu .parent-menu-item .main-menu-nav-label').click(function () {
        $(this).next().slideToggle()
        $(this).parent().toggleClass('opened')
    })

    $('#hide-main-menu').click(function () {
        $('#main-menu').toggleClass('hidden-main-menu')
        $('#additional-menu').toggleClass('hidden-main-menu')
        $('#content').toggleClass('hidden-main-menu')
    })

    // $('#main-menu').toggleClass('hidden-main-menu')
    // $('#additional-menu').toggleClass('hidden-main-menu')
    // $('#content').toggleClass('hidden-main-menu')
})
























