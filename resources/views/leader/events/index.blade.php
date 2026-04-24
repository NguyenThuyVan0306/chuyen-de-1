@extends('layouts.leader')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <div class="page-title" style="margin: 0;">Quản lý Sự kiện</div>
            <p style="color: #64748b; margin-top: 0.5rem;">Lên lịch và vận hành các hoạt động cho câu lạc bộ.</p>
        </div>
        
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <form action="{{ route('leader.events.index') }}" method="GET" id="clubFilterFormEvents">
                <label style="font-weight: 600; color: #64748b; margin-right: 10px;">Đang xem:</label>
                <select name="club_id" onchange="document.getElementById('clubFilterFormEvents').submit()" style="padding: 10px 18px; border-radius: 10px; border: 1.5px solid #8d5cf6; background: white; color: #4b148c; font-weight: 700; outline: none; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(141, 92, 246, 0.1);">
                    <option value="" {{ $isAll ? 'selected' : '' }}>-- Tất cả Câu lạc bộ --</option>
                    @foreach($allClubs as $c)
                        <option value="{{ $c->id }}" {{ (! $isAll && $club->id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </form>
            
            <button onclick="document.getElementById('createEventModal').style.display='flex'" style="background: #8d5cf6; color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; transition: transform 0.2s; box-shadow: 0 4px 12px rgba(141, 92, 246, 0.2);" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-plus-circle"></i> Tạo sự kiện mới
            </button>
        </div>
    </div>

    <!-- Events List Table -->
    <div class="section-card" style="padding: 1.5rem;">
        <h3 style="color: #1e293b; border-left: 5px solid #8d5cf6; padding-left: 1rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-calendar-alt" style="color: #8d5cf6;"></i> Danh sách Sự kiện
        </h3>

        <div style="overflow-x: auto;">
            <table style="width:100%; border-collapse: collapse; font-size: 0.95rem;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Sự kiện</th>
                        <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Mô tả</th>
                        @if($isAll)
                            <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Câu lạc bộ</th>
                        @endif
                        <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Thời gian</th>
                        <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 700;">Địa điểm</th>
                        <th style="padding: 15px; text-align: center; color: #64748b; font-weight: 700;">Trạng thái</th>
                        <th style="padding: 15px; text-align: right; color: #64748b; font-weight: 700;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    @if($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                                    @else
                                        <div style="width: 50px; height: 50px; border-radius: 8px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight: 700; color: #1e293b;">{{ $event->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px; color: #64748b; font-size: 0.85rem; max-width: 250px;">
                                <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $event->description }}">
                                    {{ $event->description }}
                                </div>
                            </td>
                            @if($isAll)
                                <td style="padding: 15px; color: #3b82f6; font-weight: 700;">{{ $event->club->name }}</td>
                            @endif
                            <td style="padding: 15px; color: #475569;">
                                <div style="font-weight: 600;">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i d/m/Y') }}</div>
                                <div style="font-size: 0.8rem; color: #94a3b8;">đến {{ \Carbon\Carbon::parse($event->end_time)->format('H:i d/m/Y') }}</div>
                            </td>
                            <td style="padding: 15px; color: #475569;">
                                <i class="fas fa-map-marker-alt" style="color: #ef4444; margin-right: 5px;"></i> {{ $event->location }}
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="background: {{ $event->calculated_status_color }}15; color: {{ $event->calculated_status_color }}; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-block; min-width: 100px; border: 1px solid {{ $event->calculated_status_color }}30;">
                                    {{ $event->calculated_status_label }}
                                </span>
                            </td>
                            <td style="padding: 15px; text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <button class="action-btn" onclick="openEditEventModal('{{ $event->id }}', '{{ addslashes($event->title) }}', '{{ addslashes($event->description) }}', '{{ addslashes($event->location) }}', '{{ $event->start_time->format('Y-m-d\TH:i') }}', '{{ $event->end_time->format('Y-m-d\TH:i') }}', '{{ $event->image ? asset('storage/'.$event->image) : '' }}')" style="background: #3b82f615; color: #3b82f6; border: none; padding: 8px; border-radius: 8px; cursor: pointer; transition: 0.2s;" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="{{ route('leader.events.participants', $event->id) }}" class="action-btn" style="background: #22c55e; color: white; border: none; padding: 6px 12px; border-radius: 8px; cursor: pointer; transition: 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.2);" title="Danh sách thành viên tham gia" onmouseover="this.style.background='#16a34a'" onmouseout="this.style.background='#22c55e'">
                                        <i class="fas fa-clipboard-check"></i>
                                        <span style="font-weight: 700; font-size: 0.85rem;">{{ $event->registrations->count() }}</span>
                                    </a>
                                    <form action="{{ route('leader.events.delete', $event->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sự kiện này? Hành động này không thể hoàn tác.')" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: #ef444415; color: #ef4444; border: none; padding: 8px; border-radius: 8px; cursor: pointer; transition: 0.2s;" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $isAll ? 7 : 6 }}" style="padding: 4rem; text-align: center;">
                                <div style="color: #94a3b8; font-size: 1.1rem;">
                                    <i class="fas fa-calendar-times fa-3x" style="opacity: 0.2; margin-bottom: 1rem; display: block;"></i>
                                    Chưa có sự kiện nào được tạo.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL: CREATE EVENT -->
    <div id="createEventModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div style="background: white; width: 650px; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); position: relative; max-height: 90vh; overflow-y: auto;">
            <button onclick="document.getElementById('createEventModal').style.display='none'" style="position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #94a3b8;">&times;</button>
            <h3 style="margin-top: 0; color: #1e293b; margin-bottom: 1.5rem; border-left: 5px solid #8d5cf6; padding-left: 1rem;">🚀 Tạo Sự kiện mới</h3>
            
            <form action="{{ route('leader.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; gap: 1.25rem;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Câu lạc bộ chủ quản</label>
                        <select name="club_id" required style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; outline: none;">
                            @foreach($allClubs as $c)
                                <option value="{{ $c->id }}" {{ (! $isAll && $club->id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Tên sự kiện</label>
                        <input type="text" name="title" required value="{{ old('title') }}" placeholder="Ví dụ: Workshop Kỹ năng thuyết trình" style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem;">
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Địa điểm tổ chức</label>
                        <input type="text" name="location" required value="{{ old('location') }}" placeholder="Ví dụ: Hội trường A1" style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Thời gian bắt đầu</label>
                            <input type="datetime-local" name="start_time" required value="{{ old('start_time') }}" style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Thời gian kết thúc</label>
                            <input type="datetime-local" name="end_time" required value="{{ old('end_time') }}" style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Mô tả nội dung</label>
                        <textarea name="description" rows="3" required placeholder="Ghi tóm tắt nội dung chính của sự kiện..." style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; resize: none;">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Ảnh bìa sự kiện (nếu có)</label>
                        <input type="file" name="image" style="width: 100%; padding: 0.5rem; background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 0.5rem;">
                        <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.3rem;">Chấp nhận: JPG, PNG. Tối đa 2MB.</p>
                    </div>

                    <button type="submit" style="background: #8d5cf6; color: white; border: none; padding: 14px; border-radius: 10px; font-weight: 700; cursor: pointer; margin-top: 1rem; transition: background 0.2s;" onmouseover="this.style.background='#7c3aed'">Xác nhận Tạo sự kiện</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT EVENT -->
    <div id="editEventModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div style="background: white; width: 650px; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); position: relative; max-height: 90vh; overflow-y: auto;">
            <button onclick="document.getElementById('editEventModal').style.display='none'" style="position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #94a3b8;">&times;</button>
            <h3 style="margin-top: 0; color: #1e293b; margin-bottom: 1.5rem; border-left: 5px solid #3b82f6; padding-left: 1rem;">✏️ Chỉnh sửa Sự kiện</h3>
            
            <form id="editEventForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; gap: 1.25rem;">
                    
                    <div style="display: flex; gap: 1.5rem; align-items: center; background: #f8fafc; padding: 1rem; border-radius: 1rem; border: 1px solid #e2e8f0;">
                        <img id="edit-event-preview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; display: none;">
                        <div style="flex: 1;">
                            <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Thay đổi ảnh bìa</label>
                            <input type="file" name="image" onchange="previewEditEventImage(this)" style="width: 100%; padding: 0.5rem; background: white; border: 1.5px dashed #cbd5e1; border-radius: 0.5rem;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Tên sự kiện</label>
                        <input type="text" name="title" id="edit-event-title" required style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem;">
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Địa điểm tổ chức</label>
                        <input type="text" name="location" id="edit-event-location" required style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Thời gian bắt đầu</label>
                            <input type="datetime-local" name="start_time" id="edit-event-start" required style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Thời gian kết thúc</label>
                            <input type="datetime-local" name="end_time" id="edit-event-end" required style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Mô tả nội dung</label>
                        <textarea name="description" id="edit-event-description" rows="3" required style="width: 100%; padding: 0.75rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; resize: none;"></textarea>
                    </div>

                    <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 14px; border-radius: 10px; font-weight: 700; cursor: pointer; margin-top: 1rem; transition: background 0.2s;" onmouseover="this.style.background='#2563eb'">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditEventModal(id, title, description, location, start, end, imageUrl) {
            const form = document.getElementById('editEventForm');
            form.action = `/leader/events/${id}/update`;
            
            document.getElementById('edit-event-title').value = title;
            document.getElementById('edit-event-description').value = description;
            document.getElementById('edit-event-location').value = location;
            document.getElementById('edit-event-start').value = start;
            document.getElementById('edit-event-end').value = end;
            
            const preview = document.getElementById('edit-event-preview');
            if (imageUrl) {
                preview.src = imageUrl;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
            
            document.getElementById('editEventModal').style.display = 'flex';
        }

        function previewEditEventImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('edit-event-preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
