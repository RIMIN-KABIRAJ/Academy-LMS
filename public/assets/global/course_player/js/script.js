(function ($) {
    "use strict";
    var scrollTop;
    var Medi = {
        init: function () {
            this.Basic.init();
        },

        Basic: {
            init: function () {
                this.scrollTop();
                this.BackgroundImage();
                this.Slider();
            },
            scrollTop: function () {
                $(window).on("scroll", function () {
                    var ScrollBarPosition = $(this).scrollTop();
                    if (ScrollBarPosition > 200) {
                        $(".scroll-top").fadeIn();
                    } else {
                        $(".scroll-top").fadeOut();
                    }
                });
                $(".scroll-top").on("click", function () {
                    $("body,html").animate({
                        scrollTop: 0,
                    });
                });
            },
            BackgroundImage: function () {
                $("[data-background]").each(function () {
                    $(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
                });
            },
            Slider: function () {
                
            },
        },
    };
    jQuery(document).ready(function () {
        Medi.init();
    });
})(jQuery);


