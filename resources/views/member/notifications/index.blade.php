@extends('layouts.member')

@section('content')
<div class="noti-container">
    <div class="noti-page-header">
        <h1 class="noti-page-title">
            <i class="fas fa-bell"></i>
            Thông báo của bạn
        </h1>
        <div style="background: #eff6ff; color: #2563eb; padding: 6px 14px; border-radius: 999px; font-size: 14px; font-weight: 600;">
            Tổng số: {{ $notifications->total() }}
        </div>
    </div>

    @if(session('success'))
        <div class="alert-box" style="border-left-color: #10b981;">
            <i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($notifications->isEmpty())
        <div class="noti-empty">
            <div class="noti-empty-icon">
                <i class="fas fa-bell-slash"></i>
            </div>
            <div class="noti-empty-text">Bạn chưa có thông báo nào mới.</div>
            <p style="color: #94a3b8; font-size: 14px; margin-top: 10px;">Chúng tôi sẽ thông báo cho bạn khi có tin tức mới!</p>
        </div>
    @else
        <div class="noti-list">
            @foreach($notifications as $notification)
                @php
                    $isUnread = is_null($notification->read_at);
                    $iconClass = 'noti-icon-default';
                    $icon = 'fa-info-circle';
                    
                    $message = $notification->data['message'] ?? 'Thông báo mới';
                    
                    if (str_contains(strtolower($message), 'sự kiện')) {
                        $iconClass = 'noti-icon-event';
                        $icon = 'fa-calendar-alt';
                    } elseif (str_contains(strtolower($message), 'clb') || str_contains(strtolower($message), 'câu lạc bộ')) {
                        $iconClass = 'noti-icon-club';
                        $icon = 'fa-users';
                    }
                @endphp

                <div class="noti-card">
                    @if($isUnread)
                        <div class="noti-badge-unread"></div>
                    @endif

                    <div class="noti-icon-wrapper {{ $iconClass }}">
                        <i class="fas {{ $icon }}"></i>
                    </div>

                    <div class="noti-content">
                        <div class="noti-message">
                            {{ $message }}
                        </div>
                        <div class="noti-time">
                            <i class="far fa-clock"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                        
                        @if(isset($notification->data['link']))
                            <a href="{{ route('member.notifications.read', $notification->id) }}" class="noti-link">
                                Xem chi tiết <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
            
            <div style="margin-top: 24px;">
                {{ $notifications->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
