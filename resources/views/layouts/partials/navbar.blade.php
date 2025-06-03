<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link sidebar-toggle" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown notification-dropdown">
            <a class="nav-link notification-trigger" data-toggle="dropdown" href="#" id="notificationDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-bell"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge badge-danger navbar-badge notification-badge pulse">
                        {{ auth()->user()->unreadNotifications->count() > 99 ? '99+' : auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notification-dropdown-menu" id="notificationDropdownMenu">
                <div class="dropdown-header">
                    <i class="fas fa-bell mr-2"></i>
                    <span class="notification-count">{{ auth()->user()->unreadNotifications->count() }}</span> 
                    Notifikasi Baru
                </div>
                
                <div class="dropdown-body">
                    @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                        <a href="{{ $notification->data['action_url'] ?? '#' }}" 
                           class="dropdown-item notification-item"
                           data-id="{{ $notification->id }}">
                            <div class="notification-content">
                                <div class="notification-icon">
                                    <i class="fas fa-{{ $notification->data['icon'] ?? 'envelope' }}"></i>
                                </div>
                                <div class="notification-text">
                                    <h6 class="notification-title">{{ $notification->data['title'] }}</h6>
                                    @if(isset($notification->data['message']))
                                        <p class="notification-message">{{ Str::limit($notification->data['message'], 50) }}</p>
                                    @endif
                                    <small class="notification-time">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="notification-status">
                                    <span class="unread-dot"></span>
                                </div>
                            </div>
                        </a>
                        @if(!$loop->last)
                            <div class="dropdown-divider"></div>
                        @endif
                    @empty
                        <div class="empty-notifications">
                            <i class="far fa-bell-slash"></i>
                            <p>Tidak ada notifikasi baru</p>
                        </div>
                    @endforelse
                </div>

                <div class="dropdown-footer">
                    <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-primary btn-block">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat Semua Notifikasi
                    </a>
                </div>
            </div>
        </li>
        
        <!-- Fullscreen Toggle -->
        <li class="nav-item">
            <a class="nav-link fullscreen-toggle" data-widget="fullscreen" href="#" role="button" title="Toggle Fullscreen">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<style>
/* Navbar Enhancements */
.main-header.navbar {
    border-bottom: 12px solid #dee2e6;
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.95) !important;
}

/* Sidebar Toggle */
.sidebar-toggle {
    transition: all 0.3s ease;
}

.sidebar-toggle:hover {
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

/* Notification Badge Animation */
.notification-badge {
    animation: none;
    font-size: 0.7rem;
    min-width: 18px;
    height: 18px;
    line-height: 18px;
    border-radius: 50%;
    font-weight: 600;
}

.notification-badge.pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* Notification Dropdown */
.notification-dropdown-menu {
    width: 350px;
    max-height: 400px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    border-radius: 8px;
    overflow: hidden;
}

.notification-dropdown-menu .dropdown-header {
    background: #343a40;
    color: white;
    font-weight: 600;
    padding: 15px 20px;
    border-bottom: none;
    font-size: 0.9rem;
}

.dropdown-body {
    max-height: 280px;
    overflow-y: auto;
    padding: 0;
}

.dropdown-body::-webkit-scrollbar {
    width: 4px;
}

.dropdown-body::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.dropdown-body::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

/* Notification Items */
.notification-item {
    padding: 0;
    border: none;
    transition: all 0.3s ease;
    position: relative;
}

.notification-item:hover {
    background-color: #f8f9fa;
    transform: translateX(2px);
}

.notification-content {
    display: flex;
    align-items: flex-start;
    padding: 15px 20px;
    gap: 12px;
}

.notification-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

.notification-text {
    flex: 1;
    min-width: 0;
}

.notification-title {
    font-size: 0.85rem;
    font-weight: 600;
    margin: 0 0 4px 0;
    color: #2c3e50;
    line-height: 1.3;
}

.notification-message {
    font-size: 0.75rem;
    color: #6c757d;
    margin: 0 0 6px 0;
    line-height: 1.4;
}

.notification-time {
    font-size: 0.7rem;
    color: #95a5a6;
    display: flex;
    align-items: center;
}

.notification-status {
    flex-shrink: 0;
    display: flex;
    align-items: center;
}

.unread-dot {
    width: 8px;
    height: 8px;
    background-color: #e74c3c;
    border-radius: 50%;
    display: block;
}

/* Empty State */
.empty-notifications {
    text-align: center;
    padding: 40px 20px;
    color: #95a5a6;
}

.empty-notifications i {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.empty-notifications p {
    margin: 0;
    font-size: 0.85rem;
}

/* Dropdown Footer */
.dropdown-footer {
    padding: 15px 20px;
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
}

.dropdown-footer .btn {
    font-size: 0.8rem;
    padding: 8px 16px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.dropdown-footer .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Fullscreen Toggle */
.fullscreen-toggle {
    transition: all 0.3s ease;
}

.fullscreen-toggle:hover {
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .notification-dropdown-menu {
        width: 300px;
        right: -50px !important;
    }
    
    .notification-content {
        padding: 12px 15px;
        gap: 10px;
    }
    
    .notification-icon {
        width: 35px;
        height: 35px;
        font-size: 0.8rem;
    }
}

/* Loading State */
.notification-item.loading {
    opacity: 0.6;
    pointer-events: none;
}

.notification-item.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    right: 20px;
    width: 16px;
    height: 16px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    transform: translateY(-50%);
}

@keyframes spin {
    0% { transform: translateY(-50%) rotate(0deg); }
    100% { transform: translateY(-50%) rotate(360deg); }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const notificationItems = document.querySelectorAll('#notificationDropdownMenu .notification-item');
    const badge = document.querySelector('.notification-badge');
    const countSpan = document.querySelector('.notification-count');
    
    // Add click handlers to notification items
    notificationItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const notificationId = this.getAttribute('data-id');
            const url = `/notifications/${notificationId}/read`;
            const targetUrl = this.getAttribute('href');
            
            // Add loading state
            this.classList.add('loading');
            
            // Mark notification as read
            fetch(url, {
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
                    // Update UI
                    updateNotificationCount();
                    this.style.opacity = '0.5';
                    this.querySelector('.unread-dot').style.display = 'none';
                    
                    // Navigate after a short delay
                    setTimeout(() => {
                        if (targetUrl && targetUrl !== '#') {
                            window.location.href = targetUrl;
                        }
                    }, 300);
                } else {
                    // Navigate anyway if marking as read fails
                    if (targetUrl && targetUrl !== '#') {
                        window.location.href = targetUrl;
                    }
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
                // Navigate anyway on error
                if (targetUrl && targetUrl !== '#') {
                    window.location.href = targetUrl;
                }
            })
            .finally(() => {
                this.classList.remove('loading');
            });
        });
    });
    
    // Function to update notification count
    function updateNotificationCount() {
        let currentCount = parseInt(countSpan.textContent) || 0;
        currentCount = Math.max(0, currentCount - 1);
        
        countSpan.textContent = currentCount;
        
        if (badge) {
            if (currentCount === 0) {
                badge.style.display = 'none';
                badge.classList.remove('pulse');
            } else {
                badge.textContent = currentCount > 99 ? '99+' : currentCount;
            }
        }
    }
    
    // Auto-refresh notifications every 30 seconds
    setInterval(function() {
        fetch('/notifications/count', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.count !== undefined) {
                const currentCount = parseInt(countSpan.textContent) || 0;
                if (data.count > currentCount) {
                    // New notifications arrived
                    countSpan.textContent = data.count;
                    if (badge) {
                        badge.textContent = data.count > 99 ? '99+' : data.count;
                        badge.style.display = 'inline-block';
                        badge.classList.add('pulse');
                    }
                }
            }
        })
        .catch(error => console.error('Error checking notifications:', error));
    }, 30000);
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.querySelector('.notification-dropdown');
        if (!dropdown.contains(e.target)) {
            const dropdownMenu = document.querySelector('#notificationDropdownMenu');
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
            }
        }
    });
});
</script>
@endpush
