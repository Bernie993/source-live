@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-person"></i> Chi tiết User: {{ $user->name }}
            </h1>
            <div>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary me-2">
                    <i class="bi bi-pencil"></i> Sửa
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- User Information -->
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-info-circle"></i> Thông tin cơ bản
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $user->id }}</p>
                        <p><strong>Tên:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Loại User:</strong> 
                            @if($user->user_type === 'system')
                                <span class="badge bg-primary">System</span>
                            @else
                                <span class="badge bg-secondary">External Login</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tài khoản:</strong> {{ $user->account ?? '-' }}</p>
                        <p><strong>Tài khoản ngân hàng:</strong> {{ $user->bank_account ?? '-' }}</p>
                        <p><strong>Platform:</strong> {{ $user->platform ?? '-' }}</p>
                        <p><strong>Vai trò:</strong> 
                            @foreach($user->roles as $role)
                                @php
                                    $badgeClass = match($role->name) {
                                        'Admin' => 'bg-danger',
                                        'Nhân viên Live' => 'bg-info',
                                        'CSKH' => 'bg-warning',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $role->name }}</span>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keywords Created -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-filter"></i> Từ khóa đã tạo ({{ $user->keywords()->count() }})
                </h6>
            </div>
            <div class="card-body">
                @if($user->keywords()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Từ khóa</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->keywords()->latest()->take(10)->get() as $keyword)
                                <tr>
                                    <td><strong>{{ $keyword->keyword }}</strong></td>
                                    <td>
                                        @if($keyword->is_active)
                                            <span class="badge bg-success">Kích hoạt</span>
                                        @else
                                            <span class="badge bg-secondary">Không kích hoạt</span>
                                        @endif
                                    </td>
                                    <td>{{ $keyword->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($user->keywords()->count() > 10)
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.keywords.index') }}?creator={{ $user->id }}" class="btn btn-sm btn-outline-primary">
                                Xem tất cả từ khóa
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-filter" style="font-size: 2rem; color: #ccc;"></i>
                        <p class="text-muted mt-2">Chưa tạo từ khóa nào</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-calendar"></i> Thời gian
                </h6>
            </div>
            <div class="card-body">
                <p><strong>Ngày tạo:</strong><br>
                   {{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                <p><strong>Cập nhật lần cuối:</strong><br>
                   {{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                <p><strong>Thời gian tồn tại:</strong><br>
                   {{ $user->created_at->diffForHumans() }}</p>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-bar-chart"></i> Thống kê
                </h6>
            </div>
            <div class="card-body">
                <p><strong>Từ khóa đã tạo:</strong><br>
                   <span class="h4 text-primary">{{ $user->keywords()->count() }}</span></p>
                <p><strong>Từ khóa đang hoạt động:</strong><br>
                   <span class="h4 text-success">{{ $user->keywords()->where('is_active', true)->count() }}</span></p>
                <p><strong>Từ khóa không hoạt động:</strong><br>
                   <span class="h4 text-secondary">{{ $user->keywords()->where('is_active', false)->count() }}</span></p>
            </div>
        </div>

        @if($user->api_response)
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-code"></i> API Response
                </h6>
            </div>
            <div class="card-body">
                <pre class="bg-light p-2 rounded"><code>{{ json_encode($user->api_response, JSON_PRETTY_PRINT) }}</code></pre>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
