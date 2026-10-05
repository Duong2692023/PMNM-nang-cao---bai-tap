<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LopHocResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ten_lop' => $this->ten_lop,
            'khoa_hoc' => $this->khoa_hoc,
            'giao_vien_chu_nhiem' => $this->giao_vien_chu_nhiem,
            'si_so' => $this->si_so,
            'trang_thai' => $this->trang_thai,
            'ghi_chu' => $this->ghi_chu,
        ];
    }
}
