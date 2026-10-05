@extends('layoutmaster')
@section('title',"Cập nhật menu")
@section('description',"Trang cập nhật menu " . $menu->ten)
@section('content')
    <form action="{{ route('menu.update', $menu) }}" method="POST">
        @csrf
        @method('PUT')
        @include('menu._form')
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('menu.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
