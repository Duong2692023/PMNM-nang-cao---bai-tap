<?php

namespace Database\Seeders;

use App\Models\LopHoc;
use App\Models\SinhVien;
use Illuminate\Database\Seeder;
use RuntimeException;

class SinhVienSeeder extends Seeder
{
    public function run(): void
    {
        $lopHocIds = LopHoc::query()->orderBy('id')->pluck('id');

        if ($lopHocIds->isEmpty()) {
            throw new RuntimeException('Không có lớp học. Hãy tạo lớp trước khi thêm dữ liệu sinh viên mẫu.');
        }

        $sinhViens = [
            ['ma_sv' => 'SV2026001', 'ho_ten' => 'Nguyễn Minh Anh', 'email' => 'sv2026001@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026002', 'ho_ten' => 'Trần Hoàng Nam', 'email' => 'sv2026002@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026003', 'ho_ten' => 'Lê Thu Hà', 'email' => 'sv2026003@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026004', 'ho_ten' => 'Phạm Đức Huy', 'email' => 'sv2026004@example.test', 'trang_thai' => false],
            ['ma_sv' => 'SV2026005', 'ho_ten' => 'Hoàng Ngọc Linh', 'email' => 'sv2026005@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026006', 'ho_ten' => 'Vũ Quang Minh', 'email' => 'sv2026006@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026007', 'ho_ten' => 'Đặng Hải Yến', 'email' => 'sv2026007@example.test', 'trang_thai' => false],
            ['ma_sv' => 'SV2026008', 'ho_ten' => 'Bùi Gia Bảo', 'email' => 'sv2026008@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026009', 'ho_ten' => 'Đỗ Phương Thảo', 'email' => 'sv2026009@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026010', 'ho_ten' => 'Ngô Tuấn Kiệt', 'email' => 'sv2026010@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026011', 'ho_ten' => 'Dương Khánh Vy', 'email' => 'sv2026011@example.test', 'trang_thai' => false],
            ['ma_sv' => 'SV2026012', 'ho_ten' => 'Lý Thành Đạt', 'email' => 'sv2026012@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026013', 'ho_ten' => 'Mai Thùy Dương', 'email' => 'sv2026013@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026014', 'ho_ten' => 'Đinh Anh Khoa', 'email' => 'sv2026014@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026015', 'ho_ten' => 'Phan Bảo Ngọc', 'email' => 'sv2026015@example.test', 'trang_thai' => false],
            ['ma_sv' => 'SV2026016', 'ho_ten' => 'Trương Nhật Long', 'email' => 'sv2026016@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026017', 'ho_ten' => 'Cao Khánh Linh', 'email' => 'sv2026017@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026018', 'ho_ten' => 'Võ Minh Quân', 'email' => 'sv2026018@example.test', 'trang_thai' => true],
            ['ma_sv' => 'SV2026019', 'ho_ten' => 'Hồ Ngọc Mai', 'email' => 'sv2026019@example.test', 'trang_thai' => false],
            ['ma_sv' => 'SV2026020', 'ho_ten' => 'Đoàn Thanh Tùng', 'email' => 'sv2026020@example.test', 'trang_thai' => true],
        ];

        foreach ($sinhViens as $index => $sinhVien) {
            SinhVien::updateOrCreate(
                ['ma_sv' => $sinhVien['ma_sv']],
                [
                    ...$sinhVien,
                    'lop_hoc_id' => $lopHocIds[$index % $lopHocIds->count()],
                ],
            );
        }
    }
}
