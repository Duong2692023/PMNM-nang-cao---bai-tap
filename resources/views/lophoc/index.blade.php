@extends('layoutmaster')
@section('title',"Danh sách lớp học")
@section('description',"Trang danh sách lớp học")
@push('styles')
    <style>
        .sort-link { color: inherit; text-decoration: none; white-space: nowrap; }
        .sort-link:hover, .sort-link.active { color: var(--mau-chinh); }
    </style>
@endpush
@section('content')
    {{-- FORM TÌM KIẾM: method GET -> tham số nằm trên URL (?q=...&trang_thai=...)
         => có thể copy link, bookmark, F5 không bị hỏi gửi lại form --}}
    <form method="GET" action="{{ route('lophoc.index') }}" class="row g-2 align-items-end mb-3">
        <div class="col-md-4">
            <label for="q" class="form-label">Từ khóa</label>
            <input type="text" id="q" name="q" value="{{ request('q') }}" class="form-control"
                   placeholder="Tên lớp, khóa học, giáo viên chủ nhiệm...">
        </div>
        <div class="col-md-2">
            <label for="trang_thai" class="form-label">Trạng thái</label>
            <select id="trang_thai" name="trang_thai" class="form-select">
                <option value="">Tất cả</option>
                <option value="1" @selected(request('trang_thai') === '1')>Hoạt động</option>
                <option value="0" @selected(request('trang_thai') === '0')>Ngừng</option>
            </select>
        </div>
        {{-- Lọc sĩ số trong khoảng: bỏ trống ô nào thì không giới hạn đầu đó --}}
        <div class="col-md-2">
            <label for="si_so_tu" class="form-label">Sĩ số từ</label>
            <input type="number" min="0" id="si_so_tu" name="si_so_tu" value="{{ request('si_so_tu') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="si_so_den" class="form-label">đến</label>
            <input type="number" min="0" id="si_so_den" name="si_so_den" value="{{ request('si_so_den') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="page_size" class="form-label">Số dòng / trang</label>
            {{-- Đặt select trong form -> đổi số dòng vẫn giữ được từ khóa đang tìm --}}
            <select id="page_size" name="page_size" class="form-select" onchange="this.form.submit()">
                @foreach ($allowed as $size)
                    <option value="{{ $size }}" @selected($perPage == $size)>{{ $size }}</option>
                @endforeach
            </select>
        </div>
        {{-- Giữ lại cách sắp xếp hiện tại khi tìm kiếm --}}
        <input type="hidden" name="sort" value="{{ $sort }}">
        <input type="hidden" name="direction" value="{{ $direction }}">
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <a href="{{ route('lophoc.index') }}" class="btn btn-outline-secondary">Xóa lọc</a>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <span>Tìm thấy <strong>{{ $lophocs->total() }}</strong> lớp học</span>
        <a href="{{ route('lophoc.create') }}" class="btn btn-success">+ Thêm mới</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    {{-- Mỗi tiêu đề cột là 1 Blade Component, xem components/sort-link.blade.php --}}
                    <th><x-sort-link column="ten_lop" label="Tên lớp" :sort="$sort" :direction="$direction" /></th>
                    <th><x-sort-link column="khoa_hoc" label="Khóa học" :sort="$sort" :direction="$direction" /></th>
                    <th><x-sort-link column="giao_vien_chu_nhiem" label="Giáo viên chủ nhiệm" :sort="$sort" :direction="$direction" /></th>
                    <th><x-sort-link column="si_so" label="Sĩ số" :sort="$sort" :direction="$direction" /></th>
                    <th><x-sort-link column="trang_thai" label="Trạng thái" :sort="$sort" :direction="$direction" /></th>
                    <th>Ghi chú</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            {{-- @forelse = @foreach + @empty (khi danh sách rỗng) --}}
            @forelse ($lophocs as $lophoc)
                <tr>
                    {{-- STT liên tục giữa các trang: firstItem() = số thứ tự bản ghi đầu trang --}}
                    <td>{{ $lophocs->firstItem() + $loop->index }}</td>
                    <td><a href="{{ route('lophoc.show', $lophoc) }}">{{ $lophoc->ten_lop }}</a></td>
                    <td>{{ $lophoc->khoa_hoc }}</td>
                    <td>{{ $lophoc->giao_vien_chu_nhiem }}</td>
                    <td>{{ $lophoc->si_so }}</td>
                    <td>
                        @if ($lophoc->trang_thai)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-secondary">Ngừng</span>
                        @endif
                    </td>
                    <td>{{ Str::limit($lophoc->ghi_chu, 40) }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('lophoc.edit', $lophoc) }}" class="btn btn-sm btn-primary">Sửa</a>
                        <form action="{{ route('lophoc.destroy', $lophoc) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa lớp {{ $lophoc->ten_lop }}?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Không tìm thấy lớp học nào phù hợp.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $lophocs->links() }}
@endsection
