@extends('layouts.admin')

@section('title', 'Quản lý Chat')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Chat</h1>
        <div>
            <a href="{{ route('admin.chat.export', request()->query()) }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Xuất Excel
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng tin nhắn
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_messages'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tin nhắn hoạt động
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_messages'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Tin nhắn bị chặn
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['blocked_messages'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ban fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Người dùng duy nhất
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['unique_users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bộ lọc</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.chat.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from">Từ ngày:</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to">Đến ngày:</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Tất cả</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Bị chặn</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="username">Tên người dùng:</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="{{ request('username') }}" placeholder="Tìm theo tên...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sort_by">Sắp xếp theo:</label>
                            <select class="form-control" id="sort_by" name="sort_by">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                                <option value="username" {{ request('sort_by') == 'username' ? 'selected' : '' }}>Tên người dùng</option>
                                <option value="is_blocked" {{ request('sort_by') == 'is_blocked' ? 'selected' : '' }}>Trạng thái</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sort_order">Thứ tự:</label>
                            <select class="form-control" id="sort_order" name="sort_order">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Lọc
                    </button>
                    <a href="{{ route('admin.chat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Xóa bộ lọc
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách tin nhắn</h6>
        </div>
        <div class="card-body">
            @if($messages->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên người dùng</th>
                                <th>Nội dung</th>
                                <th>Trạng thái</th>
                                <th>Thời gian gửi</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                            <tr>
                                <td>{{ $message->id }}</td>
                                <td>
                                    <strong>{{ $message->username }}</strong>
                                </td>
                                <td>
                                    <div style="max-width: 300px; word-wrap: break-word;">
                                        {{ Str::limit($message->message, 100) }}
                                    </div>
                                </td>
                                <td>
                                    @if($message->is_blocked)
                                        <span class="badge badge-danger">Bị chặn</span>
                                        @if($message->blocked_keywords)
                                            <br><small class="text-muted">
                                                Từ khóa: {{ implode(', ', $message->blocked_keywords) }}
                                            </small>
                                        @endif
                                    @else
                                        <span class="badge badge-success">Hoạt động</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $message->sent_at ? $message->sent_at->format('d/m/Y H:i:s') : ($message->created_at ? $message->created_at->format('d/m/Y H:i:s') : 'N/A') }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.chat.show', $message) }}" 
                                           class="btn btn-info btn-sm" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.chat.toggle-block', $message) }}" 
                                              style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm" 
                                                    title="{{ $message->is_blocked ? 'Bỏ chặn' : 'Chặn' }}"
                                                    onclick="return confirm('Bạn có chắc chắn muốn {{ $message->is_blocked ? 'bỏ chặn' : 'chặn' }} tin nhắn này?')">
                                                <i class="fas fa-{{ $message->is_blocked ? 'unlock' : 'ban' }}"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.chat.destroy', $message) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $messages->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-comments fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Không có tin nhắn nào</h5>
                    <p class="text-gray-500">Chưa có tin nhắn chat nào phù hợp với bộ lọc của bạn.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit form when date inputs change
    $('#date_from, #date_to').on('change', function() {
        $(this).closest('form').submit();
    });
});
</script>
@endpush
