'use strict';

//Left navigationbar
$(document).ready(function () {

  //Left navigation bar
  $(".parent-droupdown").on("click", function (e) {
    $(this).children(".parent-droupdown-menu").toggleClass("active");
    $(".parent-droupdown .parent-droupdown-menu")
      .not($(this).children(".parent-droupdown-menu"))
      .removeClass("active");

    $(this).children(".child-side-bar").slideToggle(400);
    $(".parent-droupdown .child-side-bar")
      .not($(this).children(".child-side-bar"))
      .slideUp(400);
    e.stopPropagation();
  });

  $(".parent-droupdown-2nd").on("click", function (e) {
    $(this).children(".parent-droupdown-menu-2nd").toggleClass("active");
    $(".parent-droupdown-2nd .parent-droupdown-menu-2nd")
      .not($(this).children(".parent-droupdown-menu-2nd"))
      .removeClass("active");

    $(this).children(".child-side-bar-2nd").slideToggle(400);
    $(".parent-droupdown-2nd .child-side-bar-2nd")
      .not($(this).children(".child-side-bar-2nd"))
      .slideUp(400);

    e.stopPropagation();
  });
  //End left navigation bar
  $("#navbar-toggle").on("click", function (e) {
    $(".navigation-section").toggleClass("showNav");
    $(".navigation-section-backdrop").fadeIn(100);
  });

  //   Backdroup
  $(".navigation-section-backdrop").on("click", function () {
    $(".navigation-section").removeClass("show");
    $(".navigation-section").removeClass("showNav");
    $(".navigation-section").addClass("hide");
    $(this).fadeOut(100);

    $(".navigation-section").animate(
      {
        marginLeft: "-266px",
      },
      300
    );
  });

  //Window resize & smallest devices toggler
  var storedWidth = window.innerWidth;
  $(window).resize(function () {
    var resizeWidth = window.innerWidth;
    if (storedWidth != resizeWidth) {
      if (resizeWidth <= 1099 && !$(".navigation-section").hasClass("hide")) {
        $(".navigation-section").removeClass("show");
        $(".navigation-section").removeClass("showNav");
        $(".navigation-section").addClass("hide");

        $(".navigation-section-backdrop").fadeOut(100);
        $(".navigation-section").animate(
          {
            marginLeft: "-266px",
          },
          300
        );
      } else if (
        resizeWidth > 1100 &&
        !$(".navigation-section").hasClass("show")
      ) {
        $(".navigation-section").removeClass("hide");
        $(".navigation-section").addClass("show");
        $(".navigation-section").addClass("showNav");

        $(".navigation-section-backdrop").fadeIn(100);
        $(".navigation-section").animate(
          {
            marginLeft: "0px",
          },
          300
        );
      }
      storedWidth = resizeWidth;
    }
  });

  if ($(window).width() <= 1099) {
    if (!$(".navigation-section").hasClass("hide")) {
      $(".navigation-section").addClass("hide");
    }
  } else {
    if (!$(".navigation-section").hasClass("show")) {
      $(".navigation-section").addClass("show");
    }
  }
  //End Window resize & smallest devices toggler
  //End left navigation bar toggler
});

// Carousel only
var swiperOnly = new Swiper(".carouselOnly", {
  autoplay: {
    delay: 1000,
  },
  loop: true,
});

// Carousel controls only
var swiperOnly = new Swiper(".carouselControlsOnly", {
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

// Carousel Indicators only
var swiperOnly = new Swiper(".carouselIndicatorsOnly", {
  autoplay: {
    delay: 1500,
  },
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
  },
});

$(".menuList").on("click", function () {
  $(".sidebar").toggleClass("close");
});
$(".closeIcon").on("click", function () {
  $(".sidebar").removeClass("close");
});
$(".nav-links-li").on("click", function () {
  $(this).toggleClass("showMenu");
  $(".nav-links-li").not($(this)).removeClass("showMenu");
});

// Date range picker
// Default date picker
$(function () {
  $('input[name="eDefaultDateRange"]').daterangepicker(
    {
      singleDatePicker: true,
      showDropdowns: true,
      minYear: 1901,
      maxYear: parseInt(moment().format("YYYY"), 10),
    },
    function (start, end, label) {
      var years = moment().diff(start, "years");
    }
  );
});

// Date range
$(function () {
  $('input[name="eDateRange"]').daterangepicker(
    {
      opens: "right",
    },
    function (start, end, label) {
      console.log(
        "A new date selection was made: " +
        start.format("YYYY-MM-DD") +
        " to " +
        end.format("YYYY-MM-DD")
      );
    }
  );
});

// Tooltip
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Toast
var toastTrigger = document.getElementById("liveToastBtn");
var toastLiveExample = document.getElementById("liveToast");
if (toastTrigger) {
  toastTrigger.addEventListener("click", function () {
    var toast = new bootstrap.Toast(toastLiveExample);

    toast.show();
  });
}
// Custom Toast
var toastTriggerCustom = document.getElementById("liveToastBtnCustom");
var toastLiveExampleCustom = document.getElementById("liveToastCustom");
if (toastTriggerCustom) {
  toastTriggerCustom.addEventListener("click", function () {
    var toast = new bootstrap.Toast(toastLiveExampleCustom);

    toast.show();
  });
}
// Color schemes
var toastTriggerColor = document.getElementById("liveToastBtnColor");
var toastLiveExampleColor = document.getElementById("liveToastColor");
if (toastTriggerColor) {
  toastTriggerColor.addEventListener("click", function () {
    var toast = new bootstrap.Toast(toastLiveExampleColor);

    toast.show();
  });
}

// Select2 js
$(document).ready(function () {
  $(".eChoice-multiple-without-remove").select2({
    placeholder: "Select a state",
  });
});
$(document).ready(function () {
  $(".eChoice-multiple-with-remove").select2();
});
