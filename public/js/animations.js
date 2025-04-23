const fadeElements = document.querySelectorAll('.fade-in');

const fadeInOnScroll = function () {
    fadeElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (elementTop < windowHeight - 100) {
            element.classList.add('visible');
        }
    });
};

fadeInOnScroll();
window.addEventListener('scroll', fadeInOnScroll);