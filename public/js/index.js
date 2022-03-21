$(function () {

    function numFormat(variable) {
        variable = Number(variable).toString();
        if (Number(variable) < 10 && variable.length == 1) variable = "0" + variable;
        return variable;
    }

    var mySwiper = new Swiper('.swiper-container', {
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        cssMode: true,
        pagination: {
            el: '.swiper-pagination',
            type: 'fraction',
            renderFraction: function (currentClass, totalClass) {
                return '<span class="' + currentClass + '"></span>' +
                    '<span class="pagination-bar"></span>' +
                    '<span class="' + totalClass + '"></span>';
            },
            formatFractionCurrent: function (number) {
                var Mynumber = numFormat(number)
                return Mynumber;
            },
            formatFractionTotal: function (number) {
                var Mynumber = numFormat(number)
                return Mynumber;
            },
        },
        scrollbar: {
            el: '.swiper-scrollbar',
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

   var mySwiper = new Swiper('.middle-swiper-container', {
        slidesPerView: 5,
        spaceBetween: 20,
        navigation: {
            nextEl: '.middle-swiper-button-next',
            prevEl: '.middle-swiper-button-prev',
        },
    });

    var mySwiper = new Swiper('.middle-swiper-container2', {
        initialSlide: 0,
        slidesPerView: 4,
        spaceBetween: 19,
        navigation: {
            nextEl: '.middle-swiper-button-next2',
            prevEl: '.middle-swiper-button-prev2',
        },
        observer: true,
        observeParents: true,
        freeMode: true,
    });


    var mySwiper = new Swiper('.middle-swiper-container3', {
        initialSlide: 0,
        slidesPerView: 4,
        spaceBetween: 19,
        navigation: {
            nextEl: '.middle-swiper-button-next3',
            prevEl: '.middle-swiper-button-prev3',
        },
        observer: true,
        observeParents: true,
        freeMode: true,
    });

    var mySwiper = new Swiper('.m-middle-swiper-container', {
        slidesPerView: 2.6,
    });

    var mySwiper = new Swiper('.m-middle-swiper-container2', {
        initialSlide: 0,
        slidesPerView: 2.1,
        observer: true,
        observeParents: true,
        freeMode: true,

    });

    var mySwiper = new Swiper('.m-middle-swiper-container3', {
        initialSlide: 0,
        slidesPerView: 2.1,
        observer: true,
        observeParents: true,
        freeMode: true,
    });

    var mySwiper = new Swiper('.bottom-swiper-container', {
        slidesPerView: 2,
        spaceBetween: 20,
        navigation: {
            nextEl: '.bottom-swiper-button-next',
            prevEl: '.bottom-swiper-button-prev',
        },
    });
});
