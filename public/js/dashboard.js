document.addEventListener('DOMContentLoaded', function() {
    // Функция для переключения вкладок
    window.switchTab = function(tabId) {
        // Скрываем все вкладки
        document.querySelectorAll('.tab-content').forEach(function(tab) {
            tab.classList.remove('active');
        });
        
        // Убираем активный класс у всех кнопок
        document.querySelectorAll('.dashboard-tab').forEach(function(button) {
            button.classList.remove('active');
        });
        
        // Показываем выбранную вкладку
        document.getElementById(tabId).classList.add('active');
        
        // Добавляем активный класс к кнопке
        document.querySelector('.dashboard-tab[data-tab="' + tabId + '"]').classList.add('active');
    };
    
    // Обработчик клика по вкладкам
    document.querySelectorAll('.dashboard-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            switchTab(this.getAttribute('data-tab'));
        });
    });
    
    // Автоматическое скрытие уведомлений через 5 секунд
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(function() {
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            });
        }, 500000);
    }
});
