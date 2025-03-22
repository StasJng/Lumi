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
});


// let categorySwiper = new Swiper('.category-reg .swiper-container',
//     {
//         slidesPerView: 3,
//         spaceBetween: 5,
//         loop: !1,
//         breakpoints:
//         {
//             768: {
//                 slidesPerView: 1.1,
//                 spaceBetween: 5,
//             },
//             992: {
//                 slidesPerView: 1.5,
//                 spaceBetween: 5,
//             },
//             1200: {
//                 slidesPerView: 2.5,
//                 spaceBetween: 5,
//             }
//         }
//     })