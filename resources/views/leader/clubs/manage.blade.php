@extends('layouts.leader')

@section('content')
    <div class="page-title">
        Không gian Quản trị: {{ $club->name }}
        <a href="{{ route('leader.home') }}" style="float:right; font-size:14px; background:#eee; padding:6px 12px; border-radius:6px; color:#333; text-decoration:none;">Quay lại Trang Chủ</a>
    </div>

    <!-- Tabs Styling -->
    <style>
        .tabs { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .tab-btn { padding: 10px 20px; background: none; border: none; cursor: pointer; font-size: 16px; font-weight: 600; color: #666; }
        .tab-btn.active { color: #8d5cf6; border-bottom: 3px solid #8d5cf6; margin-bottom: -12px; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
    </style>

    <div class="tabs">
        <button class="tab-btn active" onclick="switchTab(event, 'tab-info')">Tùy chỉnh Thông tin</button>
        <button class="tab-btn" onclick="switchTab(event, 'tab-members')">Quản lý Thành viên</button>
        <button class="tab-btn" onclick="switchTab(event, 'tab-events')">Quản lý Sự kiện</button>
    </div>

    <!-- TAB: THÔNG TIN CLB -->
    <div id="tab-info" class="tab-content active section-card">
        <div style="display: flex; gap: 2rem; align-items: flex-start;">
            <div style="flex-shrink: 0;">
                @if($club->image)
                    <img src="{{ asset('storage/' . $club->image) }}" alt="{{ $club->name }}" style="width: 200px; height: 200px; object-fit: cover; border-radius: 1rem; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                @else
                    <div style="width: 200px; height: 200px; background: #f3f4f6; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #9ca3af; flex-direction: column; gap: 0.5rem;">
                         <i class="fas fa-image" style="font-size: 3rem;"></i>
                         <span>Chưa có ảnh</span>
                    </div>
                @endif
            </div>
            
            <div style="flex-grow: 1;">
                <h3 style="margin-top: 0; color: #1e293b; font-size: 1.5rem;">{{ $club->name }}</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <strong style="display: block; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">Email liên hệ:</strong>
                        <span style="color: #334155;">{{ $club->contact_email }}</span>
                    </div>
                    <div>
                        <strong style="display: block; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">Số điện thoại:</strong>
                        <span style="color: #334155;">{{ $club->contact_phone }}</span>
                    </div>
                    <div>
                        <strong style="display: block; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">Giới hạn thành viên:</strong>
                        <span style="color: #334155;">{{ $club->max_members }} thành viên</span>
                    </div>
                    <div>
                        <strong style="display: block; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">Ngày thành lập:</strong>
                        <span style="color: #334155;">{{ $club->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <strong style="display: block; color: #64748b; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.5rem;">Mô tả hoạt động:</strong>
                    <p style="color: #4b5563; line-height: 1.6; margin: 0;">{{ $club->description }}</p>
                </div>

                <div style="padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
                    <p style="font-size: 0.85rem; color: #94a3b8; font-style: italic;">
                        * Chỉ Admin mới có quyền cập nhật thông tin và ảnh đại diện nòng cốt của Câu lạc bộ. 
                        Vui lòng liên hệ Văn phòng Đoàn để yêu cầu thay đổi nếu cần.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: THÀNH VIÊN -->
    <div id="tab-members" class="tab-content section-card">
        <!-- 1. Danh sách Yêu cầu chờ duyệt -->
        <div style="margin-bottom: 3rem;">
            <h3 style="color: #c2410c; border-left: 4px solid #f97316; padding-left: 10px; margin-bottom: 1.5rem;">
                ⏳ Yêu cầu chờ duyệt ({{ count($pendingRequests) }})
            </h3>
            
            <div style="overflow-x: auto;">
                <table style="width:100%; border-collapse: collapse; font-size: 0.9rem;">
                    <thead>
                        <tr style="background: #fff7ed; border-bottom: 2px solid #ffedd5;">
                            <th style="padding: 12px; text-align: left;">Người đăng ký</th>
                            <th style="padding: 12px; text-align: left;">Khoa/Lớp</th>
                            <th style="padding: 12px; text-align: left;">Lý do tham gia</th>
                            <th style="padding: 12px; text-align: center;">Ngày gửi</th>
                            <th style="padding: 12px; text-align: right;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingRequests as $req)
                            <tr style="border-bottom: 1px solid #fed7aa;">
                                <td style="padding: 12px;">
                                    <div style="font-weight: 600; color: #1e293b;">{{ $req->user->name }}</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">{{ $req->user->email }}</div>
                                </td>
                                <td style="padding: 12px; color: #475569;">{{ $req->user->faculty ?? '---' }}</td>
                                <td style="padding: 12px; color: #475569; max-width: 200px;">
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
                                            <button type="submit" style="background: #22c55e; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600;">Duyệt</button>
                                        </form>
                                        <form action="{{ route('leader.club.members.reject', $req->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600;">Từ chối</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 2rem; text-align: center; color: #94a3b8;">Không có yêu cầu nào đang chờ.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Danh sách Thành viên chính thức -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="color: #1e293b; border-left: 4px solid #8d5cf6; padding-left: 10px; margin: 0;">
                    👥 Thành viên chính thức ({{ count($members) }}/{{ $club->max_members }})
                </h3>
                
                <!-- Tìm kiếm và Lọc -->
                <form action="{{ route('leader.clubs.manage', $club->id) }}" method="GET" style="display: flex; gap: 10px;">
                    <input type="hidden" name="tab" value="tab-members">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên..." style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 6px;">
                    <select name="department" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">-- Tất cả bộ phận --</option>
                        <option value="Ban Truyền thông" {{ request('department') == 'Ban Truyền thông' ? 'selected' : '' }}>Ban Truyền thông</option>
                        <option value="Ban Sự kiện" {{ request('department') == 'Ban Sự kiện' ? 'selected' : '' }}>Ban Sự kiện</option>
                        <option value="Ban Tài chính" {{ request('department') == 'Ban Tài chính' ? 'selected' : '' }}>Ban Tài chính</option>
                        <option value="Ban Nhân sự" {{ request('department') == 'Ban Nhân sự' ? 'selected' : '' }}>Ban Nhân sự</option>
                    </select>
                    <button type="submit" style="background: #8d5cf6; color: white; border: none; padding: 6px 15px; border-radius: 6px; cursor: pointer;">Lọc</button>
                </form>
            </div>

            <div style="overflow-x: auto;">
                <table style="width:100%; border-collapse: collapse; font-size: 0.9rem;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 12px; text-align: left;">Thành viên</th>
                            <th style="padding: 12px; text-align: left;">Khoa/Lớp</th>
                            <th style="padding: 12px; text-align: center;">Bộ phận</th>
                            <th style="padding: 12px; text-align: center;">Ngày gia nhập</th>
                            <th style="padding: 12px; text-align: right;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 12px;">
                                    <div style="font-weight: 600; color: #1e293b;">{{ $member->user->name }}</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">{{ $member->user->email }}</div>
                                </td>
                                <td style="padding: 12px; color: #475569;">{{ $member->user->faculty ?? '---' }}</td>
                                <td style="padding: 12px; text-align: center;">
                                    <span style="background: #e0e7ff; color: #4338ca; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                        {{ $member->department ?? 'Thành viên' }}
                                    </span>
                                </td>
                                <td style="padding: 12px; text-align: center; color: #64748b;">
                                    {{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d/m/Y') : $member->updated_at->format('d/m/Y') }}
                                </td>
                                <td style="padding: 12px; text-align: right;">
                                    <form action="{{ route('leader.club.members.remove', $member->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn khai trừ thành viên này khỏi câu lạc bộ?')">
                                        @csrf
                                        <button type="submit" style="background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='transparent'">
                                            Khai trừ
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 2rem; text-align: center; color: #94a3b8;">Không tìm thấy thành viên nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: SỰ KIỆN -->
    <div id="tab-events" class="tab-content section-card">
        <h3>Sự kiện của Câu lạc bộ
            <a href="#" style="float:right; font-size:14px; background:#8d5cf6; padding:6px 12px; border-radius:6px; color:white; text-decoration:none;">+ Tạo sự kiện</a>
        </h3>

        <table style="width:100%; border-collapse:collapse; margin-top:14px;">
            <tr style="background:#f6f2ff;">
                <th style="padding:10px; border-bottom:1px solid #ddd;">Tên sự kiện</th>
                <th style="padding:10px; border-bottom:1px solid #ddd;">Thời gian</th>
                <th style="padding:10px; border-bottom:1px solid #ddd;">Hành động</th>
            </tr>
            @foreach($events as $event)
                <tr>
                    <td style="padding:10px; border-bottom:1px solid #ddd;">{{ $event->title }}</td>
                    <td style="padding:10px; border-bottom:1px solid #ddd;">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i d/m/Y') }}</td>
                    <td style="padding:10px; border-bottom:1px solid #ddd;">
                        <button class="btn-primary" style="padding:4px 8px;">Sửa</button>
                        <button class="btn-success" style="padding:4px 8px;">Điểm danh</button>
                        <button class="btn-danger" style="padding:4px 8px;">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- Script Chuyển Tab -->
    <script>
        function switchTab(evt, tabId) {
            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            if (evt) {
                evt.currentTarget.classList.add('active');
            } else {
                document.querySelector(`button[onclick*="'${tabId}'"]`).classList.add('active');
            }
            
            // Cập nhật URL mà không reload trang
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.pushState({}, '', url);
        }

        // Tự động mở Tab nếu có tham số trên URL
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');
            if (activeTab && document.getElementById(activeTab)) {
                switchTab(null, activeTab);
            }
        }
    </script>
@endsection
