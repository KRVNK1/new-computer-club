const alerts = document.querySelectorAll(".alert");
const tabContents = document.querySelectorAll(".tab-content");
const dashboardTabs = document.querySelectorAll(".dashboard-tab");
const paginationLinks = document.querySelectorAll(".pagination a");

function hideErrors() {
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach((alert) => {
                alert.style.display = "none";
            });
        }, 5000);
    }
}

dashboardTabs.forEach((button, index) => {
    button.addEventListener("click", function () {
        dashboardTabs.forEach((btn) => btn.classList.remove("active"));
        tabContents.forEach((content) => content.classList.remove("active"));

        this.classList.add("active");

        tabContents[index].classList.add("active");
    });
});

// Скрытие уведомлений об ошибках
hideErrors();
