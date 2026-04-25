<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang thành viên</title>

    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/member.css') }}">
</head>
<body>
    <header class="member-navbar">
        <div class="member-brand">Club<span>Space</span></div>

        <nav class="member-nav">
            <a href="{{ route('member.home') }}" class="{{ request()->routeIs('member.home') ? 'active' : '' }}">Trang chủ</a>
            <a href="{{ route('member.clubs.index') }}" class="{{ request()->routeIs('member.clubs.index') ? 'active' : '' }}">Câu lạc bộ</a>
            <a href="{{ route('member.myclubs.index') }}" class="{{ request()->routeIs('member.myclubs.*') ? 'active' : '' }}">Câu lạc bộ của tôi</a>
            <a href="{{ route('member.events.index') }}" class="{{ request()->routeIs('member.events.*') ? 'active' : '' }}">Sự kiện</a>
            <a href="{{ route('member.profile.index') }}" class="{{ request()->routeIs('member.profile.*') ? 'active' : '' }}">Hồ sơ</a>
        </nav>

        <div class="member-right">
            <a href="{{ route('member.notifications.index') }}" class="notification-icon" style="margin-right: 15px; position: relative; color: #555; text-decoration: none; font-size: 1.2rem;">
                <i class="fas fa-bell"></i>
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="badge" style="position: absolute; top: -5px; right: -10px; background-color: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; font-weight: bold;">
                        {{ Auth::user()->unreadNotifications->count() }}
                    </span>
                @endif
            </a>
            <div class="member-user">Xin chào, {{ Auth::user()->name }}</div>

            <form action="{{ route('logout') }}" method="POST" class="member-logout">
                @csrf
                <button type="submit">Đăng xuất</button>
            </form>
        </div>
    </header>

    <main class="member-container">
        @yield('content')
    </main>
</body>
</html>