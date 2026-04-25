<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Câu lạc bộ Sinh viên</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            line-height: 1.6;
        }

        /* Navbar */
        nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid #e2e8f0;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-login {
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-login:hover {
            background: #eef2ff;
        }

        .btn-register {
            background: var(--primary);
            color: white;
        }

        .btn-register:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            padding: 4rem 5%;
            text-align: center;
            background: linear-gradient(135deg, #fff 0%, #f1f5f9 100%);
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #4f46e5, #9333ea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            color: var(--text-muted);
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }

        /* Club Grid */
        .container {
            padding: 4rem 5%;
        }

        .section-title {
            margin-bottom: 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .club-card {
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
        }

        .club-card:hover {
            transform: translateY(-10px);
            shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .club-image {
            height: 180px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .club-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .club-image i {
            font-size: 4rem;
            color: #cbd5e1;
        }

        .club-content {
            padding: 1.5rem;
            flex-grow: 1;
        }

        .club-name {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        .club-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 1.5rem;
            height: 2.8rem;
        }

        .club-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
        }

        .members-count {
            font-size: 0.85rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-view {
            color: var(--primary);
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }

        /* Footer */
        footer {
            background: #1e293b;
            color: white;
            padding: 3rem 5%;
            text-align: center;
            margin-top: 4rem;
        }

        .pagination {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }

        .pagination nav {
            background: transparent;
            border: none;
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <nav>
        <a href="/" class="logo">
            <i class="fas fa-users-viewfinder"></i>
            ClubHub
        </a>
        <div class="nav-links">
            @auth
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-register">Dashboard Admin</a>
                @elseif(Auth::user()->role == 'leader')
                    <a href="{{ route('leader.home') }}" class="btn btn-register">Dashboard Leader</a>
                @else
                    <a href="{{ route('member.home') }}" class="btn btn-register">Trang cá nhân</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-login">Đăng nhập</a>
                <a href="{{ route('register') }}" class="btn btn-register">Đăng ký ngay</a>
            @endauth
        </div>
    </nav>

    <section class="hero">
        <h1>Khám phá Đam mê tại ClubHub</h1>
        <p>Hệ thống kết nối sinh viên với các câu lạc bộ năng động, sáng tạo và chuyên nghiệp nhất trong trường.</p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="{{ route('register') }}" class="btn btn-register" style="padding: 1rem 2rem;">Bắt đầu ngay</a>
            <a href="#clubs" class="btn btn-login" style="padding: 1rem 2rem;">Xem danh sách CLB</a>
        </div>
    </section>

    <div class="container" id="clubs">
        <div class="section-title">
            <h2>Các Câu lạc bộ nổi bật</h2>
            <p style="color: var(--text-muted)">Khám phá cộng đồng phù hợp với bạn</p>
        </div>

        <div class="grid">
            @foreach($clubs as $club)
                <div class="club-card">
                    <div class="club-image">
                        @if($club->image)
                            <img src="{{ asset('storage/' . $club->image) }}" alt="{{ $club->name }}">
                        @else
                            <i class="fas fa-users"></i>
                        @endif
                    </div>
                    <div class="club-content">
                        <h3 class="club-name">{{ $club->name }}</h3>
                        <p class="club-desc">{{ $club->description ?? 'Chưa có mô tả cho câu lạc bộ này.' }}</p>
                        <div class="club-footer">
                            <span class="members-count">
                                <i class="fas fa-user-friends"></i>
                                {{ $club->approved_count }} thành viên
                            </span>
                            <a href="{{ route('login') }}" class="btn-view">
                                Chi tiết <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $clubs->links() }}
        </div>
    </div>

    <footer>
        <p>&copy; 2024 ClubHub - Hệ thống Quản lý Câu lạc bộ Sinh viên. All rights reserved.</p>
    </footer>

</body>
</html>
