@extends('layoutmaster')
@section('title',"Chi tiết lớp học")
@section('description',"Thông tin lớp " . $lopHoc->ten_lop)
@section('content')
    <table class="table table-bordered">
        <tr><th style="width: 220px">Tên lớp</th><td>{{ $lopHoc->ten_lop }}</td></tr>
        <tr><th>Khóa học</th><td>{{ $lopHoc->khoa_hoc }}</td></tr>
        <tr><th>Giáo viên chủ nhiệm</th><td>{{ $lopHoc->giao_vien_chu_nhiem }}</td></tr>
        <tr><th>Sĩ số</th><td>{{ $lopHoc->si_so }}</td></tr>
        <tr>
            <th>Trạng thái</th>
            <td>
                @if ($lopHoc->trang_thai)
                    <span class="badge bg-success">Hoạt động</span>
                @else
                    <span class="badge bg-secondary">Ngừng</span>
                @endif
            </td>
        </tr>
        <tr><th>Ghi chú</th><td>{{ $lopHoc->ghi_chu }}</td></tr>
        {{-- created_at/updated_at là Carbon -> định dạng bằng format() --}}
        <tr><th>Ngày tạo</th><td>{{ $lopHoc->created_at?->format('d/m/Y H:i') }}</td></tr>
        <tr><th>Cập nhật lần cuối</th><td>{{ $lopHoc->updated_at?->format('d/m/Y H:i') }}</td></tr>
    </table>
    <a href="{{ route('lophoc.edit', $lopHoc) }}" class="btn btn-primary">Sửa</a>
    <a href="{{ route('lophoc.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection
