$(document).ready(function () {
    'use strict';

    var $niceSelect1 = $('.ol-small-niceSelect'),
        $select2 = $('.ol-select2');


    // Nice Select 
    if ($niceSelect1.length > 0) {
        $($niceSelect1).niceSelect();
    }


    // Select 2
    if ($select2.length > 0) {
        var $select = $(".ol-select2").select2({});
        $($select).each(function () {
            $(this).data('select2').$dropdown.addClass('select-drop');
        });
    }



    // Main Menu Language Select 
    $('.img-text-select .drop-content .drop-ul li').on('click', function (e) {
        e.preventDefault();
        var value = $(this).find('.select-text').text();
        var icon = $(this).find('.select-image').html();
        $('.selected-text').val(value);
        var item = icon + " " + value
        $('.selected-show').empty().append(item);
    });
    // Language Select class add remove
    const langToggle = $(".selected-show");
    const langmenu = $(".drop-content");
    langToggle.on("click", function (event) {
        event.stopPropagation();
        langmenu.toggleClass("active");
        langToggle.toggleClass("active");
        // Notification
        notiWrap.removeClass("active");
        notiToggle.removeClass("active");
        // Profile 
        profileMenu.removeClass("active");
        profileToggle.removeClass("active");
        // Search 
        searchWrap.removeClass("active");
        searchToggle.removeClass("active");
    });
    $(document).on("click", function (event) {
        const target = $(event.target);
        if (!langToggle.is(target) && !langmenu.is(target)) {
            langmenu.removeClass("active");
            langToggle.removeClass("active");
        }
    });


    // Profile Dropdown Toggle 
    const profileContainer = $(".header-dropdown-md");
    const profileToggle = $(".header-dropdown-toggle-md");
    const profileMenu = $(".header-dropdown-menu-md");
    if (profileToggle.length) {
        profileToggle.on("click", function (event) {
            event.stopPropagation();
            profileMenu.toggleClass("active");
            profileToggle.toggleClass("active");
            // Notification
            notiWrap.removeClass("active");
            notiToggle.removeClass("active");
            // Language 
            langmenu.removeClass("active");
            langToggle.removeClass("active");
            // Search 
            searchWrap.removeClass("active");
            searchToggle.removeClass("active");
        });
    }
    $(document).on("click", function (event) {
        const target = $(event.target);
        if (profileContainer.length && !profileContainer.is(target) && !profileContainer.has(target).length) {
            profileMenu.removeClass("active");
            if (profileToggle.length) {
                profileToggle.removeClass("active");
            }
        }
    });


    // Sidebar Toggle 
    const sideToggle = $(".menu-toggler");
    const sideMenu = $(".ol-sidebar");
    if (sideToggle.length) {
        sideToggle.on("click", function (event) {
            event.stopPropagation();
            sideMenu.toggleClass("hide");
            sideToggle.toggleClass("active");
        });
    }


    // Mobile Search Toggle 
    const searchContainer = $(".header-mobile-search");
    const searchToggle = $(".mobile-search-label");
    const searchWrap = $(".mobile-search");
    if (searchToggle.length) {
        searchToggle.on("click", function (event) {
            event.stopPropagation();
            searchWrap.toggleClass("active");
            searchToggle.toggleClass("active");
            // Notification
            notiWrap.removeClass("active");
            notiToggle.removeClass("active");
            // Language 
            langmenu.removeClass("active");
            langToggle.removeClass("active");
            // Profile 
            profileMenu.removeClass("active");
            profileToggle.removeClass("active");
            // focus 
            setTimeout(function () {
                $('.mobile-search-inner .form-control').focus();
            }, 100);
        });
    }
    $(document).on("click", function (event) {
        const target = $(event.target);
        if (searchContainer.length && !searchContainer.is(target) && !searchContainer.has(target).length) {
            searchWrap.removeClass("active");
            if (searchToggle.length) {
                searchToggle.removeClass("active");
            }
        }
    });


    // Notification Toggle 
    const notiContainer = $(".header-dropdown-lg");
    const notiToggle = $(".header-dropdown-toggle-lg");
    const notiWrap = $(".header-dropdown-menu-lg");
    if (notiToggle.length) {
        notiToggle.on("click", function (event) {
            event.stopPropagation();
            notiWrap.toggleClass("active");
            notiToggle.toggleClass("active");
            // Search 
            searchWrap.removeClass("active");
            searchToggle.removeClass("active");
            // Language 
            langmenu.removeClass("active");
            langToggle.removeClass("active");
            // Profile 
            profileMenu.removeClass("active");
            profileToggle.removeClass("active");
        });
    }
    $(document).on("click", function (event) {
        const target = $(event.target);
        if (notiContainer.length && !notiContainer.is(target) && !notiContainer.has(target).length) {
            notiWrap.removeClass("active");
            if (notiToggle.length) {
                notiToggle.removeClass("active");
            }
        }
    });


    // Sidebar first submenu 
    $(".first-li-have-sub > a").on("click", function () {
        $(this).parent().toggleClass("active");
        $(".first-li-have-sub").not($(this).parent()).removeClass("active");
    });
    // Sidebar second submenu 
    $(".second-li-have-sub > a").on("click", function () {
        $(this).parent().toggleClass("active");
        $(".second-li-have-sub").not($(this).parent()).removeClass("active");
    });
    // user profile submenu 
    $(".dropdown-list-have-sub > a").on("click", function () {
        $(this).parent().toggleClass("active");
        $(this).siblings(".dropdown-list-submenu").slideToggle();
        $(".dropdown-list-have-sub").not($(this).parent()).removeClass("active");
        $(".dropdown-list-submenu").not($(this).siblings()).slideUp();
    });



});


