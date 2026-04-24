<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leader Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="admin-layout"> <!-- Tái sử dụng CSS của admin layout -->
        <aside class="admin-sidebar" style="background-color: #4a148c;"> <!-- Màu khác xíu để phân biệt -->
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
                        Dashboard Leader
                    </a>
                </li>
                <li>
                    <a href="{{ route('leader.clubs.info') }}" class="{{ Route::is('leader.clubs.info') ? 'active' : '' }}">
                        Quản lý Câu lạc bộ
                    </a>
                </li>
                <li>
                    <a href="{{ route('leader.members.index') }}" class="{{ Route::is('leader.members.index') ? 'active' : '' }}">
                        Quản lý Thành viên (Duyệt Đăng ký)
                    </a>
                </li>
                <li>
                    <a href="{{ route('leader.events.index') }}" class="{{ Route::is('leader.events.index') ? 'active' : '' }}">
                        Quản lý Sự kiện
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
