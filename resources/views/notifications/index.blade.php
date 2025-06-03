@extends('layouts.app')

@section('main-content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0" style="padding: 1.5rem 1.5rem 1rem 1.5rem;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-4" style="margin-bottom: 0.5rem;">
                    <h3 class="card-title m-0 fs-4 fw-semibold text-primary">
                        <i class="fas fa-bell me-2"></i>Notifikasi
                    </h3>
                    <div class="card-tools">
                        @if(auth()->user()->unreadNotifications->count() > 0)
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary mark-all-read">
                                <i class="fas fa-check-double me-1"></i> Tandai Semua Dibaca
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($notifications->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-bell-slash fa-4x mb-3 text-secondary opacity-50"></i>
                        <p class="fs-5">Tidak ada notifikasi saat ini</p>
                    </div>
                    @else
                    <div class="list-group list-group-flush">
                        @foreach($notifications as $notification)
                        @php
                            $actionUrl = $notification->data['action_url'] ?? null;
                        @endphp
                        <div class="notification-list-item list-group-item list-group-item-action {{ $notification->read_at ? '' : 'list-group-item-info bg-opacity-25' }} border-start-0 border-end-0"
                             style="margin-bottom: 1rem; border-radius: 0.5rem; padding: 1.25rem 1.5rem;"
                             data-id="{{ $notification->id }}"
                             @if($actionUrl) data-url="{{ $actionUrl }}" style="cursor:pointer;" @endif>
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="me-3 flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="mb-0 fw-semibold">
                                            {{ $notification->data['title'] ?? '-' }}
                                        </h5>
                                        @if(!$notification->read_at)
                                        <span class="badge bg-primary ms-2">Baru</span>
                                        @endif
                                    </div>
                                    <p class="mb-2 text-dark" style="font-size: 1.05rem;">{{ $notification->data['message'] ?? '-' }}</p>
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="fas fa-clock me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="btn-group">
                                    @if(!$notification->read_at)
                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary mark-as-read" data-bs-toggle="tooltip" title="Tandai sudah dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger delete-notification" data-bs-toggle="tooltip" title="Hapus notifikasi">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center py-3">
                        {{ $notifications->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // AJAX for mark as read
    $('.notification-list-item .mark-as-read').click(function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const notificationItem = $(this).closest('.notification-item');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                notificationItem.removeClass('list-group-item-info');
                notificationItem.find('.badge').remove();
                updateNotificationCount();
            }
        });
    });

    // AJAX for mark all as read
    $('.mark-all-read').click(function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('.notification-item').removeClass('list-group-item-info');
                $('.notification-item .badge').remove();
                updateNotificationCount();
            }
        });
    });

    // AJAX for delete notification
    $('.delete-notification').click(function(e) {
        e.preventDefault();
        const button = $(this);
        const notificationItem = button.closest('.notification-item');
        
        Swal.fire({
            title: 'Hapus Notifikasi?',
            text: 'Notifikasi yang dihapus tidak dapat dikembalikan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = button.closest('form');
                
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        notificationItem.fadeOut(300, function() {
                            $(this).remove();
                            if ($('.notification-item').length === 0) {
                                location.reload();
                            }
                            updateNotificationCount();
                        });
                    }
                });
            }
        });
    });

    // Add this inside document.addEventListener('DOMContentLoaded', function() { ... });
    $('.notification-list-item').on('click', function(e) {
        // Prevent click if clicking on a button or link inside the notification
        if ($(e.target).closest('button, a, form').length) return;

        var url = $(this).data('url');
        var id = $(this).data('id');
        if (!url) return;

        // Mark as read via AJAX, then redirect
        $.ajax({
            url: '/notifications/' + id + '/read',
            method: 'POST',
            data: {_token: '{{ csrf_token() }}'},
            complete: function() {
                window.location.href = url;
            }
        });
    });

    function updateNotificationCount() {
        $.get('/notifications/count', function(data) {
            const count = data.count;
            const badge = $('.notification-badge');
            
            if (count > 0) {
                badge.text(count).show();
            } else {
                badge.hide();
            }
        });
    }
});
</script>
@endpush
@endsection
