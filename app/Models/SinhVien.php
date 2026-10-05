<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SinhVien extends Model
{
    protected $table = 'sinh_viens';

    protected $fillable = [
        'ma_sv',
        'ho_ten',
        'lop_hoc_id',
        'email',
        'trang_thai',
    ];

    protected function casts(): array
    {
        return [
            'trang_thai' => 'boolean',
        ];
    }

    public function lopHoc(): BelongsTo
    {
        return $this->belongsTo(LopHoc::class);
    }

    public function scopeTimTheoTen(Builder $query, ?string $tuKhoa): Builder
    {
        $tuKhoa = trim((string) $tuKhoa);

        return $query->when(
            $tuKhoa !== '',
            fn (Builder $q) => $q->where('ho_ten', 'like', "%{$tuKhoa}%")
        );
    }

    public function scopeTheoKhoaHoc(Builder $query, ?string $khoaHoc): Builder
    {
        $khoaHoc = trim((string) $khoaHoc);

        return $query->when(
            $khoaHoc !== '',
            fn (Builder $q) => $q->whereHas(
                'lopHoc',
                fn (Builder $lopQuery) => $lopQuery->where('khoa_hoc', $khoaHoc)
            )
        );
    }

    public function scopeTheoLopHoc(Builder $query, mixed $lopHocId): Builder
    {
        return $query->when(
            is_numeric($lopHocId) && (int) $lopHocId > 0,
            fn (Builder $q) => $q->where('lop_hoc_id', (int) $lopHocId)
        );
    }

    public function scopeTheoTrangThai(Builder $query, ?string $trangThai): Builder
    {
        if (! in_array($trangThai, ['0', '1'], true)) {
            return $query;
        }

        return $query->where('trang_thai', $trangThai === '1');
    }
}
