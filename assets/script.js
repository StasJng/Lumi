// Initialize Swiper
const swiper = new Swiper('.hero__container', {
    loop: true,
    pagination: {
        el: '.swiper-pagination',
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

// Lazy Loading with Intersection Observer
const images = document.querySelectorAll('img[loading="lazy"]');

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.getAttribute('data-src');
            observer.unobserve(img);
        }
    });
}, {
    rootMargin: '50px',
});

images.forEach(img => {
    img.setAttribute('data-src', img.src);
    img.removeAttribute('src');
    observer.observe(img);
});