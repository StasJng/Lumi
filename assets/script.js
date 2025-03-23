document.addEventListener('DOMContentLoaded', () => {
    let heroSwiper = new Swiper('.hero .swiper-container', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoHeight: true,
        pagination: {
            el: '.hero .swiper-pagination',
            clickable: true
        }
    });

    let choiceSwiper = new Swiper('.choice .swiper-container',
        {
            slidesPerView: 3,
            spaceBetween: 32,
            loop: false,
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
                992: {
                    slidesPerView: 1.5,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 32,
                }
            },
            pagination: {
                el: '.choice .swiper-pagination',
                clickable: true
            },
            // Navigation buttons
            navigation: {
                nextEl: '.choice .swiper-button-next',
                prevEl: '.choice .swiper-button-prev',
            },

            // Optional extras
            // autoplay: {
            //     delay: 3000,
            //     disableOnInteraction: true,
            // },

            speed: 800,
            //grabCursor: true,
            //centeredSlides: false,
            //effect: 'slide',
        });
});


