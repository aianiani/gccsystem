<!-- Notification Bell Dropdown at Top Right -->
<style>
    .notification-bell {
        background: white !important;
        border: none !important;
        outline: none !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        position: relative;
        transition: all 0.3s ease !important;
        width: 45px !important;
        height: 45px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        min-width: 45px !important;
    }

    .notification-bell:hover {
        background: var(--yellow-maize);
        box-shadow: 0 6px 20px rgba(255, 203, 5, 0.4);
        transform: translateY(-2px);
    }

    .notification-bell .bi-bell {
        color: var(--forest-green);
        font-size: 1.3rem;
        transition: all 0.3s ease;
    }

    .notification-bell:hover .bi-bell {
        color: var(--forest-green);
        transform: scale(1.1);
    }

    .notification-bell.pulse {
        animation: bell-shake 0.5s ease-in-out 4; /* Shake 4 times (2 seconds total) */
    }

    @keyframes bell-shake {

        0%,
        100% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(-10deg);
        }

        75% {
            transform: rotate(10deg);
        }
    }

    .notification-bell-badge {
        background: #ff4757 !important; /* Brighter Red */
        color: white !important;
        font-weight: 800 !important;
        font-size: 0.85rem !important;
        border: 2.5px solid #fff !important;
        box-shadow: 0 4px 10px rgba(255, 71, 87, 0.5) !important;
        padding: 0.35em 0.6em !important;
        border-radius: 20px !important;
        top: -5px !important;
        right: -5px !important;
        transform: translate(25%, -25%) !important;
        min-width: 22px;
        line-height: 1;
    }

    .notification-dropdown-menu {
        width: 380px;
        max-width: calc(100vw - 2rem);
        max-height: 70vh;
        overflow-y: auto;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        border: none;
        padding: 0;
        margin-top: 0.5rem;
        background: white;
        overflow-x: hidden;
        z-index: 9999 !important;
        position: absolute !important;
        right: 0;
        top: 50px;
        list-style: none;
    }

    .notification-dropdown-header {
        background: linear-gradient(135deg, var(--forest-green), var(--forest-green-light));
        color: white;
        font-weight: 700;
        padding: 1.25rem 1.5rem;
        font-size: 1.1rem;
        border-bottom: none;
        font-family: inherit;
    }

    .notification-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        background: white;
        transition: background 0.2s;
        border-bottom: 1px solid #f0f0f0;
        font-family: inherit;
        position: relative;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item:hover {
        background: #f8f9fa;
    }

    .notification-item .notification-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .notification-item .notification-icon i {
        color: #1976d2;
        font-size: 0.95rem;
    }

    .notification-item .notification-content {
        flex: 1;
        line-height: 1.4;
        color: #333;
        min-width: 0;
        word-break: break-word;
    }

    .notification-item .notification-content strong {
        color: var(--forest-green);
        font-weight: 600;
    }

    .notification-item .notification-actions {
        display: flex !important;
        flex-direction: row !important;
        gap: 0.25rem !important;
        align-items: center !important;
        flex-shrink: 0;
    }

    .notification-item .btn-view {
        background: var(--forest-green);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        transition: all 0.2s;
        padding: 0;
    }

    .notification-item .btn-view:hover {
        background: var(--forest-green-light);
        transform: scale(1.1);
    }

    .notification-item .btn-link {
        color: #dc3545;
        font-size: 0.85rem;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s;
        background: none;
        border: none;
        border-radius: 50%;
    }

    .notification-item .btn-link:hover {
        color: #c82333;
        background: rgba(220, 53, 69, 0.1);
        transform: scale(1.1);
    }

    .notification-empty {
        padding: 2.5rem 1.5rem;
        color: #999;
        text-align: center;
        font-size: 0.95rem;
        font-family: inherit;
    }

    .notification-empty i {
        font-size: 2.5rem;
        color: #ddd;
        margin-bottom: 0.75rem;
        display: block;
    }

    @media (max-width: 767.98px) {
        .notification-bell-container {
            top: 0.75rem !important;
            right: 0.75rem !important;
        }

        .notification-bell {
            width: 40px !important;
            height: 40px !important;
            min-width: 40px !important;
        }

        .notification-dropdown-menu {
            width: calc(100vw - 1.5rem);
            max-width: calc(100vw - 1.5rem);
            right: -0.75rem;
            top: 48px;
            border-radius: 10px;
            max-height: 65vh;
            padding: 0;
        }

        .notification-dropdown-header {
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
            border-radius: 10px 10px 0 0;
        }

        .notification-item {
            padding: 0.75rem 0.75rem;
            gap: 0.5rem;
            font-size: 0.85rem;
        }

        .notification-item .notification-icon {
            width: 28px;
            height: 28px;
        }

        .notification-item .notification-icon i {
            font-size: 0.8rem;
        }

        .notification-item .notification-content {
            line-height: 1.35;
            font-size: 0.82rem;
        }

        .notification-item .btn-view,
        .notification-item .btn-link {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }

        .notification-empty {
            padding: 1.5rem 1rem;
        }
    }
