@extends('layouts.admin')

@section('title', 'Quản lý Phản hồi')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Phản hồi Khách hàng</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.feedbacks.index') }}" class="form-inline">
                <div class="form-group mr-3">
                    <label class="mr-2">Trạng thái:</label>
                    <select name="status" class="form-control">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Đã xử lý</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                    </select>
                </div>
                <div class="form-group mr-3">
                    <label class="mr-2">Tìm kiếm:</label>
                    <input type="text" name="search" class="form-control" placeholder="Thông tin đăng nhập, nội dung..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Lọc
                </button>
                <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Chờ xử lý
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Feedback::where('status', 'pending')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                Đã xử lý
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Feedback::where('status', 'processed')->count() }}
                            </div>
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
                                Từ chối
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Feedback::where('status', 'rejected')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
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
                                Tổng số
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Feedback::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách Phản hồi</h6>
        </div>
        <div class="card-body">
            @if($feedbacks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Thông tin đăng nhập</th>
                                <th>Loại phản hồi</th>
                                <th>Nội dung</th>
                                <th>Hình ảnh</th>
                                <th>Ngày gửi</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbacks as $feedback)
                            <tr>
                                <td>{{ $feedback->id }}</td>
                                <td><strong>{{ $feedback->login_info }}</strong></td>
                                <td>{{ $feedback->feedback_type ?? 'N/A' }}</td>
                                <td>
                                    <div style="max-width: 300px;">
                                        {{ Str::limit($feedback->content, 100) }}
                                    </div>
                                </td>
                                <td>
                                    @if($feedback->image)
                                        <a href="{{ asset('storage/' . $feedback->image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $feedback->image) }}" 
                                                 alt="Feedback Image" 
                                                 style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;">
                                        </a>
                                    @else
                                        <span class="text-muted">Không có</span>
                                    @endif
                                </td>
                                <td>{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($feedback->status == 'pending')
                                        <span class="badge badge-warning">Chờ xử lý</span>
                                    @elseif($feedback->status == 'processed')
                                        <span class="badge badge-success">Đã xử lý</span>
                                    @else
                                        <span class="badge badge-danger">Từ chối</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.feedbacks.show', $feedback) }}" 
                                           class="btn btn-info btn-sm" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($feedback->status !== 'processed')
                                        <form method="POST" action="{{ route('admin.feedbacks.updateStatus', $feedback) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="processed">
                                            <button type="submit" class="btn btn-success btn-sm" 
                                                    title="Đánh dấu đã xử lý">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if($feedback->status !== 'rejected')
                                        <form method="POST" action="{{ route('admin.feedbacks.updateStatus', $feedback) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-secondary btn-sm" 
                                                    title="Từ chối">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif

                                        <form method="POST" action="{{ route('admin.feedbacks.destroy', $feedback) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    title="Xóa"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa phản hồi này?')">
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
                
                <div class="d-flex justify-content-center mt-3">
                    {{ $feedbacks->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted">Chưa có phản hồi nào.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

