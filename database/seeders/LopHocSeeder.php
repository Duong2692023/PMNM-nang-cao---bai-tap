<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LopHoc;

class LopHocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        LopHoc::factory()->count(45)->create();
        LopHoc::factory()->create([
            'ten_lop' => 'Lớp 1A',
            'khoa_hoc' => '2023-2024',
            'giao_vien_chu_nhiem' => 'Nguyễn Văn A',
            'si_so' => 30,
            'ghi_chu' => 'Lớp học cơ bản',
        ]);
    }
}
