<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LopHoc extends Model
{
    //
    use HasFactory;
    protected $table = 'lop_hocs';
    protected $fillable = [
        'ten_lop',
        'khoa_hoc',
        'giao_vien_chu_nhiem',
        'si_so',
        'trang_thai',
        'ghi_chu'
    ];

    // Ép kiểu khi đọc ra: trang_thai trả về true/false thay vì 1/0
    protected function casts(): array
    {
        return [
            'trang_thai' => 'boolean',
            'si_so' => 'integer',
        ];
    }

    public function sinhViens(): HasMany
    {
        return $this->hasMany(SinhVien::class);
    }

    // Danh sách cột được phép sắp xếp (whitelist).
    // KHÔNG đưa thẳng tham số từ URL vào orderBy() -> người dùng có thể
    // truyền tên cột bất kỳ, gây lỗi SQL hoặc lộ cấu trúc bảng.
    public const SORTABLE = ['id', 'ten_lop', 'khoa_hoc', 'giao_vien_chu_nhiem', 'si_so', 'trang_thai'];

    /* ==========================================================
       LOCAL SCOPE: đóng gói điều kiện truy vấn để tái sử dụng.
       Khai báo: scopeTenScope(Builder $query, ...)
       Sử dụng:  LopHoc::tenScope(...)  (bỏ chữ "scope", viết thường chữ đầu)
       ========================================================== */

    // Tìm kiếm theo tên lớp, khóa học hoặc giáo viên chủ nhiệm
    public function scopeTimKiem(Builder $query, ?string $tuKhoa): Builder
    {
        $tuKhoa = trim((string) $tuKhoa);
        if ($tuKhoa === '') {
            return $query;
        }

        // Phải gom các orWhere vào trong 1 closure -> sinh ra dấu ngoặc:
        //   WHERE (ten_lop LIKE ? OR khoa_hoc LIKE ? OR ...) AND trang_thai = ?
        // Nếu không gom, điều kiện lọc trạng thái phía sau sẽ bị OR "phá" mất.
        return $query->where(function (Builder $q) use ($tuKhoa) {
            $q->where('ten_lop', 'like', "%{$tuKhoa}%")
              ->orWhere('khoa_hoc', 'like', "%{$tuKhoa}%")
              ->orWhere('giao_vien_chu_nhiem', 'like', "%{$tuKhoa}%");
        });
    }

    // Lọc theo trạng thái: null/'' = tất cả, '1' = hoạt động, '0' = ngừng
    public function scopeTrangThai(Builder $query, ?string $trangThai): Builder
    {
        if ($trangThai === null || $trangThai === '') {
            return $query;
        }

        return $query->where('trang_thai', (bool) $trangThai);
    }

    // Lọc sĩ số trong khoảng [từ, đến]. Bỏ trống đầu nào thì không giới hạn đầu đó.
    // Tham số lấy từ URL nên có thể là chuỗi bất kỳ -> chỉ áp dụng khi là số.
    public function scopeSiSoTrongKhoang(Builder $query, mixed $tu, mixed $den): Builder
    {
        $tu = is_numeric($tu) ? (int) $tu : null;
        $den = is_numeric($den) ? (int) $den : null;

        // Người dùng nhập ngược (từ 50 đến 20) -> tự đổi chỗ thay vì trả về rỗng
        if ($tu !== null && $den !== null && $tu > $den) {
            [$tu, $den] = [$den, $tu];
        }

        return $query
            ->when($tu !== null, fn (Builder $q) => $q->where('si_so', '>=', $tu))
            ->when($den !== null, fn (Builder $q) => $q->where('si_so', '<=', $den));
    }

    // Sắp xếp theo cột (đã kiểm tra whitelist) và chiều asc/desc
    public function scopeSapXep(Builder $query, string $cot, string $chieu): Builder
    {
        if (!in_array($cot, self::SORTABLE, true)) {
            $cot = 'id';
        }
        $chieu = $chieu === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($cot, $chieu);
    }
}
