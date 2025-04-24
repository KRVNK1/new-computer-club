const menuToggle = document.querySelector('.nav-menu-toggle');
const navigation = document.querySelector('.navigation');


menuToggle.addEventListener('click', function () {

    navigation.classList.toggle('active');

    this.classList.toggle('active');

    const bars = this.querySelectorAll('.bar');

    if (this.classList.contains('active')) {
        bars[0].style.transform = 'translateY(12px) rotate(45deg)';
        bars[1].style.opacity = '0';
        bars[2].style.transform = 'translateY(-12px) rotate(-45deg)';
        document.body.style = ('overflow:hidden');
    } else {
        bars[0].style.transform = 'none';
        bars[1].style.opacity = '1';
        bars[2].style.transform = 'none';
        document.body.style = ('overflow:auto');
    }
});

const navLinks = document.querySelectorAll('.nav-link, .login-button');
navLinks.forEach(link => {
    link.addEventListener('click', function () {
        navigation.classList.remove('active');
        menuToggle.classList.remove('active');

        // Возвращаем бургер-иконку в исходное состояние
        const bars = menuToggle.querySelectorAll('.bar');
        bars[0].style.transform = 'none';
        bars[1].style.opacity = '1';
        bars[2].style.transform = 'none';

    });
});

// Закрываем меню при изменении размера окна (если оно становится больше 991px)
window.addEventListener('resize', function () {
    if (window.innerWidth > 991) {
        navigation.classList.remove('active');
        menuToggle.classList.remove('active');

        // Возвращаем бургер-иконку в исходное состояние
        const bars = menuToggle.querySelectorAll('.bar');
        bars[0].style.transform = 'none';
        bars[1].style.opacity = '1';
        bars[2].style.transform = 'none';
    }
});