</style>
@php
    $unreadCount = auth()->user()->unreadNotifications()->count();
    $recentNotifications = auth()->user()->notifications()->latest()->take(10)->get();
@endphp
<div class="dropdown me-3 notification-bell-container" style="position: fixed; top: 1.25rem; right: 1.25rem; z-index: 10000;">
    <button class="btn notification-bell position-relative p-0{{ $unreadCount > 0 ? ' pulse' : '' }}" type="button"
        id="notificationDropdown" onclick="toggleNotificationDropdown()">
        <i class="bi bi-bell"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge notification-bell-badge">
                {{ $unreadCount }}
            </span>
        @endif
    </button>
    <ul class="notification-dropdown-menu" id="notificationMenu" style="display: none;">
        <li class="notification-dropdown-header">Notifications</li>
        @forelse($recentNotifications as $notification)
            <li class="notification-item">
                <div class="notification-icon">
                    @if(isset($notification->data['appointment_id']))
                        <i class="bi bi-calendar-check"></i>
                    @else
                        <i class="bi bi-info-circle"></i>
                    @endif
                </div>
                <div class="notification-content">
                    {{ $notification->data['message'] ?? 'You have a new notification.' }}
                    @if(is_null($notification->read_at))
                        <span class="badge bg-primary ms-2" style="font-size: 0.7rem;">New</span>
                    @endif
                    <div class="text-muted small mt-1">
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                </div>
                <div class="notification-actions">
                    @if(isset($notification->data['url']))
                        <a href="{{ $notification->data['url'] }}" class="btn-view" title="View Details">
                            <i class="bi bi-eye"></i>
                        </a>
                    @elseif(isset($notification->data['appointment_id']))
                        @if(auth()->user()->isCounselor())
                            <a href="{{ route('counselor.appointments.show', $notification->data['appointment_id']) }}"
                                class="btn-view" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                        @else
                            <a href="{{ route('appointments.index') }}" class="btn-view" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                        @endif
                    @else
                        @if(auth()->user()->isCounselor())
                            <a href="{{ route('counselor.appointments.index') }}" class="btn-view" title="View Appointments">
                                <i class="bi bi-eye"></i>
                            </a>
                        @else
                            <a href="{{ route('appointments.index') }}" class="btn-view" title="View Appointments">
                                <i class="bi bi-eye"></i>
                            </a>
                        @endif
                    @endif
                    <button type="button" class="btn btn-link dismiss-notification" 
                        data-id="{{ $notification->id }}" 
                        title="Dismiss">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </li>
        @empty
            <li class="notification-empty">
                <i class="bi bi-bell-slash"></i>
                <div>No new notifications</div>
            </li>
        @endforelse
    </ul>
</div>

