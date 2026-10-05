@extends('layoutmaster')
@section('title',"Thêm mới lớp học")
@section('description',"Trang thêm mới lớp học")
@section('content')
    <form action="{{ route('lophoc.store') }}" method="POST">
        @csrf
        @include('lophoc._form')
        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="{{ route('lophoc.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
