@extends('layouts.leader')

@section('content')
    <div class="page-title">Tổng quan Câu Lạc Bộ</div>

    <div class="stats-grid">
        <a href="{{ route('leader.members.index') }}" class="stat-card card-pink" style="text-decoration: none; display: block;">
            <h4>Thành viên</h4>
            <div class="stat-number">{{ $totalMembers ?? 0 }}</div>
            <p>Thành viên trong CLB của tôi</p>
        </a>

        <a href="{{ route('leader.events.index') }}" class="stat-card card-blue" style="text-decoration: none; display: block;">
            <h4>Sự kiện</h4>
            <div class="stat-number">{{ $totalEvents ?? 0 }}</div>
            <p>Sự kiện đã tạo</p>
        </a>

        <a href="{{ route('leader.members.index') }}" class="stat-card card-green" style="text-decoration: none; display: block;">
            <h4>Đăng ký chờ duyệt</h4>
            <div class="stat-number">{{ $pendingMembers ?? 0 }}</div>
            <p>Số người xin tham gia</p>
        </a>
    </div>

    <div class="section-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0;">Câu lạc bộ đang quản lý</h3>
            <a href="{{ route('leader.clubs.info') }}" style="text-decoration: none; color: #8d5cf6; font-weight: 700; font-size: 0.9rem;">Xem tất cả &gt;</a>
        </div>

        <table style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0 0.5rem; margin-top: 15px;">
            <thead>
                <tr>
                    <th style="padding: 10px; color: #64748b; font-weight: 600;">Thông tin CLB</th>
                    <th style="padding: 10px; color: #64748b; font-weight: 600; text-align: center;">Trạng thái</th>
                    <th style="padding: 10px; color: #64748b; font-weight: 600; text-align: right;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($myManagedClubs as $club)
                    <tr style="background: #f8fafc; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                        <td style="padding: 15px; border-radius: 10px 0 0 10px;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                @if($club->image)
                                    <img src="{{ asset('storage/' . $club->image) }}" alt="Icon" style="width: 45px; height: 45px; border-radius: 10px; object-fit: cover;">
                                @else
                                    <div style="width: 45px; height: 45px; background: #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight: 700; color: #1e293b;">{{ $club->name }}</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">{{ $club->contact_email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            @if($club->status == 'approved')
                                <span style="background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">✅ ĐÃ DUYỆT</span>
                            @elseif($club->status == 'pending')
                                <span style="background: #fef9c3; color: #a16207; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">⏳ ĐANG CHỜ</span>
                            @else
                                <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">❌ TỪ CHỐI</span>
                            @endif
                        </td>
                        <td style="padding: 15px; text-align: right; border-radius: 0 10px 10px 0;">
                            <a href="{{ route('leader.clubs.info', ['club_id' => $club->id]) }}" style="text-decoration: none; background: #8d5cf6; color: white; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; transition: 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                Quản lý
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="padding: 3rem; text-align: center; color: #94a3b8;">Bạn chưa có câu lạc bộ nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
