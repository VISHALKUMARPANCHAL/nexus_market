var heroSwiper = new Swiper(".hero-swiper", {
    slidesPerView: 1,
    spaceBetween: 0,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    loop: true,
    effect: "fade",
    fadeEffect: {
        crossFade: true
    },
    on: {
        slideChangeTransitionStart: function() {
            document.querySelectorAll('.hero-content').forEach(function(content) {
                content.classList.remove('animate-fade-up');
            });
        },
        slideChangeTransitionEnd: function() {
            let activeSlide = document.querySelector('.swiper-slide-active .hero-content');
            if (activeSlide) {
                activeSlide.classList.add('animate-fade-up');
            }
        },
    }
});

var collectionSwiper = new Swiper(".collection-swiper", {
    slidesPerView: 3,
    spaceBetween: 20,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    loop: true,
});

document.addEventListener('DOMContentLoaded', function() {
    let activeSlide = document.querySelector('.swiper-slide-active .hero-content');
    if (activeSlide) {
        activeSlide.classList.add('animate-fade-up');
    }
});