@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-filter"></i> Quản lý Từ khóa chặn
            </h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKeywordModal">
                <i class="bi bi-plus"></i> Thêm từ khóa
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Tổng từ khóa
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_keywords'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Đang kích hoạt
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_keywords'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Không kích hoạt
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['inactive_keywords'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-x-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Keyword Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-gear"></i> Test Lọc Từ khóa
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.keywords.test') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="test_message" 
                                   placeholder="Nhập tin nhắn để test lọc từ khóa..." 
                                   value="{{ session('original_message') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-info w-100">
                                <i class="bi bi-play"></i> Test
                            </button>
                        </div>
                    </div>
                </form>
                
                @if(session('test_result'))
                <div class="mt-3">
                    <div class="alert {{ session('test_result')['is_blocked'] ? 'alert-danger' : 'alert-success' }}">
                        <strong>Kết quả:</strong> 
                        @if(session('test_result')['is_blocked'])
                            Tin nhắn bị chặn! Từ khóa vi phạm: 
                            @foreach(session('test_result')['blocked_keywords'] as $keyword)
                                <span class="badge bg-danger">{{ $keyword }}</span>
                            @endforeach
                        @else
                            Tin nhắn được phép gửi!
                        @endif
                    </div>
                    @if(session('clean_message'))
                    <div class="alert alert-info">
                        <strong>Tin nhắn sau khi lọc:</strong> {{ session('clean_message') }}
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Keywords List -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                @if($keywords->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Từ khóa</th>
                                    <th>Trạng thái</th>
                                    <th>Người tạo</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($keywords as $keyword)
                                <tr>
                                    <td>{{ $keyword->id }}</td>
                                    <td><strong>{{ $keyword->keyword }}</strong></td>
                                    <td>
                                        @if($keyword->is_active)
                                            <span class="badge bg-success">Kích hoạt</span>
                                        @else
                                            <span class="badge bg-secondary">Không kích hoạt</span>
                                        @endif
                                    </td>
                                    <td>{{ $keyword->creator->name ?? 'N/A' }}</td>
                                    <td>{{ $keyword->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Toggle Status -->
                                            <form action="{{ route('admin.keywords.toggle', $keyword) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $keyword->is_active ? 'btn-warning' : 'btn-success' }}">
                                                    <i class="bi bi-{{ $keyword->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Edit -->
                                            <button type="button" class="btn btn-sm btn-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editKeywordModal{{ $keyword->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            
                                            <!-- Delete -->
                                            <form action="{{ route('admin.keywords.destroy', $keyword) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa từ khóa này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Edit Modal for each keyword -->
                                <div class="modal fade" id="editKeywordModal{{ $keyword->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Sửa từ khóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.keywords.update', $keyword) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Từ khóa</label>
                                                        <input type="text" class="form-control" name="keyword" 
                                                               value="{{ $keyword->keyword }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   name="is_active" value="1" 
                                                                   {{ $keyword->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label">Kích hoạt</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $keywords->links() }}
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-filter" style="font-size: 3rem; color: #ccc;"></i>
                        <h4 class="mt-3">Chưa có từ khóa nào</h4>
                        <p class="text-muted">Thêm từ khóa chặn đầu tiên để bắt đầu</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Keyword Modal -->
<div class="modal fade" id="addKeywordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm từ khóa chặn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.keywords.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Từ khóa <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="keywords" rows="4" required
                                  placeholder="Nhập từ khóa, mỗi từ khóa một dòng hoặc ngăn cách bởi dấu phẩy...&#10;Ví dụ:&#10;spam&#10;badword&#10;inappropriate"></textarea>
                        <small class="form-text text-muted">
                            Bạn có thể nhập nhiều từ khóa, mỗi từ khóa một dòng hoặc ngăn cách bởi dấu phẩy.
                        </small>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                            <label class="form-check-label">Kích hoạt ngay</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm từ khóa</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
