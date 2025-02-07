$(document).ready(function () {

    'use strict';

    //  Off canvas Menu
    $('.has-menu').on('click', function () {
        $('.droup-menu').toggleClass('off-show');
    });
    // Nice Select
    $('.nice-control').niceSelect();
    //
    $('.user-slider').owlCarousel({
        loop: false,
        autoplay: false,
        margin: 10,
        nav: true,
        navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>'],
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });


    $('.cook_slider').owlCarousel({
        loop: false,
        autoplay: false,
        margin: 10,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 2
            }
        }
    });


    // Pricing Range
    $("#slider-range").slider({
        range: true,
        orientation: "horizontal",
        min: 0,
        max: 10000,
        values: [0, 10000],
        step: 100,

        slide: function (event, ui) {
            if (ui.values[0] == ui.values[1]) {
                return false;
            }

            $("#min_price").val(ui.values[0]);
            $("#max_price").val(ui.values[1]);
        }
    });


    $('.gSearch-icon').on('click', function () {
        $('.gSearch-show').toggleClass('active');
    });


});



$(document).ready(function () {
    'use strict';

    var $niceSelect1 = $('.language-dropdown select'),
        $player_1 = $('#player'),
        $player_2 = $('#player2'),
        $counter1 = $('.counter1'),
        $counter2 = $('.counter2'),
        $password = $('.toggle-password'),
        $scale_slider = $('.scale-slider'),
        $counter = $('.counter');

    // Nice Select 
    if ($niceSelect1.length > 0) {
        $($niceSelect1).niceSelect();
    }

    // Player js 
    if ($player_1.length > 0) {
        const player = new Plyr($player_1);
    }
    if ($player_2.length > 0) {
        const player = new Plyr($player_2);
    }

    // Counter Up jquery
    if ($counter1.length > 0) {
        $($counter1).counterUp({
            delay: 10,
            time: 1000,
        });
    }
    // KG Counter 
    if ($counter2.length > 0) {
        $($counter2).counterUp({
            delay: 10,
            time: 1200,
        });
    }

    // Testimonials
    if (typeof $('.your-slider').slick === 'function') {
        $(".slide-show").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            asNavFor: '.slider-nav',
            autoplay: false,
            loop: true,
            fade: false,
            margin: 20,
        });
    }
    if (typeof $('.slider-nav').slick === 'function') {
        $(".slider-nav").slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: '.slide-show',
            dots: false,
            arrows: false,
            variableWidth: true,
            autoplay: false,
            loop: true,
            infinite: true,
            centerMode: true,
            centerPadding: '0',
            focusOnSelect: true,
            autoplaySpeed: 3000, speed: 700,
        });
    }


    // University scale slider plugin
    if ($scale_slider.length > 0) {
        var scaleswiper = new Swiper(".scale-slider", {
            effect: "coverflow",
            // grabCursor: true,
            centeredSlides: true,
            slidesPerView: "1.5",
            loop: true,
            // speed: 2000,
            coverflowEffect: {
                rotate: 0,
                stretch: 100,
                depth: 135,
                modifier: 4,
                slideShadows: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            autoplay: {
                delay: 3000000,
                pauseOnMouseEnter: true,
                disableOnInteraction: false,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: "1.5",
                    coverflowEffect: {
                        stretch: 21,
                        depth: 200,
                        modifier: 4,
                    },
                },
                768: {
                    slidesPerView: "1.5",
                    coverflowEffect: {
                        stretch: 29,
                        depth: 200,
                        modifier: 4,
                    },
                },
                992: {
                    slidesPerView: "1.5",
                    coverflowEffect: {
                        stretch: 39,
                        depth: 200,
                        modifier: 4,
                    },
                },
                1200: {
                    slidesPerView: "1.5",
                    coverflowEffect: {
                        stretch: 100,
                        depth: 135,
                        modifier: 4,
                    },
                },
                1400: {
                    slidesPerView: "1.5",
                    coverflowEffect: {
                        stretch: 100,
                        depth: 165,
                        modifier: 4,
                    },
                },
            },
        });
    }
});


// Accordion Menu 
if (screen.width < 992) {
    function accordion() {
        var Accordion = function (el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;
            var links = this.el.find('.menu-item-has-children > a');
            links.on('click', { el: this.el, multiple: this.multiple }, this.dropdown)
        }

        Accordion.prototype.dropdown = function (e) {
            var $el = e.data.el,
                $this = $(this),
                $next = $this.next();

            $next.slideToggle();
            $this.parent().toggleClass('active-submenu');

            if (!e.data.multiple) {
                $el.find('.menu-dropdown').not($next).slideUp().parent().removeClass('active-submenu');
                $el.find('.menu-dropdown').not($next).slideUp();
            };
        }
        var accordion = new Accordion($('.accordion-menu'), false);
    }
    accordion();
}
// Accordion Menu


// Elegant Page Testimonial 
if (typeof Swiper !== 'undefined') {
    var swiper1 = new Swiper('.elegant-testimonial-1', {
        slidesPerView: 1,
        centeredSlides: true,
        loop: true,
        spaceBetween: 21,
        keyboard: true,
        breakpoints: {
            451: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 1.5,
            },
            768: {
                slidesPerView: 2.5,
            },
            991: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            },
        },
    });

    if ($('.meditation-testimonial-1').length > 0) {
        var swiper1 = new Swiper('.meditation-testimonial-1', {
            slidesPerView: 1,
            centeredSlides: true,
            loop: true,
            spaceBetween: 21,
            keyboard: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
            breakpoints: {
                451: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1.5,
                },
                768: {
                    slidesPerView: 2.5,
                },
                991: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                },
            },
        });
    }



    var swiper2 = new Swiper('.elegant-testimonial-2', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 21,
        centeredSlides: true,
        centeredSlidesBounds: true,
        keyboard: true,
        breakpoints: {
            451: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 1.5,
            },
            768: {
                slidesPerView: 2.7,
            },
            991: {
                slidesPerView: 3.2,
            },
            1200: {
                slidesPerView: 3.6,
            },
        },
    });


    var swiper3 = new Swiper(".floor-plans-slider", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        keyboard: true,
        slidesPerView: 2,
        spaceBetween: 28,
        loop: true,
        breakpoints: {
            451: {
                slidesPerView: 3,
            },
            576: {
                slidesPerView: 4,
            },
            768: {
                slidesPerView: 5,
            },
            991: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 5,
            },
        },
    });


    var swiper4 = new Swiper(".dev-student-swiper", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        keyboard: true,
        slidesPerView: 1,
        spaceBetween: 20,
        breakpoints: {
            768: {
                slidesPerView: 1,
            },
            991: {
                slidesPerView: 2,
            },
        },
    });




    // Elegant Page Testimonial 
    var swiper5 = new Swiper('.lms-testimonial-1', {
        slidesPerView: 1,
        loop: false,
        spaceBetween: 28,
        keyboard: true,
        navigation: {
            prevEl: ".swiper-button-prev",
            nextEl: ".swiper-button-next",
        },
        breakpoints: {
            451: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
        },
    });

    // Marketplace Banner 
    var swiper6 = new Swiper(".banner-swiper-1", {
        loop: true,
        keyboard: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    // Marketplace Page Testimonial 
    var swiper5 = new Swiper('.lms-testimonial-2', {
        slidesPerView: 1,
        loop: true,
        spaceBetween: 28,
        keyboard: true,
        autoplay: true,
        breakpoints: {
            451: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
        },
    });
}
