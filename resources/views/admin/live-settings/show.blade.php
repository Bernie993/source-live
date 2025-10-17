@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-eye"></i> Chi tiết Cài đặt Live
            </h1>
            <div>
                <a href="{{ route('admin.live-settings.edit', $liveSetting) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.live-settings.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-info-circle"></i> Thông tin Live Stream
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="200">ID:</th>
                                <td>{{ $liveSetting->id }}</td>
                            </tr>
                            @if($liveSetting->live_title)
                            <tr>
                                <th>Tiêu đề:</th>
                                <td><strong>{{ $liveSetting->live_title }}</strong></td>
                            </tr>
                            @endif
                            @if($liveSetting->live_description)
                            <tr>
                                <th>Mô tả:</th>
                                <td>{{ $liveSetting->live_description }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Link Live:</th>
                                <td>
                                    <a href="{{ $liveSetting->live_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-link-45deg"></i> {{ $liveSetting->live_url }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Link Play FLV:</th>
                                <td>
                                    @if($liveSetting->play_url_flv)
                                        <a href="{{ $liveSetting->play_url_flv }}" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-play-circle"></i> {{ $liveSetting->play_url_flv }}
                                        </a>
                                    @else
                                        <span class="text-muted">Chưa có</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Link Play m3u8:</th>
                                <td>
                                    @if($liveSetting->play_url_m3u8)
                                        <a href="{{ $liveSetting->play_url_m3u8 }}" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-play-circle"></i> {{ $liveSetting->play_url_m3u8 }}
                                        </a>
                                    @else
                                        <span class="text-muted">Chưa có</span>
                                    @endif
                                </td>
                            </tr>
                            @if($liveSetting->default_video_url)
                            <tr>
                                <th>Video mặc định:</th>
                                <td>
                                    <a href="{{ $liveSetting->default_video_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-film"></i> {{ $liveSetting->default_video_url }}
                                    </a>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>Ngày Live:</th>
                                <td>
                                    <i class="bi bi-calendar-event"></i> 
                                    {{ $liveSetting->live_date->format('d/m/Y') }}
                                    ({{ $liveSetting->live_date->locale('vi')->diffForHumans() }})
                                </td>
                            </tr>
                            <tr>
                                <th>Giờ Live:</th>
                                <td>
                                    <i class="bi bi-clock"></i> 
                                    {{ $liveSetting->live_time->format('H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Nhân viên được gán:</th>
                                <td>
                                    @if($liveSetting->assignedUser)
                                        <span class="badge bg-primary">
                                            <i class="bi bi-person-check"></i> {{ $liveSetting->assignedUser->name }}
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $liveSetting->assignedUser->email ?? 'Không có email' }}</small>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-person-x"></i> Chưa gán nhân viên
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td>
                                    @if($liveSetting->is_active)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Đang kích hoạt
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle"></i> Không kích hoạt
                                        </span>
                                    @endif
                                    
                                    @if($liveSetting->isAccessible())
                                        <span class="badge bg-info">
                                            <i class="bi bi-unlock"></i> Có thể truy cập
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-lock"></i> Chưa thể truy cập
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Preview Video Section -->
        @if($liveSetting->default_video_url)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-play-btn"></i> Preview Video
                </h6>
            </div>
            <div class="card-body">
                <div class="ratio ratio-16x9">
                    <video controls>
                        <source src="{{ $liveSetting->default_video_url }}" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Timeline Card -->
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-clock-history"></i> Timeline
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Ngày tạo:</small>
                    <p class="mb-0">
                        <i class="bi bi-calendar-plus"></i> 
                        {{ $liveSetting->created_at->format('d/m/Y H:i:s') }}
                    </p>
                    <small class="text-muted">{{ $liveSetting->created_at->diffForHumans() }}</small>
                </div>
                <hr>
                <div class="mb-3">
                    <small class="text-muted">Cập nhật lần cuối:</small>
                    <p class="mb-0">
                        <i class="bi bi-calendar-check"></i> 
                        {{ $liveSetting->updated_at->format('d/m/Y H:i:s') }}
                    </p>
                    <small class="text-muted">{{ $liveSetting->updated_at->diffForHumans() }}</small>
                </div>
                @if($liveSetting->live_date && $liveSetting->live_time)
                <hr>
                <div>
                    <small class="text-muted">Thời gian live:</small>
                    <p class="mb-0">
                        <i class="bi bi-broadcast"></i> 
                        {{ $liveSetting->live_date->format('d/m/Y') }} 
                        {{ $liveSetting->live_time->format('H:i') }}
                    </p>
                    <small class="text-muted">
                        @php
                            $liveDateTime = $liveSetting->live_date->copy()->setTimeFromTimeString($liveSetting->live_time->format('H:i:s'));
                        @endphp
                        @if($liveDateTime->isFuture())
                            <span class="text-primary">Còn {{ $liveDateTime->diffForHumans() }}</span>
                        @elseif($liveDateTime->isPast())
                            <span class="text-danger">Đã qua {{ $liveDateTime->diffForHumans() }}</span>
                        @else
                            <span class="text-success">Đang diễn ra</span>
                        @endif
                    </small>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="card shadow mb-4 border-left-warning">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="bi bi-lightning"></i> Thao tác nhanh
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.live-settings.edit', $liveSetting) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Chỉnh sửa
                    </a>
                    
                    @if(!$liveSetting->is_active)
                    <form action="{{ route('admin.live-settings.update', $liveSetting) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_active" value="1">
                        <input type="hidden" name="live_url" value="{{ $liveSetting->live_url }}">
                        <input type="hidden" name="play_url_flv" value="{{ $liveSetting->play_url_flv }}">
                        <input type="hidden" name="play_url_m3u8" value="{{ $liveSetting->play_url_m3u8 }}">
                        <input type="hidden" name="live_date" value="{{ $liveSetting->live_date->format('Y-m-d') }}">
                        <input type="hidden" name="live_time" value="{{ $liveSetting->live_time->format('H:i') }}">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-toggle-on"></i> Kích hoạt
                        </button>
                    </form>
                    @else
                    <form action="{{ route('admin.live-settings.update', $liveSetting) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_active" value="0">
                        <input type="hidden" name="live_url" value="{{ $liveSetting->live_url }}">
                        <input type="hidden" name="play_url_flv" value="{{ $liveSetting->play_url_flv }}">
                        <input type="hidden" name="play_url_m3u8" value="{{ $liveSetting->play_url_m3u8 }}">
                        <input type="hidden" name="live_date" value="{{ $liveSetting->live_date->format('Y-m-d') }}">
                        <input type="hidden" name="live_time" value="{{ $liveSetting->live_time->format('H:i') }}">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="bi bi-toggle-off"></i> Hủy kích hoạt
                        </button>
                    </form>
                    @endif
                    
                    <form action="{{ route('admin.live-settings.destroy', $liveSetting) }}" method="POST" 
                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa cài đặt live này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Status Info Card -->
        <div class="card shadow border-left-info">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="bi bi-info-circle"></i> Hướng dẫn
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        Nhân viên live có thể truy cập trước 30 phút
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        Chỉ một cài đặt được kích hoạt tại một thời điểm
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        Nhân viên được gán sẽ nhận được thông báo
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection


