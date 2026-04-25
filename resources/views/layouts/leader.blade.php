<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leader Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .admin-sidebar {
            background: linear-gradient(180deg, #4a148c 0%, #311b92 100%) !important;
            border-right: none !important;
        }
        .admin-logo {
            color: #fff !important;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 15px;
        }
        .admin-logo span {
            color: #d1c4e9;
        }
        .admin-user {
            background: rgba(255,255,255,0.1) !important;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .admin-user-info h4 {
            color: #fff !important;
        }
        .admin-user-info p {
            color: #b39ddb !important;
        }
        .admin-menu a {
            color: rgba(255,255,255,0.7) !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .admin-menu a i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        .admin-menu a:hover {
            background: rgba(255,255,255,0.1) !important;
            color: #fff !important;
        }
        .admin-menu a.active {
            background: #fff !important;
            color: #4a148c !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Global Form Fixes */
        input, select, textarea {
            box-sizing: border-box !important;
        }

        /* Premium Pagination Styles */
        .pagination, nav ul {
            display: flex !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            gap: 8px !important;
            justify-content: center !important;
            width: 100% !important;
        }

        .pagination li, nav ul li {
            list-style: none !important;
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
            border: 1px solid #f1f5f9 !important;
        }

        .pagination li a, nav ul li a {
            color: #64748b !important;
            background: #f8fafc !important;
        }

        .pagination li a:hover, nav ul li a:hover {
            background: #8d5cf6 !important;
            color: white !important;
            transform: translateY(-2px) !important;
            border-color: #8d5cf6 !important;
        }

        .pagination li.active span,
        .pagination li[aria-current="page"] span,
        nav ul li.active span,
        nav ul li[aria-current="page"] span {
            background: #8d5cf6 !important;
            color: white !important;
            box-shadow: 0 4px 10px rgba(141, 92, 246, 0.3) !important;
            border-color: #8d5cf6 !important;
        }

        .pagination li.disabled span,
        nav ul li.disabled span {
            color: #cbd5e1 !important;
            background: #f8fafc !important;
            cursor: not-allowed !important;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-logo">Leader<span>Panel</span></div>

            <div class="admin-user">
                <div class="admin-user-avatar">
                     {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="admin-user-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>Trưởng câu lạc bộ</p>
                </div>
            </div>

            <ul class="admin-menu">
                <li>
                    <a href="{{ route('leader.home') }}" class="{{ Route::is('leader.home') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i> Dashboard Leader
                    </a>
                </li>
                <li>
                    <a href="{{ route('leader.clubs.info') }}" class="{{ Route::is('leader.clubs.info') ? 'active' : '' }}">
                        <i class="fas fa-university"></i> Quản lý Câu lạc bộ
                    </a>
                </li>
                <li>
                    <a href="{{ route('leader.members.index') }}" class="{{ Route::is('leader.members.index') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Quản lý Thành viên
                    </a>
                </li>
                <li>
                    <a href="{{ route('leader.events.index') }}" class="{{ Route::is('leader.events.index') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Quản lý Sự kiện
                    </a>
                </li>
                <li style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <a href="{{ route('leader.profile.index') }}" class="{{ Route::is('leader.profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-cog"></i> Hồ sơ cá nhân
                    </a>
                </li>
            </ul>
        </aside>

        <main class="admin-main">
            <div class="admin-topbar">
                <h2>Leader Dashboard</h2>

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
                <!-- Success Alert -->
                @if(session('success'))
                    <div class="alert-box" style="background: #22c55e; color: white; padding: 15px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.2); display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Error Alert -->
                @if(session('error'))
                    <div class="alert-box" style="background: #ef4444; color: white; padding: 15px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2); display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    </div>
                @endif

                <!-- Validation Errors Alert -->
                @if($errors->any())
                    <div class="alert-box" style="background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; padding: 15px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 6px -1px rgba(225, 29, 72, 0.1);">
                        <div style="font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-times-circle"></i> Đã xảy ra lỗi! Vui lòng kiểm tra lại:
                        </div>
                        <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
