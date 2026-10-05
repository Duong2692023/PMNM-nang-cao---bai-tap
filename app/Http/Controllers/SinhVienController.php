<?php

namespace App\Http\Controllers;

use App\Http\Requests\SinhVienRequest;
use App\Models\LopHoc;
use App\Models\SinhVien;
use Illuminate\Http\Request;

class SinhVienController extends Controller
{
    public function index(Request $request)
    {
        $allowed = [10, 20, 50];
        $perPage = (int) $request->query('page_size', 10);
        if (! in_array($perPage, $allowed, true)) {
            $perPage = 10;
        }

        $sinhviens = SinhVien::query()
            ->with('lopHoc')
            ->timTheoTen($request->query('q'))
            ->theoKhoaHoc($request->query('khoa_hoc'))
            ->theoLopHoc($request->query('lop_hoc_id'))
            ->theoTrangThai($request->query('trang_thai'))
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('sinhvien.index', [
            'sinhviens' => $sinhviens,
            'perPage' => $perPage,
            'allowed' => $allowed,
            'lopHocs' => LopHoc::query()->orderBy('ten_lop')->get(),
            'khoaHocs' => LopHoc::query()
                ->select('khoa_hoc')
                ->distinct()
                ->orderBy('khoa_hoc')
                ->pluck('khoa_hoc'),
        ]);
    }

    public function create()
    {
        return view('sinhvien.create', [
            'sinhVien' => new SinhVien(['trang_thai' => true]),
            'lopHocs' => LopHoc::query()->orderBy('ten_lop')->get(),
        ]);
    }

    public function store(SinhVienRequest $request)
    {
        SinhVien::create($request->validated());

        return redirect()->route('sinhvien.index')->with('success', 'Thêm sinh viên thành công.');
    }

    public function show(SinhVien $sinhvien)
    {
        return view('sinhvien.show', [
            'sinhVien' => $sinhvien->load('lopHoc'),
        ]);
    }

    public function edit(SinhVien $sinhvien)
    {
        return view('sinhvien.edit', [
            'sinhVien' => $sinhvien,
            'lopHocs' => LopHoc::query()->orderBy('ten_lop')->get(),
        ]);
    }

    public function update(SinhVienRequest $request, SinhVien $sinhvien)
    {
        $sinhvien->update($request->validated());

        return redirect()->route('sinhvien.index')->with('success', 'Cập nhật sinh viên thành công.');
    }

    public function destroy(SinhVien $sinhvien)
    {
        $sinhvien->delete();

        return redirect()->back()->with('success', 'Xóa sinh viên thành công.');
    }
}