//  Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl, {
        trigger: 'hover'
    });
});


// Dashboard Accordion  
function accordion() {
    var Accordion = function (el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;
        // Variables privadas
        var links = this.el.find('.accordion-btn-wrap');
        // Evento
        links.on('click', { el: this.el, multiple: this.multiple }, this.dropdown)
    }
    Accordion.prototype.dropdown = function (e) {
        var $el = e.data.el,
            $this = $(this),
            $next = $this.next();
        $next.slideToggle();
        $this.parent().toggleClass('active-accor');
        if (!e.data.multiple) {
            $el.find('.accoritem-body').not($next).slideUp().parent().removeClass('active-accor');
            $el.find('.accoritem-body').not($next).slideUp();
        };
    }
    var accordion = new Accordion($('.ol-my-accordion'), false);
}
accordion();
// Dashboard Accordion  



// custom dropdown
document.addEventListener('DOMContentLoaded', function () {
    var dropdownHeaders = document.querySelectorAll('.dropdown-header');
    var dropdownLists = document.querySelectorAll('.dropdown-list');

    dropdownHeaders.forEach(function (header) {
        header.addEventListener('click', function (event) {
            var dropdown = event.target.closest('.custom-dropdown');
            var list = dropdown.querySelector('.dropdown-list');

            // Toggle dropdown visibility
            list.style.display = list.style.display === 'block' ? 'none' : 'block';

            // Adjust dropdown position based on available space
            var headerRect = header.getBoundingClientRect();
            var dropdownRect = list.getBoundingClientRect();
            var spaceRight = window.innerWidth - headerRect.right;
            if (spaceRight < dropdownRect.width) {
                list.style.left = 'auto';
                list.style.right = '0';
            } else {
                list.style.left = '0';
                list.style.right = 'auto';
            }
        });
    });

    dropdownLists.forEach(function (list) {
        list.addEventListener('click', function (event) {
            if (event.target.tagName === 'LI') {
                var dropdown = event.target.closest('.custom-dropdown');
                var list = dropdown.querySelector('.dropdown-list');
                list.style.display = 'none';
            }
        });
    });

    // Close dropdown when clicking outside of it
    document.addEventListener('click', function (event) {
        var dropdowns = document.querySelectorAll('.custom-dropdown');
        dropdowns.forEach(function (dropdown) {
            var header = dropdown.querySelector('.dropdown-header');
            var list = dropdown.querySelector('.dropdown-list');
            if (header && list) {
                if (!header.contains(event.target) && !list.contains(event.target)) {
                    list.style.display = 'none';
                }
            }
        });
    });
});

// Custom dropdown end  