const tabContents = document.querySelectorAll(".tab-content");
const dashboardTabs = document.querySelectorAll(".dashboard-tab");
const paginationLinks = document.querySelectorAll(".pagination a");

dashboardTabs.forEach((button, index) => {
    button.addEventListener("click", function () {
        dashboardTabs.forEach((btn) => {
            btn.classList.remove("active");
        });
        
        tabContents.forEach((content) => {
            content.classList.remove("active");
        });

        this.classList.add("active");

        tabContents[index].classList.add("active");
    });
});

// Для кнопок в личном кабинете "Все бронирования" и "Редактировать"
function switchTab(id) {
    tabContents.forEach((content) => {
        content.classList.remove("active");
    });

    dashboardTabs.forEach((tab) => {
        tab.classList.remove("active");
    });

    const targetTab = document.getElementById(id);
    if (targetTab) {
        targetTab.classList.add("active");
    }

    dashboardTabs.forEach((tab) => {
        if (tab.dataset.tab === id) {
            tab.classList.add("active");
        }
    });
}
