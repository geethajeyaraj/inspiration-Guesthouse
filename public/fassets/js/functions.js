/*global $, window, document, setTimeout, WOW, jQuery*/
$(document).ready(function() {

    'use strict';

    // Smooth scrolling using jQuery easing
    $('a.scroll[href*="#"]:not([href="#"])').on('click', function() {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: (target.offset().top - 48)
                }, 1000, "easeInOutExpo");
                return false;
            }
        }
    });



    $.stellar({
        horizontalScrolling: false,
        verticalOffset: 40
    });



    $('.ajax-popup').magnificPopup({
        type: 'ajax',
        midClick: true,
        modal: true
    });



    $(document).on('click', '.ajax-close', function(e) {
        e.preventDefault();
        $.magnificPopup.close();
    });


    $('#primary-menu').bootnavbar();


    /*
        //Screenshoot slider
        $(".owl-carousel").owlCarousel({
            responsive: {
                0: {
                    items: 2
                },
                991: {
                    items: 5
                }
            },
            loop: true,
            center: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true

        });
    */


    var skill = $('.skill'),
        accordionBox = $('.accordion-box'),
        accordion = $('.accordion'),
        accordionContent = $('.acc-content');

    //Accordion Box
    if (accordionBox.length) {
        $(this).on('click', '.acc-btn', function() {

            var outerBox = $(this).parents(accordionBox);
            var target = $(this).parents(accordion);

            if ($(this).hasClass('active') !== true) {
                $('.accordion .acc-btn').removeClass('active');
            }

            if ($(this).next(accordionContent).is(':visible')) {
                return false;
            } else {
                $(this).addClass('active');
                $(outerBox).children(accordion).removeClass('active-block');
                $(outerBox).find(accordion).children('.acc-content').slideUp(300);
                target.addClass('active-block');
                $(this).next(accordionContent).slideDown(300);
            }
        });
    }






});

//preloader
$(window).on('load', function() {
    $("body").css("overflow", "auto");
    $(".preloader").fadeOut(1000, function() {
        $(this).remove();
    });
});