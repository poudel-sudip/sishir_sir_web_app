$(document).ready(function() {
    $(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("400");
            $(this).toggleClass('open');
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("400");
            $(this).toggleClass('open');
        }
    );
});

// main slider
$('.main-slider').owlCarousel({
    smartSpeed: 200,
    nav: true,
    loop: true,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    autoplay: true,
    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    responsive: {
        0: {
            items: 1,
            nav: false
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});

// course-carousel
$('.course-carousel').owlCarousel({
    items: 5,
    smartSpeed: 500,
    nav: true,
    loop: true,
    lazyLoad: true,
    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    responsive: {
        0: {
            items: 1,
            nav: false
        },
        600: {
            items: 3
        },
        1000: {
            items: 5
        }
    }
});
$('.course-carousel').find('.owl-nav').removeClass('disabled');
$('.course-carousel').on('changed.owl.carousel', function(event) {
    $(this).find('.owl-nav').removeClass('disabled');
});

// course-carousel
$('.review-slider').owlCarousel({
    items: 3,
    smartSpeed: 400,
    loop: true,
    nav: true,
    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    responsiveClass: true,
    responsive: {
        0: {
            items: 1,
            nav: false
        },
        600: {
            items: 2
        },
        1000: {
            items: 3
        }
    }
});

$('#top-tutors-slider').owlCarousel({
    items: 4,
    smartSpeed: 600,
    nav: true,
    loop: true,
    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        },
        1000: {
            items: 4
        }
    }
});

// for summer note
$(document).ready(function() {
    $('.summernote').summernote({
        height: 300,
    });
});