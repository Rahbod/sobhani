$(document).ready(function () {
    $.ajaxSetup({
        data: {
            'YII_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".scrollDown").on('click', function () {
        var header_height = $('.header').height();
        $('html, body').animate({
            scrollTop: $(".header").offset().top + header_height
        }, 1500);
    });
});
