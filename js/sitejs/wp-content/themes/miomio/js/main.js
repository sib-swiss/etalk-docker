jQuery(document).ready(function($) {

/*menu scroll*/
$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 75) {
        $(".header").addClass("menu-scroll");
    } else {
        $(".header").removeClass("menu-scroll");
    }
});

/*image widget padding*/
$('.image-widget').parents('.side-item').css('padding', '0px');

});