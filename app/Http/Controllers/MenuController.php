<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        // Eager loading: lấy nhóm kèm menu con chỉ với 2 câu SQL (tránh lỗi N+1)
        $nhoms = Menu::nhom()->thuTu()->with('children')->get();

        return view('menu.index', ['nhoms' => $nhoms]);
    }

    public function create()
    {
        return view('menu.create', [
            'menu' => new Menu(['trang_thai' => true, 'thu_tu' => 0]),
            'nhoms' => $this->danhSachNhom(),
        ]);
    }

    public function store(MenuRequest $request)
    {
        Menu::create($request->validated());
        return redirect()->route('menu.index')->with('success', 'Menu đã được tạo thành công.');
    }

    public function edit(Menu $menu)
    {
        return view('menu.edit', [
            'menu' => $menu,
            'nhoms' => $this->danhSachNhom($menu),
        ]);
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());
        return redirect()->route('menu.index')->with('success', 'Menu đã được cập nhật thành công.');
    }

    public function destroy(Menu $menu)
    {
        // Khóa ngoại cascadeOnDelete -> xóa nhóm sẽ xóa luôn các menu con
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu đã được xóa thành công.');
    }

    // Các menu nhóm để chọn làm menu cha (không cho chọn chính menu đang sửa)
    private function danhSachNhom(?Menu $boQua = null)
    {
        return Menu::nhom()
            ->when($boQua, fn ($q) => $q->whereKeyNot($boQua->id))
            ->thuTu()
            ->get();
    }
}
