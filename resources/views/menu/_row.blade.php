{{-- 1 dòng trong bảng menu, dùng chung cho menu nhóm và menu con --}}
<tr @class(['table-light fw-bold' => $menu->parent_id === null])>
    <td @class(['ps-4' => $menu->parent_id !== null])>
        {{ $menu->parent_id !== null ? '└ ' : '' }}{{ $menu->ten }}
    </td>
    <td><code>{{ $menu->duong_dan }}</code></td>
    <td>{{ $menu->thu_tu }}</td>
    <td>
        @if ($menu->trang_thai)
            <span class="badge bg-success">Hiển thị</span>
        @else
            <span class="badge bg-secondary">Ẩn</span>
        @endif
    </td>
    <td class="text-nowrap">
        <a href="{{ route('menu.edit', $menu) }}" class="btn btn-sm btn-primary">Sửa</a>
        <form action="{{ route('menu.destroy', $menu) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger"
                    onclick="return confirm(@js($menu->parent_id === null ? "Xóa nhóm {$menu->ten} và toàn bộ menu con?" : "Bạn có chắc chắn muốn xóa menu {$menu->ten}?"))">Xóa</button>
        </form>
    </td>
</tr>
