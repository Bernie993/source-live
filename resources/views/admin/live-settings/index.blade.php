@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-broadcast"></i> Cài đặt Live
            </h1>
            <a href="{{ route('admin.live-settings.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tạo mới
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                @if($liveSettings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Link Live</th>
                                    <th>Link Play</th>
                                    <th>Ngày Live</th>
                                    <th>Giờ Live</th>
                                    <th>Nhân viên</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($liveSettings as $setting)
                                <tr>
                                    <td>{{ $setting->id }}</td>
                                    <td>
                                        <a href="{{ $setting->live_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-link-45deg"></i> Xem
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ $setting->play_url }}" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-play-circle"></i> Play
                                        </a>
                                    </td>
                                    <td>{{ $setting->live_date->format('d/m/Y') }}</td>
                                    <td>{{ $setting->live_time->format('H:i') }}</td>
                                    <td>
                                        @if($setting->assignedUser)
                                            <span class="badge bg-primary">
                                                <i class="bi bi-person"></i> {{ $setting->assignedUser->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Chưa gán</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($setting->is_active)
                                            <span class="badge bg-success">Kích hoạt</span>
                                        @else
                                            <span class="badge bg-secondary">Không kích hoạt</span>
                                        @endif
                                        
                                        @if($setting->isAccessible())
                                            <span class="badge bg-info">Có thể truy cập</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.live-settings.show', $setting) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.live-settings.edit', $setting) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.live-settings.destroy', $setting) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $liveSettings->links() }}
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-broadcast" style="font-size: 3rem; color: #ccc;"></i>
                        <h4 class="mt-3">Chưa có cài đặt live nào</h4>
                        <p class="text-muted">Tạo cài đặt live đầu tiên để bắt đầu</p>
                        <a href="{{ route('admin.live-settings.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Tạo mới
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
