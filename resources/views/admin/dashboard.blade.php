@extends('layouts.admin')

@section('content')
    <div class="page-header" style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h2 style="font-weight: 800; color: #1e1b4b; margin: 0; font-size: 2rem; letter-spacing: -1px;">QUẢN TRỊ HỆ THỐNG</h2>
            <p style="color: #64748b; margin-top: 0.5rem; font-size: 1.1rem;">Báo cáo tổng quan về hoạt động của toàn bộ hệ thống.</p>
        </div>
        <div style="background: white; padding: 0.75rem 1.25rem; border-radius: 12px; border: 1px solid #e2e8f0; font-weight: 600; color: #64748b; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-clock" style="color: #6366f1;"></i> {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <!-- Hàng 1: Thống kê số lượng CLB và Thành viên -->
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
        <!-- Card CLB -->
        <div class="stat-card" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; padding: 1.5rem; border-radius: 1.5rem; box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4); position: relative; overflow: hidden;">
            <div style="position: absolute; right: -10px; top: -10px; opacity: 0.1; font-size: 8rem; font-weight: 900;"><i class="fas fa-users-cog"></i></div>
            <h4 style="font-weight: 600; font-size: 1.1rem; margin-bottom: 1rem;">CÂU LẠC BỘ</h4>
            <div style="display: flex; align-items: baseline; gap: 10px;">
                <span style="font-size: 2.5rem; font-weight: 800;">{{ $totalClubs }}</span>
                <span style="font-size: 0.9rem; opacity: 0.8;">tổng cộng</span>
            </div>
            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); display: flex; gap: 1.5rem;">
               <div>
                    <strong style="display: block;">{{ $approvedClubs }}</strong>
                    <span style="font-size: 0.8rem; opacity: 0.8;">Đã duyệt</span>
               </div>
               <div>
                    <strong style="display: block;">{{ $pendingClubs }}</strong>
                    <span style="font-size: 0.8rem; opacity: 0.8;">Chờ duyệt</span>
               </div>
            </div>
        </div>

        <!-- Card Thành viên -->
        <div class="stat-card" style="background: linear-gradient(135deg, #ec4899 0%, #d946ef 100%); color: white; padding: 1.5rem; border-radius: 1.5rem; box-shadow: 0 10px 25px -5px rgba(217, 70, 239, 0.4); position: relative; overflow: hidden;">
            <div style="position: absolute; right: -10px; top: -10px; opacity: 0.1; font-size: 8rem; font-weight: 900;"><i class="fas fa-user-friends"></i></div>
            <h4 style="font-weight: 600; font-size: 1.1rem; margin-bottom: 1rem;">NGƯỜI DÙNG</h4>
            <div style="display: flex; align-items: baseline; gap: 10px;">
                <span style="font-size: 2.5rem; font-weight: 800;">{{ $totalUsers }}</span>
                <span style="font-size: 0.9rem; opacity: 0.8;">tài khoản</span>
            </div>
            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); display: flex; gap: 1.5rem;">
               <div>
                    <strong style="display: block;">{{ $totalLeaders }}</strong>
                    <span style="font-size: 0.8rem; opacity: 0.8;">Chủ nhiệm</span>
               </div>
               <div>
                    <strong style="display: block;">{{ $totalMembers }}</strong>
                    <span style="font-size: 0.8rem; opacity: 0.8;">Thành viên</span>
               </div>
            </div>
        </div>

        <!-- Card Hoạt động -->
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 1.5rem; border-radius: 1.5rem; box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.4); position: relative; overflow: hidden;">
            <div style="position: absolute; right: -10px; top: -10px; opacity: 0.1; font-size: 8rem; font-weight: 900;"><i class="fas fa-calendar-alt"></i></div>
            <h4 style="font-weight: 600; font-size: 1.1rem; margin-bottom: 1rem;">SỰ KIỆN</h4>
            <div style="display: flex; align-items: baseline; gap: 10px;">
                <span style="font-size: 2.5rem; font-weight: 800;">{{ $totalEvents }}</span>
                <span style="font-size: 0.9rem; opacity: 0.8;">tổng số</span>
            </div>
             <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); display: flex; gap: 1.5rem;">
               <div>
                    <strong style="display: block;">{{ $upcomingEvents }}</strong>
                    <span style="font-size: 0.8rem; opacity: 0.8;">Sắp diễn ra</span>
               </div>
               <div>
                    <strong style="display: block;">{{ $activeClubMembers }}</strong>
                    <span style="font-size: 0.8rem; opacity: 0.8;">Lượt tham gia CLB</span>
               </div>
            </div>
        </div>
    </div>

    <!-- Panel Điều hướng nhanh & Quản lý -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <div class="section-card" style="background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
            <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 1.5rem;">TRUY CẬP NHANH</h3>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <!-- Link Quản lý người dùng -->
                <a href="{{ route('admin.users.index') }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 1rem; padding: 1rem; border-radius: 1rem; background: #f8fafc; transition: all 0.3s ease; border: 1px solid #f1f5f9;" 
                   onmouseover="this.style.transform='translateX(10px)'; this.style.borderColor='#cbd5e1'; this.style.background='#fff'" 
                   onmouseout="this.style.transform='translateX(0)'; this.style.borderColor='#f1f5f9'; this.style.background='#f8fafc'">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                         <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h5 style="margin: 0; font-weight: 600; color: #334155;">Quản lý người dùng</h5>
                        <p style="margin: 0; font-size: 0.85rem; color: #64748b;">Xem danh sách, thêm, khóa tài khoản</p>
                    </div>
                </a>

                <!-- Link Quản lý CLB -->
                <a href="{{ route('admin.clubs.index') }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 1rem; padding: 1rem; border-radius: 1rem; background: #f8fafc; transition: all 0.3s ease; border: 1px solid #f1f5f9; position: relative;"
                   onmouseover="this.style.transform='translateX(10px)'; this.style.borderColor='#cbd5e1'; this.style.background='#fff'" 
                   onmouseout="this.style.transform='translateX(0)'; this.style.borderColor='#f1f5f9'; this.style.background='#f8fafc'">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #e0e7ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                         <i class="fas fa-university"></i>
                    </div>
                    <div>
                        <h5 style="margin: 0; font-weight: 600; color: #334155;">Quản lý Câu lạc bộ</h5>
                        <p style="margin: 0; font-size: 0.85rem; color: #64748b;">Duyệt yêu cầu lập CLB, chỉ định Leader</p>
                    </div>
                    @if($pendingClubsCount > 0)
                        <span style="position: absolute; top: 1rem; right: 1rem; background: #ef4444; color: white; font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 1rem; animation: pulse 2s infinite;">
                            {{ $pendingClubsCount }} MỚI
                        </span>
                    @endif
                </a>

                <!-- Link Quản lý Sự kiện -->
                <a href="{{ route('admin.events.index') }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 1rem; padding: 1rem; border-radius: 1rem; background: #f8fafc; transition: all 0.3s ease; border: 1px solid #f1f5f9;"
                   onmouseover="this.style.transform='translateX(10px)'; this.style.borderColor='#cbd5e1'; this.style.background='#fff'" 
                   onmouseout="this.style.transform='translateX(0)'; this.style.borderColor='#f1f5f9'; this.style.background='#f8fafc'">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #dcfce7; color: #22c55e; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                         <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h5 style="margin: 0; font-weight: 600; color: #334155;">Quản lý sự kiện</h5>
                        <p style="margin: 0; font-size: 0.85rem; color: #64748b;">Giám sát các hoạt động toàn trường</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Phần thông báo/Hoạt động gần đây -->
        <div class="section-card" style="background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-weight: 700; color: #1e293b; margin: 0;">BÁO CÁO NHANH</h3>
                <span style="font-size: 0.8rem; color: #64748b; background: #f1f5f9; padding: 0.2rem 0.6rem; border-radius: 0.5rem;">Tự động cập nhật</span>
            </div>

            <div style="padding: 1.5rem; background: #fdf2f8; border-radius: 1rem; border: 1px dashed #f9a8d4; margin-bottom: 1rem;">
                <p style="margin: 0; color: #db2777; font-size: 0.9rem; line-height: 1.5;">
                    💡 <strong>Tổng hợp:</strong> Hiện tại hệ thống đang vận hành ổn định với <strong>{{ $totalClubs }}</strong> CLB và <strong>{{ $totalUsers }}</strong> người dùng tham gia. Đã có <strong>{{ $activeClubMembers }}</strong> lượt đăng ký tham gia CLB được phê duyệt.
                </p>
            </div>

            <div style="overflow: hidden; border-radius: 1rem; border: 1px solid #e2e8f0;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                    <tr style="background: #f8fafc;">
                        <th style="padding: 1rem; text-align: left; color: #64748b; font-weight: 600;">Thông số</th>
                        <th style="padding: 1rem; text-align: right; color: #64748b; font-weight: 600;">Số lượng</th>
                    </tr>
                    <tr>
                        <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9;">Tài khoản Leader</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 700;">{{ $totalLeaders }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9;">Tài khoản Member</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 700;">{{ $totalMembers }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9;">Yêu cầu CLB mới</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; text-align: right; color: #ef4444; font-weight: 700;">{{ $pendingClubs }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 1rem;">Sự kiện đang tới</td>
                        <td style="padding: 1rem; text-align: right; color: #10b981; font-weight: 700;">{{ $upcomingEvents }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>



    <style>
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
    </style>
@endsection
