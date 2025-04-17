const alerts = document.querySelectorAll('.alert');
const tabContents = document.querySelectorAll('.tab-content');
const currentDashTab = document.querySelector('.dashboard-tab[data-tab="' + tabId + '"]')
const dashboardTabs = document.querySelectorAll('.dashboard-tab');

document.addEventListener('DOMContentLoaded', function() {
    // переключение вкладок
    window.switchTab = function(tabId) {
        // Скрываем все вкладки

        tabContents.forEach((tab) => {
            tab.classList.remove('active');
        });
        
        // Убираем активный класс у всех кнопок
        dashboardTabs.forEach((button) => {
            button.classList.remove('active');
        });
        
        // Показываем выбранную вкладку
        document.getElementById(tabId).classList.add('active');
        
        // Добавляем активный класс к кнопке
        currentDashTab.classList.add('active');
    };
    
    // Обработчик клика по вкладкам
    dashboardTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            switchTab(this.getAttribute('data-tab'));
        });
    });
    
    // Скрытие уведомлений об ошибках

    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach((alert) => {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            });
        }, 5000);
    }
});
