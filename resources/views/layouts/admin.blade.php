<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-logo">Purple</div>

            <div class="admin-user">
                <div class="admin-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="admin-user-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>Quản trị viên</p>
                </div>
            </div>

           <ul class="admin-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line" style="margin-right: 10px;"></i> Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield" style="margin-right: 10px;"></i> Quản lý người dùng
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.clubs.index') }}"
                    class="{{ request()->routeIs('admin.clubs.*') ? 'active' : '' }}">
                        <i class="fas fa-university" style="margin-right: 10px;"></i> Quản lý câu lạc bộ
                    </a>
                </li>


                <li>
                    <a href="{{ route('admin.events.index') }}"
                    class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt" style="margin-right: 10px;"></i> Quản lý sự kiện
                    </a>
                </li>

            </ul>
        </aside>

        <main class="admin-main">
            <div class="admin-topbar">
                <h2></h2>

                <div class="admin-topbar-right">
                    <div class="admin-topbar-user">
                        Xin chào, {{ Auth::user()->name }}
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">Đăng xuất</button>
                    </form>
                </div>
            </div>

            <div class="admin-content">
                @if(session('success'))
                    <div class="alert-box">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert-box">{{ session('error') }}</div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>