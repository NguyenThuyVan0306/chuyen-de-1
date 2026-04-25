<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Purple System</title>

    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        :root {
            --admin-primary: #4338ca;
            --admin-secondary: #1e1b4b;
            --admin-accent: #6366f1;
            --admin-bg: #f8fafc;
            --admin-sidebar-w: 280px;
        }

        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: var(--admin-bg);
            margin: 0;
            padding: 0;
        }

        .admin-sidebar {
            width: var(--admin-sidebar-w) !important;
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%) !important;
            border-right: none !important;
            padding: 0 !important;
            color: #e2e8f0 !important;
        }

        .admin-logo {
            padding: 2rem !important;
            font-size: 1.5rem !important;
            font-weight: 800 !important;
            letter-spacing: -0.5px !important;
            color: white !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            border-bottom: 1px solid rgba(255,255,255,0.05) !important;
        }

        .admin-logo i {
            color: var(--admin-accent);
        }

        .admin-user {
            background: rgba(255,255,255,0.03) !important;
            margin: 1.5rem !important;
            border-radius: 1rem !important;
            padding: 1.25rem !important;
            border: 1px solid rgba(255,255,255,0.05) !important;
        }

        .admin-user-avatar {
            width: 45px !important;
            height: 45px !important;
            background: var(--admin-accent) !important;
            border: 2px solid rgba(255,255,255,0.2) !important;
        }

        .admin-user-info h4 {
            color: white !important;
            font-size: 0.95rem !important;
            margin-bottom: 2px !important;
        }

        .admin-user-info p {
            color: #94a3b8 !important;
            font-size: 0.8rem !important;
        }

        .admin-menu {
            padding: 0 1rem !important;
        }

        .admin-menu li {
            list-style: none !important;
            margin-bottom: 0.5rem !important;
        }

        .admin-menu a {
            color: #94a3b8 !important;
            padding: 0.85rem 1.25rem !important;
            border-radius: 0.75rem !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            text-decoration: none !important;
            font-weight: 500 !important;
            font-size: 0.95rem !important;
        }

        .admin-menu a i {
            width: 20px !important;
            text-align: center !important;
        }

        .admin-menu a:hover {
            color: white !important;
            background: rgba(255,255,255,0.05) !important;
        }

        .admin-menu a.active {
            background: var(--admin-accent) !important;
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3) !important;
        }

        .admin-topbar {
            background: white !important;
            border-bottom: 1px solid #f1f5f9 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
        }

        .admin-topbar h2 {
            font-weight: 700 !important;
            color: var(--admin-secondary) !important;
            font-size: 1.25rem !important;
        }

        .logout-btn {
            background: #fff !important;
            color: #dc2626 !important;
            border: 1px solid #fecdd3 !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            transition: all 0.2s !important;
        }

        .logout-btn:hover {
            background: #fee2e2 !important;
            transform: translateY(-1px) !important;
        }

        /* Global UI Standard */
        input, select, textarea {
            box-sizing: border-box !important;
        }

        .alert-box {
            padding: 1rem 1.5rem !important;
            border-radius: 12px !important;
            margin-bottom: 1.5rem !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            font-weight: 500 !important;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05) !important;
        }

        .alert-success {
            background: #f0fdf4 !important;
            color: #166534 !important;
            border: 1px solid #bbf7d0 !important;
        }

        .alert-error {
            background: #fef2f2 !important;
            color: #991b1b !important;
            border: 1px solid #fecdd3 !important;
        }

        /* Premium Pagination Styles */
        .pagination, nav ul {
            display: flex !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 2rem 0 !important;
            gap: 8px !important;
            justify-content: center !important;
            width: 100% !important;
        }

        .pagination li span,
        .pagination li a,
        nav ul li span,
        nav ul li a {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            border-radius: 10px !important;
            text-decoration: none !important;
            font-weight: 700 !important;
            font-size: 0.9rem !important;
            transition: all 0.2s !important;
            border: 1px solid #e2e8f0 !important;
            background: white !important;
            color: #64748b !important;
        }

        .pagination li a:hover, nav ul li a:hover {
            background: var(--admin-accent) !important;
            color: white !important;
            transform: translateY(-2px) !important;
            border-color: var(--admin-accent) !important;
        }

        .pagination li.active span,
        .pagination li[aria-current="page"] span,
        nav ul li.active span,
        nav ul li[aria-current="page"] span {
            background: var(--admin-accent) !important;
            color: white !important;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3) !important;
            border-color: var(--admin-accent) !important;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar" style="position: fixed; height: 100vh;">
            <div class="admin-logo">
                <i class="fas fa-shield-halved"></i> Admin<span>Panel</span>
            </div>

            <div class="admin-user">
                <div class="admin-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="admin-user-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>Quản trị viên hệ thống</p>
                </div>
            </div>

            <ul class="admin-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i> Quản lý Người dùng
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.clubs.index') }}" class="{{ request()->routeIs('admin.clubs.*') ? 'active' : '' }}">
                        <i class="fas fa-university"></i> Quản lý Câu lạc bộ
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Quản lý Sự kiện
                    </a>
                </li>
                <li style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.05);">
                    <a href="{{ route('admin.profile.index') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-cog"></i> Hồ sơ cá nhân
                    </a>
                </li>
            </ul>
        </aside>

        <main class="admin-main" style="margin-left: var(--admin-sidebar-w);">
            <div class="admin-topbar">
                <h2>Hệ thống quản lý CLB</h2>

                <div class="admin-topbar-right">
                    <div class="admin-topbar-user" style="color: #64748b; font-weight: 500;">
                        Quản trị viên: <strong style="color: #1e1b4b;">{{ Auth::user()->name }}</strong>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>

            <div class="admin-content" style="padding: 2rem;">
                @if(session('success'))
                    <div class="alert-box alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-box alert-error">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
