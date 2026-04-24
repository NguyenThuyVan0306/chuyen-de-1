@extends('layouts.admin')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 class="page-title" style="margin: 0;">Giám sát Thành viên</h1>
        <p style="color: #64748b; margin-top: 0.5rem;">Danh sách tổng thể các thành viên tham gia mọi câu lạc bộ trong hệ thống.</p>
    </div>
    <div style="background: #f8fafc; padding: 0.75rem 1.25rem; border-radius: 12px; border: 1px solid #e2e8f0; font-weight: 700; color: #475569;">
        Tổng cộng: {{ $members->count() }} thành viên
    </div>
</div>

<div class="section-card" style="padding: 1.5rem;">
    <h3 style="color: #1e293b; border-left: 5px solid #3b82f6; padding-left: 1rem; margin-bottom: 2rem;">🛡️ Danh sách Thành viên & Trạng thái</h3>

    <div style="overflow-x: auto;">
        <table style="width:100%; border-collapse: collapse; font-size: 0.95rem;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">ID</th>
                    <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Họ và Tên</th>
                    <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Khoa / Lớp</th>
                    <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Câu lạc bộ</th>
                    <th style="padding: 15px; text-align: center; color: #64748b; font-weight: 700;">Trạng thái</th>
                    <th style="padding: 15px; text-align: right; color: #64748b; font-weight: 700;">Ngày tham gia</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $item)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; color: #94a3b8; font-weight: 600;">#{{ $item->id }}</td>
                    <td style="padding: 15px;">
                        <div style="font-weight: 700; color: #1e293b;">{{ $item->user->name }}</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">{{ $item->user->email }}</div>
                    </td>
                    <td style="padding: 15px; color: #475569; font-weight: 500;">
                        {{ $item->user->faculty ?? 'Chưa cập nhật' }}
                    </td>
                    <td style="padding: 15px;">
                        <span style="color: #3b82f6; font-weight: 700;">{{ $item->club->name }}</span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        @if($item->status == 'pending')
                            <span style="background:#fff7ed; color:#f97316; padding:6px 12px; border-radius:20px; font-size:0.75rem; font-weight:700; border:1px solid #ffedd5;">Chờ duyệt</span>
                        @elseif($item->status == 'approved')
                            <span style="background:#f0fdf4; color:#16a34a; padding:6px 12px; border-radius:20px; font-size:0.75rem; font-weight:700; border:1px solid #dcfce7;">Thành viên</span>
                        @else
                            <span style="background:#fef2f2; color:#dc2626; padding:6px 12px; border-radius:20px; font-size:0.75rem; font-weight:700; border:1px solid #fee2e2;">Từ chối</span>
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: right; color: #94a3b8; font-size: 0.85rem;">
                        {{ $item->joined_at ? \Carbon\Carbon::parse($item->joined_at)->format('H:i d/m/Y') : '---' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection