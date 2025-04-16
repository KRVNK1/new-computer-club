const tabButtons = document.querySelectorAll('.tab-button');
const tabContents = document.querySelectorAll('.specs-columns');

document.addEventListener('DOMContentLoaded', function () {
    tabButtons.forEach((button, index) => {
        button.addEventListener('click', function () {

            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active', 'fade-in', 'visible'));

            this.classList.add('active');

            tabContents[index].classList.add('active', 'fade-in', 'visible');
        });
    });
});