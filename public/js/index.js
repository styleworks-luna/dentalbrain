$(function () {

    var mySwiper = new Swiper('.swiper-container', {
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            type: 'bullets',
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });

    var mySwiper = new Swiper('.swiper-container2', {
        slidesPerView: 5,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var mySwiper = new Swiper('.swiper-container3', {
        slidesPerView: 2,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
