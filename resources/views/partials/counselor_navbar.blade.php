@php
    $unreadCount = auth()->user()->unreadNotifications()->count();
    $recentNotifications = auth()->user()->notifications()->latest()->take(10)->get();
@endphp

<style>
    .counselor-navbar {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 0.6rem 2rem;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 0;
        z-index: 1000;
        gap: 1.5rem;
    }

    /* Notification Bell in Navbar */
    .nav-notification-container {
        position: relative;
    }

    .nav-notification-btn {
        background: white;
        border: 1px solid rgba(0,0,0,0.08);
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--forest-green);
        font-size: 1.25rem;
        transition: all 0.2s ease;
        position: relative;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .nav-notification-btn:hover {
        background: var(--forest-green-lighter);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: var(--forest-green);
    }

    .nav-notification-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        background: #ff4757;
        color: white;
        font-size: 0.7rem;
        font-weight: 800;
        min-width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
        box-shadow: 0 2px 5px rgba(255, 71, 87, 0.3);
    }

    /* Profile Dropdown Modern */
    .counselor-profile-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 4px 6px 4px 14px;
        height: 44px;
        border-radius: 14px;
        background: white;
        border: 1px solid rgba(0,0,0,0.08);
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .counselor-profile-wrapper:hover {
        border-color: var(--forest-green);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .counselor-profile-img {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        object-fit: cover;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .counselor-info-text {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    .counselor-name-top {
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-dark);
    }

    .counselor-status-top {
        font-size: 0.7rem;
        color: #28a745;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .counselor-status-top::before {
        content: '';
        width: 6px;
        height: 6px;
        background: #28a745;
        border-radius: 50%;
        display: inline-block;
    }

    .modern-dropdown-menu {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.12);
        padding: 0.75rem;
        min-width: 240px;
        margin-top: 10px !important;
        background: white;
    }

    .dropdown-user-header {
        padding: 0.5rem 0.75rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 0.5rem;
    }

    .dropdown-user-header .u-name {
        font-weight: 700;
        display: block;
        color: var(--text-dark);
    }

    .dropdown-user-header .u-email {
        font-size: 0.75rem;
        color: #64748b;
    }

    .modern-dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.7rem 0.85rem;
        border-radius: 10px;
        color: #475569;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.2s;
        text-decoration: none;
    }

    .modern-dropdown-item i {
        font-size: 1.1rem;
        color: #94a3b8;
        transition: color 0.2s;
    }

    .modern-dropdown-item:hover {
        background: #f8fafc;
        color: var(--forest-green);
    }

    .modern-dropdown-item:hover i {
        color: var(--forest-green);
    }

    .modern-dropdown-item.logout {
        color: #ef4444;
        margin-top: 0.25rem;
    }

    .modern-dropdown-item.logout:hover {
        background: #fef2f2;
        color: #ef4444;
    }

    .modern-dropdown-item.logout i {
        color: #fca5a5;
    }

    .notification-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 3rem 1rem;
        color: #94a3b8;
    }

    .notification-empty i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }

    .notification-dropdown-header {
        background: none;
        color: var(--text-dark);
        padding: 1.25rem 1rem 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f5f9;
    }

    .notification-list {
        max-height: 400px;
        overflow-y: auto;
    }

    @media (min-width: 992px) {
        .counselor-navbar {
            margin-left: 210px;
            width: calc(100% - 210px);
        }
    }

    @media (max-width: 991.98px) {
        .counselor-navbar {
            padding: 0.5rem 1rem;
            width: 100%;
            gap: 1rem;
        }
        .counselor-info-text {
            display: none;
        }
    }
</style>

