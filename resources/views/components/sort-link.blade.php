{{--
    ANONYMOUS BLADE COMPONENT
    File resources/views/components/sort-link.blade.php -> dùng bằng thẻ <x-sort-link>
    Ví dụ: <x-sort-link column="ten_lop" label="Tên lớp" :sort="$sort" :direction="$direction" />
    (thuộc tính có dấu ":" phía trước sẽ được truyền dưới dạng biểu thức PHP)
--}}
@props(['column', 'label', 'sort', 'direction'])

@php
    $dangSapXep = $sort === $column;
    // Bấm lần 1: tăng dần; bấm tiếp vào cột đang tăng dần: đổi thành giảm dần
    $chieuMoi = ($dangSapXep && $direction === 'asc') ? 'desc' : 'asc';
    // fullUrlWithQuery: giữ nguyên q, trang_thai, page_size... chỉ thay sort/direction.
    // page = null -> bỏ tham số page, quay về trang 1 khi đổi cách sắp xếp.
    $url = request()->fullUrlWithQuery(['sort' => $column, 'direction' => $chieuMoi, 'page' => null]);
@endphp

<a href="{{ $url }}" class="sort-link {{ $dangSapXep ? 'active' : '' }}">
    {{ $label }}
    @if ($dangSapXep)
        <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
    @else
        <span class="text-muted">⇅</span>
    @endif
</a>
