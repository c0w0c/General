//滾動HEADER加陰影語法-

$(window).load(function() {
    var header = $('.hea');

    $(window).scroll(function(e) {
        if (header.offset().top > 5) {
            if (!header.hasClass('shadow')) {
                header.addClass('shadow');
            }
        } else {
            header.removeClass('shadow');
        }
    });
});
