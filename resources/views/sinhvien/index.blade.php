@extends('layoutmaster')
@section('title', 'Danh sách sinh viên')
@section('description', 'Quản lý thông tin sinh viên')

@section('content')
    <form method="GET" action="{{ route('sinhvien.index') }}" class="row g-2 align-items-end mb-3">
        <div class="col-md-3">
            <label for="q" class="form-label">Tên sinh viên</label>
            <input type="text" id="q" name="q" value="{{ request('q') }}" class="form-control"
                   placeholder="Nhập tên sinh viên">
        </div>
        <div class="col-md-2">
            <label for="khoa_hoc" class="form-label">Khóa học</label>
            <select id="khoa_hoc" name="khoa_hoc" class="form-select">
                <option value="">Tất cả khóa học</option>
                @foreach ($khoaHocs as $khoaHoc)
                    <option value="{{ $khoaHoc }}" @selected(request('khoa_hoc') === $khoaHoc)>
                        {{ $khoaHoc }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="lop_hoc_id" class="form-label">Lớp quản lý</label>
            <select id="lop_hoc_id" name="lop_hoc_id" class="form-select">
                <option value="">Tất cả lớp</option>
                @foreach ($lopHocs as $lopHoc)
                    <option value="{{ $lopHoc->id }}" @selected((string) request('lop_hoc_id') === (string) $lopHoc->id)>
                        {{ $lopHoc->ten_lop }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="trang_thai" class="form-label">Trạng thái</label>
            <select id="trang_thai" name="trang_thai" class="form-select">
                <option value="">Tất cả</option>
                <option value="1" @selected(request('trang_thai') === '1')>Hoạt động</option>
                <option value="0" @selected(request('trang_thai') === '0')>Ngừng</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="page_size" class="form-label">Số dòng / trang</label>
            <select id="page_size" name="page_size" class="form-select" onchange="this.form.submit()">
                @foreach ($allowed as $size)
                    <option value="{{ $size }}" @selected($perPage === $size)>{{ $size }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="sort" value="{{ $sort }}">
        <input type="hidden" name="direction" value="{{ $direction }}">
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <a href="{{ route('sinhvien.index') }}" class="btn btn-outline-secondary">Xóa lọc</a>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <span>Tìm thấy <strong>{{ $sinhviens->total() }}</strong> sinh viên</span>
        <a href="{{ route('sinhvien.create') }}" class="btn btn-success">+ Thêm sinh viên</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th><x-sort-link column="ma_sv" label="Mã số sinh viên" :sort="$sort" :direction="$direction" /></th>
                    <th><x-sort-link column="ho_ten" label="Họ tên" :sort="$sort" :direction="$direction" /></th>
                    <th><x-sort-link column="lop_hoc" label="Lớp quản lý" :sort="$sort" :direction="$direction" /></th>
                    <th><x-sort-link column="khoa_hoc" label="Khóa học" :sort="$sort" :direction="$direction" /></th>
                    <th>Email</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sinhviens as $sinhVien)
                    <tr>
                        <td>{{ $sinhviens->firstItem() + $loop->index }}</td>
                        <td>{{ $sinhVien->ma_sv }}</td>
                        <td><a href="{{ route('sinhvien.show', $sinhVien) }}">{{ $sinhVien->ho_ten }}</a></td>
                        <td>{{ $sinhVien->lopHoc->ten_lop }}</td>
                        <td>{{ $sinhVien->lopHoc->khoa_hoc }}</td>
                        <td><a href="mailto:{{ $sinhVien->email }}">{{ $sinhVien->email }}</a></td>
                        <td>
                            <form action="{{ route('sinhvien.toggle-status', $sinhVien) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                @if ($sinhVien->trang_thai)
                                    <button type="submit" class="badge border-0 bg-success"
                                            aria-label="Chuyển {{ $sinhVien->ho_ten }} sang trạng thái ngừng">
                                        Hoạt động
                                    </button>
                                @else
                                    <button type="submit" class="badge border-0 bg-secondary"
                                            aria-label="Chuyển {{ $sinhVien->ho_ten }} sang trạng thái hoạt động">
                                        Ngừng
                                    </button>
                                @endif
                            </form>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('sinhvien.edit', $sinhVien) }}" class="btn btn-sm btn-primary">Sửa</a>
                            <form action="{{ route('sinhvien.destroy', $sinhVien) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên {{ $sinhVien->ho_ten }}?')">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Không tìm thấy sinh viên phù hợp.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $sinhviens->links() }}
@endsection
