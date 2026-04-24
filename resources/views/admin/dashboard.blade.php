@extends('layouts.admin')

@section('content')
    <div class="page-header" style="margin-bottom: 2rem;">
        <h2 style="font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">QUẢN TRỊ HỆ THỐNG</h2>
        <p style="color: #64748b;">Chào mừng quay trở lại, Admin! Dưới đây là báo cáo tổng quan về toàn bộ hệ thống Câu lạc bộ và Thành viên.</p>
    </div>

    <!-- Hàng 1: Thống kê số lượng CLB và Thành viên -->
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
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

    <!-- NEW SECTION: Quick Approval for Clubs -->
    <div class="section-card" style="background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 15px 30px -10px rgba(0,0,0,0.1); margin-top: 2rem; border: 1px solid #e0e7ff;">
        <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-weight: 800; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-clipboard-check" style="color: #6366f1;"></i>
                📋 YÊU CẦU LẬP CLB MỚI (DUYỆT NHANH)
            </h3>
            <a href="{{ route('admin.clubs.index') }}" style="color: #6366f1; font-weight: 700; text-decoration: none; font-size: 0.9rem; border-bottom: 2px solid transparent; transition: 0.2s;" onmouseover="this.style.borderBottomColor='#6366f1'">Xem tất cả &gt;</a>
        </div>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.75rem;">
                <thead>
                    <tr style="text-align: left;">
                        <th style="padding: 1rem; color: #64748b; font-weight: 600; border-bottom: 2px solid #f1f5f9;">Tên Câu lạc bộ</th>
                        <th style="padding: 1rem; color: #64748b; font-weight: 600; border-bottom: 2px solid #f1f5f9;">Người gửi (Leader)</th>
                        <th style="padding: 1rem; color: #64748b; font-weight: 600; border-bottom: 2px solid #f1f5f9;">Ngày gửi</th>
                        <th style="padding: 1rem; color: #64748b; font-weight: 600; border-bottom: 2px solid #f1f5f9; text-align: right;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingClubList as $pClub)
                        <tr style="background: #ffffff; border-radius: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.01)'" onmouseout="this.style.transform='scale(1)'">
                            <td style="padding: 1.25rem; border-bottom: 1px solid #f8fafc;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    @if($pClub->image)
                                        <img src="{{ asset('storage/' . $pClub->image) }}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 0.75rem;">
                                    @else
                                        <div style="width: 45px; height: 45px; background: #e0e7ff; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #6366f1;"><i class="fas fa-image"></i></div>
                                    @endif
                                    <strong>{{ $pClub->name }}</strong>
                                </div>
                            </td>
                            <td style="padding: 1.25rem; border-bottom: 1px solid #f8fafc; color: #475569;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 700; color: #6366f1;">
                                        {{ Str::upper(Str::substr($pClub->leader->name ?? 'A', 0, 1)) }}
                                    </div>
                                    {{ $pClub->leader->name ?? 'N/A' }}
                                </div>
                            </td>
                            <td style="padding: 1.25rem; border-bottom: 1px solid #f8fafc; color: #64748b;">
                                {{ $pClub->created_at->format('d/m/Y') }}
                            </td>
                            <td style="padding: 1.25rem; border-bottom: 1px solid #f8fafc; text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <form action="{{ route('admin.clubs.approve', $pClub->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" style="background: #22c55e; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 0.75rem; font-weight: 700; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#16a34a'">Duyệt ngay</button>
                                    </form>
                                    <form action="{{ route('admin.clubs.reject', $pClub->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" style="background: #f1f5f9; color: #64748b; border: none; padding: 0.6rem 1.2rem; border-radius: 0.75rem; font-weight: 700; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'">Từ chối</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 3rem; text-align: center; color: #94a3b8; font-style: italic;">
                                <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 1rem; color: #22c55e; display: block; opacity: 0.3;"></i>
                                Hiện tại không có yêu cầu thành lập CLB mới nào cần phê duyệt.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
