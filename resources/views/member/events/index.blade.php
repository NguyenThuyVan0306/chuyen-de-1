@extends('layouts.member')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0;">Sự kiện sắp tới</h1>
            <p style="color: #64748b; margin-top: 0.5rem;">Cập nhật những hoạt động mới nhất từ các câu lạc bộ bạn tham gia.</p>
        </div>
        <div style="background: white; padding: 0.5rem 1rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-calendar-alt" style="color: #3b82f6;"></i>
            <span style="font-weight: 700; color: #475569;">{{ $events->count() }} Sự kiện</span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
        @forelse($events as $event)
            <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; display: flex; flex-direction: column; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="height: 200px; position: relative;">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #f0fdf4, #dcfce7); display: flex; align-items: center; justify-content: center; color: #22c55e;">
                            <i class="fas fa-calendar-star" style="font-size: 4rem; opacity: 0.2;"></i>
                        </div>
                    @endif
                    <div style="position: absolute; top: 1rem; left: 1rem; display: flex; gap: 0.5rem;">
                        <span style="background: {{ $event->calculated_status_color }}; color: white; padding: 0.4rem 0.8rem; border-radius: 10px; font-size: 0.75rem; font-weight: 700; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            {{ $event->calculated_status_label }}
                        </span>
                    </div>
                </div>

                <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
                    <div style="margin-bottom: 1rem;">
                        <span style="color: #3b82f6; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">{{ $event->club->name }}</span>
                        <h3 style="margin: 0.25rem 0; font-size: 1.25rem; font-weight: 800; color: #1e293b;">{{ $event->title }}</h3>
                    </div>

                    <div style="display: grid; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #64748b; font-size: 0.9rem;">
                            <i class="fas fa-clock" style="width: 16px; color: #94a3b8;"></i>
                            <span>{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }} | {{ $event->start_time->format('d/m/Y') }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #64748b; font-size: 0.9rem;">
                            <i class="fas fa-map-marker-alt" style="width: 16px; color: #ef4444;"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                    </div>

                    <p style="font-size: 0.9rem; color: #64748b; line-height: 1.6; margin-bottom: 1.5rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; height: 4.3rem;">
                        {{ $event->description }}
                    </p>

                    <div style="margin-top: auto; padding-top: 1.25rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                        @php
                            $registration = $event->registrations->first();
                        @endphp

                        @if(!$registration)
                            <form action="{{ route('member.events.register', $event->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" style="width: 100%; background: #3b82f6; color: white; border: none; padding: 0.75rem; border-radius: 12px; font-weight: 700; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                    <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i> Tham gia ngay
                                </button>
                            </form>
                        @elseif($registration->status === 'approved')
                            <div style="flex: 1; background: #f0fdf4; color: #16a34a; padding: 0.75rem; border-radius: 12px; font-weight: 700; text-align: center; font-size: 0.9rem; border: 1px solid #dcfce7;">
                                <i class="fas fa-check-double" style="margin-right: 6px;"></i> Đã tham gia
                            </div>
                        @else
                            {{-- Các trạng thái khác nếu có --}}
                            <div style="flex: 1; background: #fef2f2; color: #dc2626; padding: 0.75rem; border-radius: 12px; font-weight: 700; text-align: center; font-size: 0.9rem; border: 1px solid #fee2e2;">
                                <i class="fas fa-info-circle" style="margin-right: 6px;"></i> {{ $registration->status }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; background: white; border-radius: 24px; padding: 5rem; text-align: center; border: 2px dashed #e2e8f0;">
                <div style="width: 80px; height: 80px; background: #f0fdf4; color: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1.5rem;">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3 style="color: #475569; font-weight: 700;">Chưa có sự kiện nào</h3>
                <p style="color: #64748b; max-width: 400px; margin: 0 auto;">Hiện tại chưa có sự kiện nào mới từ các câu lạc bộ bạn tham gia. Hãy theo dõi thường xuyên nhé!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div style="margin-top: 3rem; display: flex; justify-content: center;">
        {{ $events->links() }}
    </div>
@endsection