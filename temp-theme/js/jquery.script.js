$(document).ready(function() {
    $("body").on("click", ".mobile-search-trigger", function(){
        $(".mobile-search").show();
    }).on("click", ".close-search-container", function(){
        $(".mobile-search").hide();
    });

    $('.is-carousel').each(function () {
        var items = $(this).data('items'),
            dots = ($(this).data('dots') == 1) ? true : false,
            nav = ($(this).data('nav') == 1) ? true : false,
            margin = $(this).data('margin'),
            responsive = $(this).data('responsive'),
            loop=($(this).data('loop') == 1) ? true : false,
            autoPlay=($(this).data('autoplay') == 1) ? true : false,
            autoPlayHoverPause=($(this).data('autoplay-hover-pause') == 1) ? true : false,
            mouseDrag=($(this).data('mouse-drag') == 1) ? true : false;

        if ($(this).hasClass('auto-width')) {
            var carousel=$(this);
            $(this).on('refresh.owl.carousel', function(){
                setCarouselItemsWidth(carousel, items, margin);
            });

            $(this).owlCarousel({
                autoWidth: true,
                dots: dots,
                nav: nav,
                navText: ["<i class='arrow-icon'></i>", "<i class='arrow-icon'></i>"],
                rtl: true
            });
        } else if ($(this).hasClass('vertical')) {
            $(this).owlCarousel({
                loop: loop,
                autoplay: autoPlay,
                items: items,
                dots:dots,
                nav: nav,
                autoplayHoverPause: autoPlayHoverPause,
                mouseDrag: mouseDrag,
                animateOut: 'slideOutUp',
                animateIn: 'slideInUp',
                rtl: true
            });
        } else {
            $(this).owlCarousel({
                loop: loop,
                autoplay: autoPlay,
                items: items,
                dots:dots,
                nav: nav,
                autoplayHoverPause: autoPlayHoverPause,
                mouseDrag: mouseDrag,
                navText: ["<i class='arrow-icon'></i>", "<i class='arrow-icon'></i>"],
                responsive: responsive,
                rtl: true
            });
        }
    });
});

function setCarouselItemsWidth(carousel, items, margin) {
    var objKeys = Object.keys(items),
        itemsCount,
        itemsMargin,
        sumMargin,
        width;

    // Get count of items
    objKeys.reverse();
    for (var i = 0; i < objKeys.length; i++) {
        if ($(window).width() >= objKeys[i]) {
            itemsCount = items[objKeys[i]];
            break;
        }
    }

    // Get margin
    objKeys=Object.keys(margin);
    objKeys.reverse();
    for (i = 0; i < objKeys.length; i++) {
        if ($(window).width() >= objKeys[i]) {
            itemsMargin = margin[objKeys[i]];
            break;
        }
    }

    sumMargin = (itemsCount - 1) * itemsMargin;
    width = (carousel.width() - sumMargin) / itemsCount;

    carousel.find('.thumbnail-container').width(width).css('margin-left', parseInt(itemsMargin));
}