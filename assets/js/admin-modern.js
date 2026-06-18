// ============================================
// SAWA ADMIN MODERN DASHBOARD JS
// Modern Interactive Features
// ============================================

document.addEventListener('DOMContentLoaded', function () {
    initAdminDashboard();
});

function initAdminDashboard() {
    // Initialize features
    initAnimations();
    initTooltips();
    initSearch();
    initCharts();
    initNotifications();
}

// ============= ANIMATIONS =============

function initAnimations() {
    // Animate metric cards on load
    const metrics = document.querySelectorAll('.admin-metric');
    metrics.forEach((metric, index) => {
        setTimeout(() => {
            metric.style.animation = 'fadeIn 0.5s ease-out forwards';
        }, index * 100);
    });
}

// ============= TOOLTIPS =============

function initTooltips() {
    // Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// ============= SEARCH FUNCTIONALITY =============

function initSearch() {
    const searchInputs = document.querySelectorAll('[data-search-table]');
    
    searchInputs.forEach(input => {
        input.addEventListener('keyup', function () {
            const tableId = this.getAttribute('data-search-table');
            const table = document.getElementById(tableId);
            const rows = table.querySelectorAll('tbody tr');
            const searchTerm = this.value.toLowerCase();
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
}

// ============= CHARTS =============

function initCharts() {
    // Check if Chart.js is available
    if (typeof Chart === 'undefined') return;
    
    // Initialize any chart elements
    const chartElements = document.querySelectorAll('[data-chart]');
    chartElements.forEach(element => {
        const chartType = element.getAttribute('data-chart-type') || 'line';
        const chartData = element.getAttribute('data-chart-data');
        
        if (chartData) {
            try {
                const data = JSON.parse(chartData);
                createChart(element, chartType, data);
            } catch (e) {
                console.error('Error parsing chart data:', e);
            }
        }
    });
}

function createChart(element, type, data) {
    const ctx = element.getContext('2d');
    
    new Chart(ctx, {
        type: type,
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: { size: 13, weight: 500 },
                        padding: 15,
                        usePointStyle: true,
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    });
}

// ============= NOTIFICATIONS =============

function initNotifications() {
    // Auto-hide alert messages
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        if (!alert.classList.contains('alert-static')) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 4000);
        }
    });
}

// ============= UTILITIES =============

// Confirm delete action
function confirmDelete(message = 'هل أنت متأكد من حذف هذا العنصر؟') {
    return confirm(message || 'هل أنت متأكد؟');
}

// Format numbers with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Copy to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showNotification('تم النسخ بنجاح', 'success');
    }).catch(err => {
        console.error('Failed to copy:', err);
    });
}

// Show notification toast
function showNotification(message, type = 'info', duration = 3000) {
    const notificationHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    const container = document.body.appendChild(document.createElement('div'));
    container.innerHTML = notificationHtml;
    
    setTimeout(() => {
        container.remove();
    }, duration);
}

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ============= TABLE UTILITIES =============

// Sort table by column
function sortTable(columnIndex, tableId) {
    const table = document.getElementById(tableId);
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const isAsc = !table.getAttribute('data-sort-asc');
    
    rows.sort((a, b) => {
        const aText = a.children[columnIndex].textContent.trim();
        const bText = b.children[columnIndex].textContent.trim();
        
        const aNum = parseFloat(aText);
        const bNum = parseFloat(bText);
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAsc ? aNum - bNum : bNum - aNum;
        }
        
        return isAsc 
            ? aText.localeCompare(bText)
            : bText.localeCompare(aText);
    });
    
    rows.forEach(row => table.querySelector('tbody').appendChild(row));
    table.setAttribute('data-sort-asc', isAsc);
}

// Export table to CSV
function exportTableToCSV(tableId, filename = 'export.csv') {
    const table = document.getElementById(tableId);
    const csv = [];
    
    // Get headers
    const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
    csv.push(headers.join(','));
    
    // Get rows
    table.querySelectorAll('tbody tr').forEach(tr => {
        const row = Array.from(tr.querySelectorAll('td')).map(td => {
            let text = td.textContent.trim();
            // Escape quotes in CSV
            if (text.includes(',')) {
                text = `"${text}"`;
            }
            return text;
        });
        csv.push(row.join(','));
    });
    
    // Download CSV
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// ============= FORM UTILITIES =============

// Validate form
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

// Reset form
function resetForm(formId) {
    const form = document.getElementById(formId);
    form.reset();
    form.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
}

// ============= FILE UPLOAD =============

function handleFileUpload(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (event) {
                if (preview) {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                }
            };
            reader.readAsDataURL(file);
        }
    });
}

// ============= KEYBOARD SHORTCUTS =============

document.addEventListener('keydown', function (e) {
    // Ctrl/Cmd + K for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('[data-search-table]');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Esc to close modals
    if (e.key === 'Escape') {
        const modal = bootstrap.Modal.getOrCreateInstance(document.querySelector('.modal.show'));
        if (modal) {
            modal.hide();
        }
    }
});

// ============= EXPORT FUNCTIONS =============

// Print table
function printTable(tableId) {
    const table = document.getElementById(tableId);
    const printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<html><head><title>طباعة</title></head><body>');
    printWindow.document.write(table.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Download JSON
function downloadJSON(data, filename = 'data.json') {
    const json = JSON.stringify(data, null, 2);
    const blob = new Blob([json], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
