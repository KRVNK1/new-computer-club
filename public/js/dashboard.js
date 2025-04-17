document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    const tabContents = document.querySelectorAll('.tab-content');
    const dashboardTabs = document.querySelectorAll('.dashboard-tab');

    // переключение вкладок
    window.switchTab = function(tabId) {
        // Скрываем все вкладки
        tabContents.forEach((content) => {
            content.classList.remove('active');
        });
        
        // Убираем активный класс у всех кнопок
        dashboardTabs.forEach((tab) => {
            tab.classList.remove('active');
        });
        
        // Показываем выбранную вкладку
        document.getElementById(tabId).classList.add('active');
        
        // Добавляем активный класс к кнопке
        document.querySelector(`.dashboard-tab[data-tab="${tabId}"]`).classList.add('active');
    };
    
    // Обработчик клика по вкладкам
    dashboardTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const tabId = tab.getAttribute('data-tab'); // Используем tab, а не this
            switchTab(tabId);
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