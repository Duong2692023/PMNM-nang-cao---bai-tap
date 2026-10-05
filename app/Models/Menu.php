<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = [
        'ten',
        'duong_dan',
        'parent_id',
        'thu_tu',
        'trang_thai',
    ];

    protected function casts(): array
    {
        return [
            'trang_thai' => 'boolean',
            'thu_tu' => 'integer',
        ];
    }

    /* ==========================================================
       QUAN HỆ TỰ THAM CHIẾU (self-referencing)
       Một bảng menus vừa chứa nhóm, vừa chứa mục con của nhóm.
       ========================================================== */

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->thuTu();
    }

    // Chỉ lấy menu cấp 1 (nhóm)
    public function scopeNhom(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeHoatDong(Builder $query): Builder
    {
        return $query->where('trang_thai', true);
    }

    public function scopeThuTu(Builder $query): Builder
    {
        return $query->orderBy('thu_tu')->orderBy('id');
    }

    // Địa chỉ dùng cho thuộc tính href: $menu->href
    public function getHrefAttribute(): string
    {
        if (blank($this->duong_dan) || $this->duong_dan === '#') {
            return '#';
        }

        // url() giữ nguyên link tuyệt đối (https://...), link nội bộ thì nối thêm domain
        return url($this->duong_dan);
    }

    // Menu có trùng với trang đang xem không -> dùng để tô sáng (class "active")
    public function dangChon(): bool
    {
        $path = trim((string) $this->duong_dan, '/');
        if ($path === '' || $path === '#' || str_contains($path, '://')) {
            return false;
        }

        // 'lophoc' khớp cả /lophoc lẫn /lophoc/create, /lophoc/5/edit...
        return request()->is($path, $path . '/*');
    }
}
