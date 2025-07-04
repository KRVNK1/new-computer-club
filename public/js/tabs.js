const tabButtons = document.querySelectorAll('.tab-button');
const tabContents = document.querySelectorAll('.specs-columns');

tabButtons.forEach((button, index) => {
    button.addEventListener('click', function () {

        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active', 'visible'));

        this.classList.add('active');

        tabContents[index].classList.add('active', 'visible');
    });
});