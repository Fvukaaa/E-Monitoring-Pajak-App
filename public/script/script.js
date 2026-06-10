const logoutBtn = document.querySelector('.logout-btn');
if (logoutBtn) {
    logoutBtn.addEventListener('click', function (e) {

        if (confirm('Apakah Anda yakin ingin keluar?')) {

        } else {
            e.preventDefault();
        }
    });
}

document.addEventListener('click', function (e) {
    const link = e.target.closest('a[href*="#"]');
    if (!link || !link.getAttribute('href').startsWith('#')) return;

    const targetId = link.getAttribute('href');
    const targetElement = document.querySelector(targetId);

    if (targetElement) {
        e.preventDefault();
        targetElement.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
});

window.addEventListener('resize', function () {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');

    if (window.innerWidth < 768) {

        sidebar.style.position = 'relative';
    } else {

        sidebar.style.position = 'static';
    }
});

const tableRows = document.querySelectorAll('.data-table tbody tr');
tableRows.forEach(row => {
    row.addEventListener('mouseenter', function () {
        this.style.backgroundColor = '#e8f4f0';
    });

    row.addEventListener('mouseleave', function () {

        if (this.rowIndex % 2 === 0) {
            this.style.backgroundColor = '#f9f9f9';
        } else {
            this.style.backgroundColor = '';
        }
    });
});

function animateStatNumber(element, target, duration = 1000) {
    let current = 0;
    const increment = target / (duration / 16);

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

document.addEventListener('DOMContentLoaded', function () {
    const statNumbers = document.querySelectorAll('.stat-number');

    statNumbers.forEach(stat => {
        const text = stat.textContent;

        const numberMatch = text.match(/\d+/);

        if (numberMatch && text === numberMatch[0]) {
            const target = parseInt(numberMatch[0]);
            animateStatNumber(stat, target);
        }
    });
});

function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;

    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('error');
            isValid = false;
        } else {
            input.classList.remove('error');
        }
    });

    return isValid;
}

function formatCurrency(value) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(value);
}

function formatDate(date) {
    return new Intl.DateTimeFormat('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(new Date(date));
}

function showNotification(message, type = 'info', duration = 3000) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background-color: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
        color: white;
        border-radius: 4px;
        z-index: 9999;
        animation: slideIn 0.3s ease;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, duration);
}

document.addEventListener('keydown', function (event) {

    if (event.altKey && event.key === 'l') {
        const logoutBtn = document.querySelector('.logout-btn');
        if (logoutBtn) {
            logoutBtn.click();
        }
    }

    if (event.altKey && event.key === 'd') {
        const dashboardLink = document.querySelector('[data-menu="dashboard"]');
        if (dashboardLink) {
            window.location.href = dashboardLink.href;
        }
    }
});
