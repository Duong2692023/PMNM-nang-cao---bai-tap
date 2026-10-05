@extends('layoutmaster')
@section('title',"Cập nhật lớp học")
@section('description',"Trang cập nhật thông tin lớp " . $lopHoc->ten_lop)
@section('content')
    {{-- route('lophoc.update', $lopHoc): truyền cả model, Laravel tự lấy id --}}
    <form action="{{ route('lophoc.update', $lopHoc) }}" method="POST">
        @csrf
        @method('PUT')
        @include('lophoc._form')
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('lophoc.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
