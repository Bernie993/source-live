@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-plus"></i> Tạo Cài đặt Live
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
                <form action="{{ route('admin.live-settings.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="live_url" class="form-label">Link Live <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('live_url') is-invalid @enderror" 
                               id="live_url" name="live_url" value="{{ old('live_url') }}" required>
                        @error('live_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="play_url" class="form-label">Link Play <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('play_url') is-invalid @enderror" 
                               id="play_url" name="play_url" value="{{ old('play_url') }}" required>
                        @error('play_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="live_date" class="form-label">Ngày Live <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('live_date') is-invalid @enderror" 
                                       id="live_date" name="live_date" value="{{ old('live_date') }}" 
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
                                       id="live_time" name="live_time" value="{{ old('live_time') }}" required>
                                @error('live_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Nhân viên Live</label>
                        <select class="form-select @error('assigned_to') is-invalid @enderror" 
                                id="assigned_to" name="assigned_to">
                            <option value="">-- Chọn nhân viên --</option>
                            @foreach($liveStaffUsers as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
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
                                   {{ old('is_active') ? 'checked' : '' }}>
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
                            <i class="bi bi-check"></i> Lưu
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
                    <i class="bi bi-info-circle"></i> Hướng dẫn
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        Link Live và Play phải là URL hợp lệ
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        Ngày live phải từ hôm nay trở đi
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        Nhân viên live có thể truy cập link trước 30 phút
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        Chỉ một cài đặt được kích hoạt tại một thời điểm
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
