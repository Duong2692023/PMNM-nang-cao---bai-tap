@extends('layoutmaster')
@section('title', 'Thêm sinh viên')
@section('description', 'Nhập thông tin sinh viên mới')

@section('content')
    <form action="{{ route('sinhvien.store') }}" method="POST">
        @csrf
        @include('sinhvien._form')
        <button type="submit" class="btn btn-primary">Thêm sinh viên</button>
        <a href="{{ route('sinhvien.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
