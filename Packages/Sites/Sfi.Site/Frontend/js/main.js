$(document).ready(function() {
    $(".carousel-inner").swipe({
        swipeLeft: function(event, direction, distance, duration) {
            $(this).parent().carousel('next');
        },
        swipeRight: function(event, direction, distance, duration) {
            $(this).parent().carousel('prev');
        },
        threshold: 50,
        preventDefaultEvents: false,
        allowPageScroll: "none"
    });
});
