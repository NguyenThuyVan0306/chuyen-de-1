@extends('layouts.leader')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="{{ route('leader.events.index') }}" style="background: white; color: #64748b; border: 1.5px solid #e2e8f0; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;" title="Quay lại" onmouseover="this.style.transform='translateX(-5px)'" onmouseout="this.style.transform='translateX(0)'">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="page-title" style="margin: 0;">Danh sách Tham gia</div>
            </div>
            <p style="color: #64748b; margin-top: 0.5rem; margin-left: 3.2rem;">Sự kiện: <strong style="color: #1e293b;">{{ $event->title }}</strong> | CLB: {{ $event->club->name }}</p>
        </div>

        <div style="background: #eff6ff; color: #1e40af; padding: 12px 24px; border-radius: 12px; font-weight: 700; border: 1px solid #dbeafe; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-users"></i>
            <span>{{ $participants->count() }} Thành viên đã tham gia</span>
        </div>
    </div>

    <div class="section-card" style="padding: 1.5rem;">
        <div style="overflow-x: auto;">
            <table style="width:100%; border-collapse: collapse; font-size: 0.95rem;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">STT</th>
                        <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Họ và Tên</th>
                        <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Mã Sinh Viên / Khoa</th>
                        <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Thời điểm tham gia</th>
                        <th style="padding: 15px; text-align: right; color: #64748b; font-weight: 700;">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $key => $reg)
                        @php
                            $clubMember = $reg->user->clubMembers->first();
                        @endphp
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#fcfaff'" onmouseout="this.style.background='white'">
                            <td style="padding: 15px; color: #94a3b8; font-weight: 600;">{{ $key + 1 }}</td>
                            <td style="padding: 15px;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8d5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.8rem;">
                                        {{ substr($reg->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #1e293b;">{{ $reg->user->name }}</div>
                                        <div style="font-size: 0.8rem; color: #94a3b8;">{{ $reg->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px; color: #475569;">
                                @if($clubMember)
                                    <div style="font-weight: 600; color: #1e293b;">{{ $clubMember->student_id ?? 'N/A' }}</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">{{ $clubMember->faculty ?? $clubMember->department }}</div>
                                @else
                                    <span style="color: #94a3b8; font-style: italic;">Không có thông tin nội bộ</span>
                                @endif
                            </td>
                            <td style="padding: 15px; color: #475569;">
                                <div style="font-size: 0.9rem;"><i class="far fa-clock" style="margin-right: 5px; color: #94a3b8;"></i> {{ $reg->created_at->format('H:i d/m/Y') }}</div>
                            </td>
                            <td style="padding: 15px; text-align: right;">
                                <span style="background: #f0fdf4; color: #16a34a; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; border: 1px solid #dcfce7;">
                                    <i class="fas fa-check-circle" style="margin-right: 4px;"></i> Đã dự sự kiện
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 5rem; text-align: center;">
                                <div style="color: #94a3b8;">
                                    <i class="fas fa-user-slash fa-3x" style="opacity: 0.2; margin-bottom: 1.5rem; display: block;"></i>
                                    Chưa có thành viên nào tham gia sự kiện này.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
