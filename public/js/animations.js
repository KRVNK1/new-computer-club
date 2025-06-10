const fadeElements = document.querySelectorAll('.fade-in');
const alerts = document.querySelectorAll(".alert");

function hideErrors() {
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach((alert) => {
                alert.style.display = "none";
            });
        }, 5000);
    }
}

const fadeInOnScroll = function () {
    fadeElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (elementTop < windowHeight - 100) {
            element.classList.add('visible');
        }
    });
};

hideErrors();
fadeInOnScroll();
window.addEventListener('scroll', fadeInOnScroll);