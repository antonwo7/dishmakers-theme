jQuery(document).ready(function ($) {

    $('.products-slider').owlCarousel({
        loop: true,
        dots: true,
        items: 1,
        mouseDrag: true,
        touchDrag: true,
        margin: 20,
        nav: true,
        navText: '',
        responsive: {
            576: {
                dots: true,
                margin: 20,
                items: 1,
                nav: true
            },
            600: {
                dots: true,
                margin: 20,
                items: 2,
                nav: true
            },
            992: {
                dots: true,
                margin: 20,
                items: 3,
                nav: true
            },
        }
    });
});