<div class="counselor-navbar">
    <!-- Notification Bell -->
    <div class="nav-notification-container dropdown">
        <button class="nav-notification-btn" id="navNotificationBtn" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bell"></i>
            @if($unreadCount > 0)
                <span class="notification-bell-badge nav-notification-badge">{{ $unreadCount }}</span>
            @endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end modern-dropdown-menu notification-dropdown-menu" id="notificationMenu" style="width: 350px;">
            <li class="notification-dropdown-header">
                <span class="fw-bold">Notifications</span>
                <span class="badge bg-primary rounded-pill" style="font-size: 0.7rem;">{{ $unreadCount }} New</span>
            </li>
            <div class="notification-list" id="notificationList">
                @forelse($recentNotifications as $notification)
                    <li class="notification-item" style="border: none; border-radius: 0; padding: 0.85rem 1rem;">
                        <div class="notification-icon" style="background: #f1f5f9;">
                            @if(isset($notification->data['appointment_id']))
                                <i class="bi bi-calendar-check" style="color: var(--forest-green);"></i>
                            @else
                                <i class="bi bi-info-circle" style="color: #64748b;"></i>
                            @endif
                        </div>
                        <div class="notification-content">
                            <div style="font-size: 0.85rem; color: #334155;">{{ $notification->data['message'] ?? 'New notification' }}</div>
                            <div class="text-muted" style="font-size: 0.7rem; margin-top: 2px;">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="notification-actions">
                             <button type="button" class="btn btn-link dismiss-notification p-0" data-id="{{ $notification->id }}" style="color: #cbd5e1;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </li>
                @empty
                    <li class="notification-empty">
                        <i class="bi bi-bell-slash"></i>
                        <div>No notifications yet</div>
                    </li>
                @endforelse
            </div>
            @if($unreadCount > 0)
                <li class="p-2 border-top">
                    <a href="#" class="btn btn-link w-100 text-decoration-none small" style="color: var(--forest-green);">Mark all as read</a>
                </li>
            @endif
        </ul>
    </div>

    <!-- Profile Dropdown -->
    <div class="dropdown">
        <div class="counselor-profile-wrapper dropdown-toggle" id="counselorProfileDropdownModern" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="counselor-info-text text-end">
                <span class="counselor-name-top">{{ auth()->user()->name }}</span>
                <span class="counselor-status-top">Online</span>
            </div>
            <img src="{{ auth()->user()->avatar_url ?? asset('images/default-avatar.png') }}" alt="Profile" class="counselor-profile-img">
        </div>
        <ul class="dropdown-menu dropdown-menu-end modern-dropdown-menu" aria-labelledby="counselorProfileDropdownModern">
            <div class="dropdown-user-header">
                <span class="u-name">{{ auth()->user()->name }}</span>
                <span class="u-email">{{ auth()->user()->email }}</span>
            </div>
            <li>
                <a class="modern-dropdown-item" href="{{ route('profile') }}">
                    <i class="bi bi-person"></i> My Profile
                </a>
            </li>
            <li>
                <a class="modern-dropdown-item" href="{{ route('counselor.availability.index') }}">
                    <i class="bi bi-calendar-event"></i> My Schedule
                </a>
            </li>
            <li><hr class="dropdown-divider opacity-50"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="modern-dropdown-item logout w-100 border-0 bg-transparent">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

<script>
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
                            }
                        }
                        
                        // Check if empty
                        const list = document.getElementById('notificationList');
                        if (list && list.querySelectorAll('.notification-item').length === 0) {
                            list.innerHTML = '<li class="notification-empty"><i class="bi bi-bell-slash"></i><div>No notifications yet</div></li>';
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
                        const bellBtn = document.querySelector('.nav-notification-btn');
                        let badge = document.querySelector('.notification-bell-badge');
                        
                        if (!badge) {
                            badge = document.createElement('span');
                            badge.className = 'notification-bell-badge nav-notification-badge';
                            badge.textContent = '1';
                            bellBtn.appendChild(badge);
                        } else {
                            badge.textContent = parseInt(badge.textContent) + 1;
                        }

                        // Remove empty state if present
                        const emptyState = document.querySelector('.notification-empty');
                        if (emptyState) {
                            emptyState.remove();
                        }

                        // Add to list
                        const list = document.getElementById('notificationList');
                        const newItem = document.createElement('li');
                        newItem.className = 'notification-item';
                        newItem.style.border = 'none';
                        newItem.style.borderRadius = '0';
                        newItem.style.padding = '0.85rem 1rem';
                        newItem.style.backgroundColor = '#f0f9ff'; // Light blue for new ones
                        
                        const iconClass = notification.appointment_id ? 'bi-calendar-check' : 
                                         (notification.assessment_id ? 'bi-clipboard-check' : 
                                         (notification.sender_id ? 'bi-chat-dots' : 'bi-info-circle'));
                        
                        newItem.innerHTML = `
                            <div class="notification-icon" style="background: #e0f2fe;">
                                <i class="bi ${iconClass}" style="color: #0369a1;"></i>
                            </div>
                            <div class="notification-content">
                                <div style="font-size: 0.85rem; color: #0c4a6e;">${notification.message}</div>
                                <div class="text-muted" style="font-size: 0.7rem; margin-top: 2px;">Just now</div>
                            </div>
                            <div class="notification-actions">
                                <button type="button" class="btn btn-link dismiss-notification p-0" 
                                    data-id="${notification.id}" 
                                    style="color: #0369a1;">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        `;
                        
                        list.prepend(newItem);
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
                                text: notification.message
                            });
                        }
                    });
            }
        }, 500);
    });
</script>
    });
</script>
