@extends('layoutmaster')
@section('title', 'Thông tin sinh viên')
@section('description', 'Chi tiết hồ sơ sinh viên')

@section('content')
    <table class="table">
        <tbody>
            <tr><th>Mã số sinh viên</th><td>{{ $sinhVien->ma_sv }}</td></tr>
            <tr><th>Họ tên</th><td>{{ $sinhVien->ho_ten }}</td></tr>
            <tr><th>Lớp quản lý</th><td>{{ $sinhVien->lopHoc->ten_lop }}</td></tr>
            <tr><th>Khóa học</th><td>{{ $sinhVien->lopHoc->khoa_hoc }}</td></tr>
            <tr><th>Email</th><td><a href="mailto:{{ $sinhVien->email }}">{{ $sinhVien->email }}</a></td></tr>
            <tr>
                <th>Trạng thái</th>
                <td>
                    @if ($sinhVien->trang_thai)
                        <span class="badge bg-success">Hoạt động</span>
                    @else
                        <span class="badge bg-secondary">Ngừng</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <a href="{{ route('sinhvien.edit', $sinhVien) }}" class="btn btn-primary">Sửa</a>
    <a href="{{ route('sinhvien.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection
