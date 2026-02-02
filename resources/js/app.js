import './bootstrap';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Enhanced notification system for user actions
document.addEventListener('DOMContentLoaded', function () {
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

    // Confirmation modal helper (returns a Promise<boolean>)
    function createConfirmModalIfNeeded() {
        let modal = document.getElementById('globalConfirmModal');
        if (modal) return modal;
        modal = document.createElement('div');
        modal.id = 'globalConfirmModal';
        modal.innerHTML = `
            <div class="modal fade" tabindex="-1" id="globalConfirmModalInner" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body"><p id="globalConfirmModalMessage"></p></div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="globalConfirmModalCancel">Cancel</button>
                    <button type="button" class="btn btn-primary" id="globalConfirmModalOk">Confirm</button>
                  </div>
                </div>
              </div>
            </div>`;
        document.body.appendChild(modal);
        return modal;
    }

    function showConfirm(message, title = 'Confirm Action') {
        return new Promise((resolve) => {
            const wrapper = createConfirmModalIfNeeded();
            const inner = document.getElementById('globalConfirmModalInner');
            const msgEl = document.getElementById('globalConfirmModalMessage');
            const okBtn = document.getElementById('globalConfirmModalOk');
            const cancelBtn = document.getElementById('globalConfirmModalCancel');
            if (!inner || !msgEl || !okBtn || !cancelBtn) {
                // If modal creation failed unexpectedly, deny action to avoid native confirm()
                resolve(false);
                return;
            }
            msgEl.textContent = message;
            // Use Bootstrap modal if available
            if (typeof bootstrap !== 'undefined') {
                const bsModal = new bootstrap.Modal(inner, { backdrop: 'static' });
                okBtn.focus();
                const clean = () => {
                    okBtn.removeEventListener('click', onOk);
                    cancelBtn.removeEventListener('click', onCancel);
                    inner.addEventListener('hidden.bs.modal', onHidden);
                };
                const onOk = () => { bsModal.hide(); resolve(true); };
                const onCancel = () => { bsModal.hide(); resolve(false); };
                const onHidden = () => { clean(); };
                okBtn.addEventListener('click', onOk);
                cancelBtn.addEventListener('click', onCancel);
                inner.addEventListener('hidden.bs.modal', onHidden);
                bsModal.show();
                return;
            }
            // Lightweight fallback if Bootstrap JS not present
            inner.style.display = 'block';
            inner.classList.add('show');
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
            const onOk = () => { cleanup(); resolve(true); };
            const onCancel = () => { cleanup(); resolve(false); };
            function cleanup() {
                okBtn.removeEventListener('click', onOk);
                cancelBtn.removeEventListener('click', onCancel);
                inner.classList.remove('show');
                inner.style.display = 'none';
                if (backdrop.parentNode) backdrop.parentNode.removeChild(backdrop);
            }
            okBtn.addEventListener('click', onOk);
            cancelBtn.addEventListener('click', onCancel);
        });
    }

    // Attach to elements with data-confirm using the modal helper
    const confirmButtons = document.querySelectorAll('[data-confirm]');
    confirmButtons.forEach(button => {
        // If it's a form, intercept submit; otherwise intercept click
        if (button.tagName === 'FORM') {
            button.addEventListener('submit', function (e) {
                e.preventDefault();
                const message = this.getAttribute('data-confirm');
                const title = this.getAttribute('data-confirm-title') || 'Confirm Action';
                showConfirm(message, title).then(ok => { if (ok) { button.removeAttribute('data-confirm'); button.submit(); } });
            });
        } else {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const message = this.getAttribute('data-confirm');
                const title = this.getAttribute('data-confirm-title') || 'Confirm Action';
                const el = this;
                showConfirm(message, title).then(ok => { if (ok) { const href = el.getAttribute('href'); if (href) window.location = href; } });
            });
        }
    });

    // Enhanced form validation feedback
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function () {
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
            deleteBtn.addEventListener('click', function (e) {
                const userName = this.getAttribute('data-user-name');
                const userEmail = this.getAttribute('data-user-email');
                const msg = `⚠️ Delete User\n\nAre you sure you want to permanently delete:\n\nName: ${userName}\nEmail: ${userEmail}\n\nThis action cannot be undone and will remove all associated data.`;
                e.preventDefault();
                showConfirm(msg, 'Delete User').then(ok => { if (ok) { const href = this.getAttribute('href'); if (href) window.location = href; else { const form = this.closest('form'); if (form) form.submit(); } } });
            });
        }

        const toggleBtn = row.querySelector('.btn-toggle-status');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function (e) {
                const userName = this.getAttribute('data-user-name');
                const currentStatus = this.getAttribute('data-current-status');
                const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
                const msg = `🔄 Change User Status\n\nAre you sure you want to change the status of:\n\nName: ${userName}\nFrom: ${currentStatus}\nTo: ${newStatus}\n\nThis will ${newStatus === 'inactive' ? 'prevent' : 'allow'} the user from logging in.`;
                e.preventDefault();
                showConfirm(msg, 'Change User Status').then(ok => { if (ok) { const href = this.getAttribute('href'); if (href) window.location = href; else { const form = this.closest('form'); if (form) form.submit(); } } });
            });
        }
    });

    // Enhanced search functionality
    const searchInput = document.getElementById('user-search');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    }

    // Enhanced pagination feedback
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function () {
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

    // Auto-wrap tables in .table-responsive if not already wrapped
    document.querySelectorAll('table').forEach(function (tbl) {
        if (!tbl.closest('.table-responsive')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'table-responsive responsive-overflow';
            tbl.parentNode.insertBefore(wrapper, tbl);
            wrapper.appendChild(tbl);
        }
    });

    // Ensure all inline images inside content scale appropriately
    document.querySelectorAll('img').forEach(function (img) {
        img.classList.add('img-fluid');
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
