const alerts = document.querySelectorAll('.alert');
const tabContents = document.querySelectorAll('.tab-content');
const dashboardTabs = document.querySelectorAll('.dashboard-tab');
const paginationLinks = document.querySelectorAll('.pagination a');

const urlParams = new URLSearchParams(window.location.search);
const tabParam = urlParams.get('tab');

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

function updatePaginationLinks(tabId) {
    paginationLinks.forEach(link => {
        if (link.href) {
            const url = new URL(link.href);
            url.searchParams.set('tab', tabId);
            link.href = url.toString();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // переключение вкладок
    window.switchTab = function (tabId) {
        // Скрываем все вкладки
        tabContents.forEach(content => {
            content.classList.remove('active');
        });

        // Убираем активный класс у всех кнопок
        dashboardTabs.forEach(tab => {
            tab.classList.remove('active');
        });

        // Показываем выбранную вкладку
        document.getElementById(tabId).classList.add('active');

        // Добавляем активный класс к кнопке
        document.querySelector(`.dashboard-tab[data-tab="${tabId}"]`).classList.add('active');

        localStorage.setItem('activeTab', tabId);

        // Добавление id для вкладок пагинации
        if (tabId === 'bookings') {
            updatePaginationLinks(tabId);
        }
    };

    // Обработчик клика по вкладкам
    dashboardTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const tabId = tab.getAttribute('data-tab'); // Используем tab, а не this
            switchTab(tabId);
        });
    });

    paginationLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Получаем текущую активную вкладку
            const currentTab = localStorage.getItem('activeTab') || 'overview';

            // Обновляем URL ссылки перед переходом
            if (link.href && currentTab) {
                const url = new URL(link.href);
                url.searchParams.set('tab', currentTab);
                link.href = url.toString();
            }
        });
    });

    // Скрытие уведомлений об ошибках
    hideErrors();

    let activeTab;
    
    if (tabParam) {
        // Если есть параметр tab в URL
        activeTab = tabParam;
    } else {
        // Иначе берем из localStorage или используем 'overview' по умолчанию
        activeTab = localStorage.getItem('activeTab') || 'overview';
    }

    // Активируем вкладку
    switchTab(activeTab);
});