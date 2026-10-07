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

        $sortable = [
            'ma_sv' => 'sinh_viens.ma_sv',
            'ho_ten' => 'sinh_viens.ho_ten',
            'lop_hoc' => 'lop_hocs.ten_lop',
            'khoa_hoc' => 'lop_hocs.khoa_hoc',
        ];
        $sort = $request->query('sort', 'id');
        if (! is_string($sort) || ($sort !== 'id' && ! array_key_exists($sort, $sortable))) {
            $sort = 'id';
        }
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';

        $query = SinhVien::query()
            ->with('lopHoc')
            ->timTheoTen($request->query('q'))
            ->theoKhoaHoc($request->query('khoa_hoc'))
            ->theoLopHoc($request->query('lop_hoc_id'))
            ->theoTrangThai($request->query('trang_thai'));

        if (in_array($sort, ['lop_hoc', 'khoa_hoc'], true)) {
            $query->join('lop_hocs', 'sinh_viens.lop_hoc_id', '=', 'lop_hocs.id')
                ->select('sinh_viens.*');
        }

        $query->orderBy($sort === 'id' ? 'sinh_viens.id' : $sortable[$sort], $sort === 'id' ? 'desc' : $direction);
        if ($sort !== 'id') {
            $query->orderBy('sinh_viens.id');
        }

        $sinhviens = $query->paginate($perPage)->withQueryString();

        return view('sinhvien.index', [
            'sinhviens' => $sinhviens,
            'perPage' => $perPage,
            'allowed' => $allowed,
            'sort' => $sort,
            'direction' => $direction,
            'lopHocs' => LopHoc::query()->orderBy('ten_lop')->get(),
            'khoaHocs' => LopHoc::query()
                ->select('khoa_hoc')
                ->distinct()
                ->orderBy('khoa_hoc')
                ->pluck('khoa_hoc'),
        ]);
    }

    public function toggleStatus(SinhVien $sinhvien)
    {
        $sinhvien->update(['trang_thai' => ! $sinhvien->trang_thai]);

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái sinh viên.');
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
