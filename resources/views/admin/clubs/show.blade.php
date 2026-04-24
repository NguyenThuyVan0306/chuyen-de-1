@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Chi tiết Câu lạc bộ: {{ $club->name }}
        <a href="{{ route('admin.clubs.index') }}" style="float:right; font-size:14px; text-decoration:none; background:#eee; padding:6px 12px; border-radius:6px; color:#333;">Quay lại</a>
    </div>

    <div class="section-card" style="margin-bottom: 24px;">
        <h3>Thông tin Câu lạc bộ</h3>
        <p><strong>Mô tả:</strong> {{ $club->description }}</p>
        <p><strong>Email liên hệ:</strong> {{ $club->contact_email }}</p>
        <p><strong>SĐT:</strong> {{ $club->contact_phone }}</p>
        <p><strong>Trưởng nhóm:</strong> {{ $club->leader->name ?? 'Chưa xác định' }}</p>
        <p><strong>Trạng thái:</strong> 
            @if($club->status == 'approved') <span style="color:green; font-weight:bold;">Đã duyệt</span>
            @elseif($club->status == 'pending') <span style="color:orange; font-weight:bold;">Chờ duyệt</span>
            @else <span style="color:red; font-weight:bold;">Từ chối</span> @endif
        </p>
    </div>

    <div class="section-card">
        <h3>Danh sách Thành viên ({{ $club->clubMembers->count() }} / {{ $club->max_members }})</h3>

        <table style="width:100%; border-collapse: collapse; margin-top: 14px;">
            <thead>
                <tr style="background:#f6f2ff;">
                    <th style="padding:12px; border:1px solid #eee;">STT</th>
                    <th style="padding:12px; border:1px solid #eee;">Tên thành viên</th>
                    <th style="padding:12px; border:1px solid #eee;">Email</th>
                    <th style="padding:12px; border:1px solid #eee;">Ngày tham gia</th>
                    <th style="padding:12px; border:1px solid #eee;">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse($club->clubMembers as $key => $member)
                    <tr>
                        <td style="padding:12px; border:1px solid #eee;">{{ $key + 1 }}</td>
                        <td style="padding:12px; border:1px solid #eee;">{{ $member->user->name ?? 'User đã xóa' }}</td>
                        <td style="padding:12px; border:1px solid #eee;">{{ $member->user->email ?? '' }}</td>
                        <td style="padding:12px; border:1px solid #eee;">{{ $member->created_at->format('d/m/Y') }}</td>
                        <td style="padding:12px; border:1px solid #eee; text-align:center;">
                            @if($member->status == 'approved')
                                <span style="color:green;">Chính thức</span>
                            @else
                                <span style="color:orange;">Chờ duyệt</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:16px; text-align:center; border:1px solid #eee;">
                            Chưa có thành viên nào đăng ký câu lạc bộ này.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
