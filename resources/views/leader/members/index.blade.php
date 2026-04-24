@extends('layouts.leader')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div class="page-title" style="margin: 0;">Quản lý Thành viên</div>
        
        <form action="{{ route('leader.members.index') }}" method="GET" id="clubFilterForm">
            <label style="font-weight: 600; color: #64748b; margin-right: 10px;">Đang xem CLB:</label>
            <select name="club_id" onchange="document.getElementById('clubFilterForm').submit()" style="padding: 8px 15px; border-radius: 8px; border: 1px solid #8d5cf6; background: white; color: #4b148c; font-weight: 600; outline: none; cursor: pointer; box-shadow: 0 2px 5px rgba(141, 92, 246, 0.1);">
                <option value="" {{ $isAll ? 'selected' : '' }}>-- Tất cả Câu lạc bộ --</option>
                @foreach($allClubs as $c)
                    <option value="{{ $c->id }}" {{ (! $isAll && $club->id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="stats-grid" style="margin-bottom: 2rem;">
        <div class="stat-card card-pink">
            <h4>Tổng thành viên</h4>
            <div class="stat-number">{{ count($members) }} / {{ $maxMembers }}</div>
            <p>{{ $isAll ? 'Tất cả Câu lạc bộ' : 'Thành viên chính thức' }}</p>
        </div>
        <div class="stat-card card-green">
            <h4>Yêu cầu mới</h4>
            <div class="stat-number">{{ count($pendingRequests) }}</div>
            <p>Đang chờ phê duyệt</p>
        </div>
    </div>

    <div class="section-card">
        <!-- 1. Danh sách Yêu cầu chờ duyệt -->
        <div style="margin-bottom: 3rem;">
            <h3 style="color: #c2410c; border-left: 4px solid #f97316; padding-left: 10px; margin-bottom: 1.5rem;">
                ⏳ Yêu cầu chờ duyệt ({{ count($pendingRequests) }})
            </h3>
            
            <div style="overflow-x: auto;">
                <table style="width:100%; border-collapse: collapse; font-size: 0.9rem;">
                    <thead>
                        <tr style="background: #fff7ed; border-bottom: 2px solid #ffedd5;">
                            <th style="padding: 12px; text-align: left; color: #9a3412;">Người đăng ký</th>
                            @if($isAll)
                                <th style="padding: 12px; text-align: left; color: #9a3412;">Câu lạc bộ</th>
                            @endif
                            <th style="padding: 12px; text-align: left; color: #9a3412;">Khoa / Lớp</th>
                            <th style="padding: 12px; text-align: left; color: #9a3412;">Lý do tham gia</th>
                            <th style="padding: 12px; text-align: center; color: #9a3412;">Ngày gửi</th>
                            <th style="padding: 12px; text-align: right; color: #9a3412;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingRequests as $req)
                            <tr style="border-bottom: 1px solid #fed7aa;">
                                <td style="padding: 12px;">
                                    <div style="font-weight: 600; color: #1e293b;">{{ $req->user->name }}</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">{{ $req->user->email }}</div>
                                </td>
                                @if($isAll)
                                    <td style="padding: 12px; color: #f97316; font-weight: 600;">{{ $req->club->name }}</td>
                                @endif
                                <td style="padding: 12px; color: #475569;">{{ $req->user->faculty ?? '---' }}</td>
                                <td style="padding: 12px; color: #475569; max-width: 250px;">
                                    <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $req->reason }}">
                                        {{ $req->reason ?? 'Không có lý do' }}
                                    </div>
                                </td>
                                <td style="padding: 12px; text-align: center; color: #64748b;">
                                    {{ $req->created_at->format('d/m/Y') }}
                                </td>
                                <td style="padding: 12px; text-align: right;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                        <form action="{{ route('leader.club.members.approve', $req->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" style="background: #22c55e; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.8rem;">Duyệt</button>
                                        </form>
                                        <form action="{{ route('leader.club.members.reject', $req->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.8rem;">Từ chối</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 2rem; text-align: center; color: #94a3b8; background: #fffcf9;">Không có yêu cầu nào đang chờ xử lý.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Danh sách Thành viên chính thức -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <h3 style="color: #1e293b; border-left: 4px solid #8d5cf6; padding-left: 10px; margin: 0;">
                    👥 Danh sách Thành viên ({{ count($members) }})
                </h3>
                
                <!-- Tìm kiếm và Lọc -->
                <form action="{{ route('leader.members.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên..." style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; min-width: 200px;">
                    <select name="department" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; background: white;">
                        <option value="">-- Tất cả bộ phận --</option>
                        <option value="Ban Truyền thông" {{ request('department') == 'Ban Truyền thông' ? 'selected' : '' }}>Ban Truyền thông</option>
                        <option value="Ban Sự kiện" {{ request('department') == 'Ban Sự kiện' ? 'selected' : '' }}>Ban Sự kiện</option>
                        <option value="Ban Tài chính" {{ request('department') == 'Ban Tài chính' ? 'selected' : '' }}>Ban Tài chính</option>
                        <option value="Ban Nhân sự" {{ request('department') == 'Ban Nhân sự' ? 'selected' : '' }}>Ban Nhân sự</option>
                    </select>
                    <button type="submit" style="background: #8d5cf6; color: white; border: none; padding: 8px 20px; border-radius: 8px; cursor: pointer; font-weight: 600;">Lọc</button>
                </form>
            </div>

            <div style="overflow-x: auto;">
                <table style="width:100%; border-collapse: collapse; font-size: 0.9rem;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 12px; text-align: left; color: #64748b;">Họ và Tên</th>
                            @if($isAll)
                                <th style="padding: 12px; text-align: left; color: #64748b;">Câu lạc bộ</th>
                            @endif
                            <th style="padding: 12px; text-align: left; color: #64748b;">Khoa / Lớp</th>
                            <th style="padding: 12px; text-align: center; color: #64748b;">Bộ phận</th>
                            <th style="padding: 12px; text-align: center; color: #64748b;">Ngày gia nhập</th>
                            <th style="padding: 12px; text-align: right; color: #64748b;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 12px;">
                                    <div style="font-weight: 600; color: #1e293b;">{{ $member->user->name }}</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">{{ $member->user->email }}</div>
                                </td>
                                @if($isAll)
                                    <td style="padding: 12px; color: #8d5cf6; font-weight: 600;">{{ $member->club->name }}</td>
                                @endif
                                <td style="padding: 12px; color: #475569;">{{ $member->user->faculty ?? '---' }}</td>
                                <td style="padding: 12px; text-align: center;">
                                    <span style="background: #e0e7ff; color: #4338ca; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                        {{ $member->department ?? 'Thành viên' }}
                                    </span>
                                </td>
                                <td style="padding: 12px; text-align: center; color: #64748b;">
                                    {{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d/m/Y') : $member->updated_at->format('d/m/Y') }}
                                </td>
                                <td style="padding: 12px; text-align: right;">
                                    <form action="{{ route('leader.club.members.remove', $member->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn khai trừ thành viên này khỏi câu lạc bộ?')">
                                        @csrf
                                        <button type="submit" style="background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 15px; border-radius: 8px; cursor: pointer; font-size: 0.85rem; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='transparent'">
                                            Khai trừ
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 3rem; text-align: center; color: #94a3b8;">Không tìm thấy thành viên nào phù hợp với điều kiện lọc.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