<script>
    function toggleNotificationDropdown() {
        const menu = document.getElementById('notificationMenu');
        if (menu) {
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
            }
        }
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const bellContainer = document.querySelector('.notification-bell-container');
        const menu = document.getElementById('notificationMenu');
        if (bellContainer && menu && !bellContainer.contains(event.target)) {
            menu.style.display = 'none';
        }
    });

    // Handle AJAX mark as read
    function attachDismissListener(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const id = this.getAttribute('data-id');
            const item = this.closest('.notification-item');
            
            if (!id) {
                item.remove();
                return;
            }

            fetch(`/notifications/${id}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.remove();
                        // Update badge count
                        const badge = document.querySelector('.notification-bell-badge');
                        if (badge) {
                            let count = parseInt(badge.textContent);
                            if (count > 1) {
                                badge.textContent = count - 1;
                            } else {
                                badge.remove();
                                document.querySelector('.notification-bell').classList.remove('pulse');
                            }
                        }
                        
                        // Check if empty
                        const list = document.getElementById('notificationMenu');
                        if (list && list.querySelectorAll('.notification-item').length === 0) {
                            list.innerHTML = '<li class="notification-dropdown-header">Notifications</li><li class="notification-empty"><i class="bi bi-bell-slash"></i><div>No new notifications</div></li>';
                        }
                    }, 300);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Attach to existing buttons
        document.querySelectorAll('.dismiss-notification').forEach(attachDismissListener);

        // Real-time notification listening
        const checkEcho = setInterval(() => {
            if (window.Echo) {
                clearInterval(checkEcho);
                
                window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
                    .notification((notification) => {
                        // Update unread count
                        const bell = document.querySelector('.notification-bell');
                        let badge = document.querySelector('.notification-bell-badge');
                        
                        if (!badge) {
                            badge = document.createElement('span');
                            badge.className = 'position-absolute top-0 start-100 translate-middle badge notification-bell-badge';
                            badge.textContent = '1';
                            bell.appendChild(badge);
                        } else {
                            badge.textContent = parseInt(badge.textContent) + 1;
                        }

                        // Trigger pulse animation
                        bell.classList.remove('pulse');
                        void bell.offsetWidth; // Force reflow
                        bell.classList.add('pulse');

                        // Remove empty state if present
                        const emptyState = document.querySelector('.notification-empty');
                        if (emptyState) {
                            emptyState.remove();
                        }

                        // Add to list
                        const list = document.getElementById('notificationMenu');
                        const newItem = document.createElement('li');
                        newItem.className = 'notification-item';
                        newItem.style.backgroundColor = '#f0f9ff'; // Light blue for new ones
                        
                        const iconClass = notification.appointment_id ? 'bi-calendar-check' : 
                                         (notification.assessment_id ? 'bi-clipboard-check' : 
                                         (notification.sender_id ? 'bi-chat-dots' : 'bi-info-circle'));
                        
                        newItem.innerHTML = `
                            <div class="notification-icon">
                                <i class="bi ${iconClass}"></i>
                            </div>
                            <div class="notification-content">
                                ${notification.message}
                                <span class="badge bg-success ms-2" style="font-size: 0.7rem;">New</span>
                                <div class="text-muted small mt-1">Just now</div>
                            </div>
                            <div class="notification-actions">
                                <a href="${notification.url || '#'}" class="btn-view" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button" class="btn btn-link dismiss-notification" 
                                    data-id="${notification.id}" 
                                    title="Dismiss">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        `;
                        
                        // Prepend to list (after header)
                        const header = list.querySelector('.notification-dropdown-header');
                        if (header) {
                            header.after(newItem);
                        } else {
                            list.prepend(newItem);
                        }
                        
                        // Attach dismiss listener to new item
                        attachDismissListener(newItem.querySelector('.dismiss-notification'));

                        // Show Toast if Swal is available
                        if (window.Swal) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                icon: 'info',
                                title: 'New Notification',
                                text: notification.message,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    toast.addEventListener('click', () => {
                                        window.location.href = notification.url || '#';
                                    })
                                }
                            });
                        }
                    });
            }
        }, 500);
    });
</script>
