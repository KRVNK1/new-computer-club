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

// ПЕРЕДЕЛАТЬТ
// const savedTab = localStorage.getItem('activeTab');
// if (savedTab && document.getElementById(savedTab)) {
//     switchTab(savedTab);
// }

// paginationLinks.forEach(link => {
//     link.addEventListener('click', function(e) {
//         e.preventDefault();

//         // Сохраняем активную вкладку
//         const activeTab = document.querySelector('.dashboard-tab.active');
//         if (activeTab) {
//             localStorage.setItem('activeTab', activeTab.dataset.tab);
//         }

//         // Переходим по ссылке
//         window.location.href = this.href;
//     });
// });
