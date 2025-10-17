@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil"></i> Chỉnh sửa Cài đặt Live
            </h1>
            <a href="{{ route('admin.live-settings.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.live-settings.update', $liveSetting) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="live_url" class="form-label">Link Live <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('live_url') is-invalid @enderror" 
                               id="live_url" name="live_url" value="{{ old('live_url', $liveSetting->live_url) }}" required>
                        @error('live_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="play_url_flv" class="form-label">Link Play FLV <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('play_url_flv') is-invalid @enderror" 
                               id="play_url_flv" name="play_url_flv" value="{{ old('play_url_flv', $liveSetting->play_url_flv) }}" required>
                        @error('play_url_flv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Link FLV sẽ được ưu tiên phát trước
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="play_url_m3u8" class="form-label">Link Play m3u8 <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('play_url_m3u8') is-invalid @enderror" 
                               id="play_url_m3u8" name="play_url_m3u8" value="{{ old('play_url_m3u8', $liveSetting->play_url_m3u8) }}" required>
                        @error('play_url_m3u8')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Link m3u8 sẽ được dùng nếu trình duyệt không hỗ trợ FLV
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="live_date" class="form-label">Ngày Live <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('live_date') is-invalid @enderror" 
                                       id="live_date" name="live_date" value="{{ old('live_date', $liveSetting->live_date->format('Y-m-d')) }}" 
                                       min="{{ date('Y-m-d') }}" required>
                                @error('live_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="live_time" class="form-label">Giờ Live <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('live_time') is-invalid @enderror" 
                                       id="live_time" name="live_time" value="{{ old('live_time', $liveSetting->live_time->format('H:i')) }}" required>
                                @error('live_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="live_title" class="form-label">Tiêu đề Live</label>
                        <input type="text" class="form-control @error('live_title') is-invalid @enderror" 
                               id="live_title" name="live_title" value="{{ old('live_title', $liveSetting->live_title) }}">
                        @error('live_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="live_description" class="form-label">Mô tả Live</label>
                        <textarea class="form-control @error('live_description') is-invalid @enderror" 
                                  id="live_description" name="live_description" rows="3">{{ old('live_description', $liveSetting->live_description) }}</textarea>
                        @error('live_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="default_video_url" class="form-label">Video mặc định URL</label>
                        <input type="url" class="form-control @error('default_video_url') is-invalid @enderror" 
                               id="default_video_url" name="default_video_url" value="{{ old('default_video_url', $liveSetting->default_video_url) }}">
                        @error('default_video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Video này sẽ hiển thị trước khi live bắt đầu
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Nhân viên Live</label>
                        <select class="form-select @error('assigned_to') is-invalid @enderror" 
                                id="assigned_to" name="assigned_to">
                            <option value="">-- Chọn nhân viên --</option>
                            @foreach($liveStaffUsers as $user)
                                <option value="{{ $user->id }}" 
                                    {{ old('assigned_to', $liveSetting->assigned_to) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Chọn nhân viên live sẽ được gán cho live stream này
                        </small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $liveSetting->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Kích hoạt cài đặt này
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            Chỉ có thể có một cài đặt live được kích hoạt tại một thời điểm. 
                            Kích hoạt cài đặt này sẽ tự động hủy kích hoạt các cài đặt khác.
                        </small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.live-settings.index') }}" class="btn btn-secondary me-md-2">
                            <i class="bi bi-x"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-info-circle"></i> Thông tin
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>Ngày tạo:</strong><br>
                        {{ $liveSetting->created_at->format('d/m/Y H:i') }}
                    </li>
                    <li class="mb-2">
                        <strong>Cập nhật lần cuối:</strong><br>
                        {{ $liveSetting->updated_at->format('d/m/Y H:i') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection


