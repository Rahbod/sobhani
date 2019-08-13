$(function () {
    $.ajaxSetup({
        data: {
            'YII_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(window).scroll(startCounter);
    function startCounter() {
        if($('.counter--container').length) {
            var hT = $('.counter--container').offset().top,
                hH = $('.counter--container').outerHeight(),
                wH = $(window).height();
            if ($(window).scrollTop() > hT + hH - wH) {
                $(window).off("scroll", startCounter);
                $('.counter').each(function () {
                    var $this = $(this);
                    $({Counter: 0}).animate({Counter: $this.text()}, {
                        duration: 2000,
                        easing: 'swing',
                        step: function () {
                            $this.text(Math.ceil(this.Counter));
                        }
                    });
                });
            }
        }
    }

    if($('.owl-carousel').length) {
        $('.owl-carousel').owlCarousel({
            rtl: true,
            nav: true,
            center: true,
            items: 2,
            loop: true,
            margin: 26,
            dots: false,
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1
                },
                // breakpoint from 768 up
                768: {
                    items: 2
                }
            }
        });
    }

    //        $("#sidebar").mCustomScrollbar({
    //            theme: "minimal"
    //        });
    $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
});