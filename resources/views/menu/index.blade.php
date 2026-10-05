@extends('layoutmaster')
@section('title',"Quản lý menu")
@section('description',"Các menu hiển thị bên sidebar, lưu trong bảng menus")
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span>Có <strong>{{ $nhoms->count() }}</strong> nhóm menu</span>
        <a href="{{ route('menu.create') }}" class="btn btn-success">+ Thêm mới</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tên menu</th>
                    <th>Đường dẫn</th>
                    <th>Thứ tự</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($nhoms as $nhom)
                @include('menu._row', ['menu' => $nhom])
                @foreach ($nhom->children as $con)
                    @include('menu._row', ['menu' => $con])
                @endforeach
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Chưa có menu nào.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
