<?php

namespace App\Http\Controllers;

use App\Http\Requests\LopHocRequest;
use App\Models\LopHoc;
use Illuminate\Http\Request;

class LopHocController extends Controller
{
    public function index(Request $request)
    {
        $allowed = [10, 20, 50];
        $perPage = (int) $request->query('page_size', 10);
        if (!in_array($perPage, $allowed, true)) {
            $perPage = 10;
        }

        // Đọc tham số sắp xếp, chỉ chấp nhận giá trị nằm trong whitelist
        $sort = $request->query('sort', 'id');
        if (!in_array($sort, LopHoc::SORTABLE, true)) {
            $sort = 'id';
        }
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';

        // Gọi các local scope đã khai báo trong Model -> controller gọn, dễ đọc
        $lophocs = LopHoc::query()
            ->timKiem($request->query('q'))
            ->trangThai($request->query('trang_thai'))
            ->siSoTrongKhoang($request->query('si_so_tu'), $request->query('si_so_den'))
            ->sapXep($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();   // giữ q, sort... khi bấm sang trang khác

        return view('lophoc.index', [
            'lophocs' => $lophocs,
            'perPage' => $perPage,
            'allowed' => $allowed,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Truyền 1 model rỗng để dùng chung form với trang sửa
        return view('lophoc.create', ['lopHoc' => new LopHoc(['trang_thai' => true])]);
    }

    /**
     * Store a newly created resource in storage.
     * LopHocRequest tự validate trước khi vào hàm, lỗi sẽ tự redirect về form.
     */
    public function store(LopHocRequest $request)
    {
        $request->validate([
        'ten_lop' => 'required',
        'khoa_hoc' => 'required',
        'si_so' => 'required|numeric',
        'giao_vien_chu_nhiem' => 'required',
    ]);

    // Lưu vào database
    $data = $request->all();
    $data['trang_thai'] = $request->has('trang_thai') ? 1 : 0; // Xử lý checkbox trạng thái
    \App\Models\LopHoc::create($data);

    // Chuyển hướng về trang danh sách
    return redirect()->route('lophoc.index')->with('success', 'Thêm lớp học thành công!');
    }

    /* ==========================================================
       ROUTE MODEL BINDING
       Route::resource('lophoc', ...) sinh ra tham số {lophoc}
       -> tên biến trong hàm PHẢI là $lophoc thì Laravel mới tự
          tìm LopHoc theo id (không thấy -> tự trả về 404).
       Đặt sai tên (vd $lopHoc) sẽ nhận được 1 model RỖNG.
       ========================================================== */

    /**
     * Display the specified resource.
     */
    public function show(LopHoc $lophoc)
    {
        return view('lophoc.show', ['lopHoc' => $lophoc]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LopHoc $lophoc)
    {
        return view('lophoc.edit', ['lopHoc' => $lophoc]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LopHocRequest $request, LopHoc $lophoc)
    {
        $lophoc->update($request->validated());
        return redirect()->route('lophoc.index')->with('success', 'Lớp học đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LopHoc $lophoc)
    {
        if ($lophoc->sinhViens()->exists()) {
            return redirect()->back()->with('error', 'Không thể xóa lớp đang có sinh viên được quản lý.');
        }

        $lophoc->delete();
        // back() để giữ nguyên trang/bộ lọc đang xem thay vì quay về trang 1
        return redirect()->back()->with('success', 'Lớp học đã được xóa thành công.');
    }
}
