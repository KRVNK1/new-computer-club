const alerts = document.querySelectorAll(".alert");

function hideErrors() {
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach((alert) => {
                alert.style.display = "none";
            });
        }, 5000);
    }
}

hideErrors();