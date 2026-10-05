@extends('layoutmaster')
@section('title', 'Cập nhật sinh viên')
@section('description', 'Chỉnh sửa thông tin sinh viên')

@section('content')
    <form action="{{ route('sinhvien.update', $sinhVien) }}" method="POST">
        @csrf
        @method('PUT')
        @include('sinhvien._form')
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="{{ route('sinhvien.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
