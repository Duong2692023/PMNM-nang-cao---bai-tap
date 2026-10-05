<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tên nhóm => [tên menu con => đường dẫn]
        $duLieu = [
            'Quản lý' => [
                'Lớp học' => '/lophoc',
                'Menu' => '/menu',
            ],
            'Nội dung môn học' => [
                'Bài 1 — HTML cơ bản' => '#',
                'Bài 2 — CSS Selector' => '#',
                'Bài 3 — Box Model' => '#',
                'Bài 4 — Flexbox' => '/layoutmaster',
                'Bài 5 — CSS Grid' => '#',
                'Bài 6 — Responsive' => '#',
            ],
            'Tài nguyên' => [
                'Slide bài giảng' => '#',
                'Mã nguồn demo' => '#',
            ],
        ];

        $thuTuNhom = 0;
        foreach ($duLieu as $tenNhom => $cacMuc) {
            // firstOrCreate: chạy seeder nhiều lần không bị trùng dữ liệu
            $nhom = Menu::firstOrCreate(
                ['ten' => $tenNhom, 'parent_id' => null],
                ['thu_tu' => ++$thuTuNhom],
            );

            $thuTu = 0;
            foreach ($cacMuc as $ten => $duongDan) {
                Menu::firstOrCreate(
                    ['ten' => $ten, 'parent_id' => $nhom->id],
                    ['duong_dan' => $duongDan, 'thu_tu' => ++$thuTu],
                );
            }
        }
    }
}
