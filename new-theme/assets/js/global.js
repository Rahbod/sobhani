$(document).ready(function () {
    $(".scrollDown").on('click', function () {
        var header_height = $('.header').height();
        $('html, body').animate({
            scrollTop: $(".header").offset().top + header_height
        }, 1500);
    });
});
