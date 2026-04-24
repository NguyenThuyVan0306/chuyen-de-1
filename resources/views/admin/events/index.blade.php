@extends('layouts.admin')

@section('content')
    <div class="page-title">Quản lý sự kiện</div>

    <div style="background: white; border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem; border-left: 5px solid #8d5cf6; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h3 style="margin: 0; color: #1e293b; font-size: 1.25rem;">Chế độ Giám sát Sự kiện</h3>
        <p style="color: #64748b; margin-top: 0.5rem; line-height: 1.6;">
            Chào Admin! Theo quy trình mới, việc khởi tạo và quản lý nội dung sự kiện sẽ được bàn giao cho <strong>Club Leaders</strong>. 
            Bạn đang ở chế độ giám sát: Bạn có thể xem thông tin tất cả các sự kiện và thực hiện <strong>Xóa</strong> nếu phát hiện nội dung không phù hợp.
        </p>
    </div>

    <div class="section-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0;">Danh sách sự kiện toàn trường</h3>
            <span style="background: #f1f5f9; padding: 0.5rem 1rem; border-radius: 10px; font-weight: 700; color: #475569; font-size: 0.9rem;">
                {{ $events->count() }} Sự kiện
            </span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="background:#f6f2ff;">
                        <th style="padding:15px; border:1px solid #eee; text-align:left;">STT</th>
                        <th style="padding:15px; border:1px solid #eee; text-align:left;">Tên sự kiện</th>
                        <th style="padding:15px; border:1px solid #eee; text-align:left;">Câu lạc bộ</th>
                        <th style="padding:15px; border:1px solid #eee; text-align:left;">Thời gian</th>
                        <th style="padding:15px; border:1px solid #eee; text-align:left;">Địa điểm</th>
                        <th style="padding:15px; border:1px solid #eee; text-align:left;">Trạng thái</th>
                        <th style="padding:15px; border:1px solid #eee; text-align:center;">Kiểm duyệt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $key => $event)
                        <tr style="transition: background 0.2s;" onmouseover="this.style.background='#fcfaff'" onmouseout="this.style.background='white'">
                            <td style="padding:15px; border:1px solid #eee;">{{ $key + 1 }}</td>
                            <td style="padding:15px; border:1px solid #eee; font-weight: 700; color: #1e293b;">{{ $event->title }}</td>
                            <td style="padding:15px; border:1px solid #eee;">
                                <span style="background: #eff6ff; color: #1e40af; padding: 4px 10px; border-radius: 8px; font-size: 0.85rem; font-weight: 600;">
                                    {{ $event->club->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td style="padding:15px; border:1px solid #eee; font-size: 0.9rem; color: #475569;">
                                <div><i class="far fa-calendar-alt" style="margin-right: 5px;"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y') }}</div>
                                <div style="font-size: 0.8rem; margin-top: 3px;"><i class="far fa-clock" style="margin-right: 5px;"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</div>
                            </td>
                            <td style="padding:15px; border:1px solid #eee; color: #475569;">{{ $event->location }}</td>
                            <td style="padding:15px; border:1px solid #eee;">
                                <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; background: {{ $event->calculated_status_color }}15; color: {{ $event->calculated_status_color }}; font-size: 0.8rem; font-weight: 700; border: 1px solid {{ $event->calculated_status_color }}30;">
                                    {{ $event->calculated_status_label }}
                                </span>
                            </td>
                            <td style="padding:15px; border:1px solid #eee; text-align:center;">
                                <form action="{{ route('admin.events.delete', $event->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Cảnh báo: Bạn đang thực hiện xóa sự kiện của CLB. Bạn có chắc chắn muốn tiếp tục?')"
                                      style="margin:0;">
                                    @csrf
                                    <button type="submit"
                                            style="padding:8px 15px; background:#fff1f2; color:#e11d48; border:1px solid #fecaca; border-radius:10px; cursor:pointer; font-weight: 700; transition: all 0.2s;"
                                            onmouseover="this.style.background='#e11d48'; this.style.color='white'"
                                            onmouseout="this.style.background='#fff1f2'; this.style.color='#e11d48'">
                                        <i class="far fa-trash-alt" style="margin-right: 5px;"></i> Gỡ bỏ
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:50px; text-align:center; border:1px solid #eee; color: #94a3b8;">
                                <i class="fas fa-calendar-times" style="font-size: 3rem; opacity: 0.1; display: block; margin-bottom: 1rem;"></i>
                                Chưa có sự kiện nào được tạo từ các câu lạc bộ.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection