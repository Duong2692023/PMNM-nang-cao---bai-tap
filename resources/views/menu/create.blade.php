@extends('layoutmaster')
@section('title',"Thêm mới menu")
@section('description',"Trang thêm mới menu")
@section('content')
    <form action="{{ route('menu.store') }}" method="POST">
        @csrf
        @include('menu._form')
        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="{{ route('menu.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
