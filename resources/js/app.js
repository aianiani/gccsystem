import './bootstrap';

// Enhanced notification system for user actions
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide notifications after 5 seconds
    const notifications = document.querySelectorAll('.alert');
    notifications.forEach(notification => {
        setTimeout(() => {
            if (notification) {
                const bsAlert = new bootstrap.Alert(notification);
                bsAlert.close();
            }
        }, 5000);
    });

    // Enhanced confirmation dialogs for destructive actions
    const confirmButtons = document.querySelectorAll('[data-confirm]');
    confirmButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm');
            const title = this.getAttribute('data-confirm-title') || 'Confirm Action';
            
            if (!confirm(`${title}\n\n${message}\n\nAre you sure you want to continue?`)) {
                e.preventDefault();
                return false;
            }
        });
    });

    // Enhanced form validation feedback
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';
                submitBtn.disabled = true;
                
                // Re-enable button after 3 seconds (fallback)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    });

    // Enhanced table row actions with detailed confirmations
    const tableRows = document.querySelectorAll('tr[data-user-id]');
    tableRows.forEach(row => {
        const deleteBtn = row.querySelector('.btn-delete-user');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                const userName = this.getAttribute('data-user-name');
                const userEmail = this.getAttribute('data-user-email');
                
                if (!confirm(`⚠️ Delete User\n\nAre you sure you want to permanently delete:\n\nName: ${userName}\nEmail: ${userEmail}\n\nThis action cannot be undone and will remove all associated data.`)) {
                    e.preventDefault();
                    return false;
                }
            });
        }

        const toggleBtn = row.querySelector('.btn-toggle-status');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                const userName = this.getAttribute('data-user-name');
                const currentStatus = this.getAttribute('data-current-status');
                const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
                
                if (!confirm(`🔄 Change User Status\n\nAre you sure you want to change the status of:\n\nName: ${userName}\nFrom: ${currentStatus}\nTo: ${newStatus}\n\nThis will ${newStatus === 'inactive' ? 'prevent' : 'allow'} the user from logging in.`)) {
                    e.preventDefault();
                    return false;
                }
            });
        }
    });

    // Enhanced search functionality
    const searchInput = document.getElementById('user-search');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    }

    // Enhanced pagination feedback
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function() {
            const pageInfo = document.getElementById('page-loading');
            if (pageInfo) {
                pageInfo.style.display = 'block';
                pageInfo.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Loading page...';
            }
        });
    });

    // Enhanced tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Enhanced popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});

// Custom notification function
function showNotification(message, type = 'info', duration = 5000) {
    const alertContainer = document.createElement('div');
    alertContainer.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertContainer.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    
    alertContainer.innerHTML = `
        <i class="bi bi-${getIconForType(type)} me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertContainer);
    
    // Auto-remove after duration
    setTimeout(() => {
        if (alertContainer.parentNode) {
            alertContainer.remove();
        }
    }, duration);
}

function getIconForType(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-triangle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Export for global use
window.showNotification = showNotification;
