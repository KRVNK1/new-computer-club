const alerts = document.querySelectorAll('.alert');
const tabContents = document.querySelectorAll('.tab-content');
const dashboardTabs = document.querySelectorAll('.dashboard-tab');
const paginationLinks = document.querySelectorAll('.pagination a');

function hideErrors() {
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(function () {
                    alert.style.display = 'none';
                }, 500);
            });
        }, 5000);
    }
}

dashboardTabs.forEach((button, index) => {
    button.addEventListener("click", function () {
        dashboardTabs.forEach((btn) => btn.classList.remove("active"))
        tabContents.forEach((content) => content.classList.remove("active", "fade-in", "visible"))

        this.classList.add("active")

        tabContents[index].classList.add('active', 'fade-in', 'visible');
    })
})

// Скрытие уведомлений об ошибках
hideErrors();