<?php

namespace Tests\Feature;

use App\Models\LopHoc;
use App\Models\SinhVien;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SinhVienTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_list_can_be_filtered_by_name_course_class_and_status(): void
    {
        $lopCanTim = $this->createClass('CNTT 1', 'K2025');
        $lopKhac = $this->createClass('CNTT 2', 'K2024');

        SinhVien::create([
            'ma_sv' => 'SV001',
            'ho_ten' => 'Nguyen Van An',
            'lop_hoc_id' => $lopCanTim->id,
            'email' => 'an@example.test',
            'trang_thai' => true,
        ]);
        SinhVien::create([
            'ma_sv' => 'SV002',
            'ho_ten' => 'Nguyen Van Binh',
            'lop_hoc_id' => $lopKhac->id,
            'email' => 'binh@example.test',
            'trang_thai' => true,
        ]);
        SinhVien::create([
            'ma_sv' => 'SV003',
            'ho_ten' => 'Nguyen Van Cuong',
            'lop_hoc_id' => $lopCanTim->id,
            'email' => 'cuong@example.test',
            'trang_thai' => false,
        ]);

        $response = $this->get(route('sinhvien.index', [
            'q' => 'Nguyen Van',
            'khoa_hoc' => 'K2025',
            'lop_hoc_id' => $lopCanTim->id,
            'trang_thai' => '1',
        ]));

        $response->assertOk()
            ->assertSee('SV001')
            ->assertSee('an@example.test')
            ->assertDontSee('SV002')
            ->assertDontSee('SV003');
    }

    public function test_student_list_is_paginated_and_keeps_search_parameters(): void
    {
        $lopHoc = $this->createClass('CNTT 1', 'K2025');

        foreach (range(1, 11) as $number) {
            SinhVien::create([
                'ma_sv' => sprintf('SV%03d', $number),
                'ho_ten' => 'Student ' . $number,
                'lop_hoc_id' => $lopHoc->id,
                'email' => sprintf('student%d@example.test', $number),
                'trang_thai' => true,
            ]);
        }

        $response = $this->get(route('sinhvien.index', [
            'q' => 'Student',
            'page_size' => 10,
        ]));

        $response->assertOk()
            ->assertSee('page=2', false)
            ->assertSee('q=Student', false)
            ->assertSee('SV011');
    }

    public function test_student_can_be_created_updated_and_deleted(): void
    {
        $lopHoc = $this->createClass('CNTT 1', 'K2025');
        $this->get(route('sinhvien.create'))->assertOk();
        $studentData = [
            'ma_sv' => 'SV001',
            'ho_ten' => 'Nguyen Van An',
            'lop_hoc_id' => $lopHoc->id,
            'email' => 'an@example.test',
            'trang_thai' => '1',
        ];

        $this->post(route('sinhvien.store'), $studentData)
            ->assertRedirect(route('sinhvien.index'));
        $this->assertDatabaseHas('sinh_viens', [
            'ma_sv' => 'SV001',
            'email' => 'an@example.test',
        ]);

        $sinhVien = SinhVien::firstOrFail();
        $this->get(route('sinhvien.show', $sinhVien))
            ->assertOk()
            ->assertSee('SV001');
        $this->get(route('sinhvien.edit', $sinhVien))->assertOk();
        $this->put(route('sinhvien.update', $sinhVien), [
            ...$studentData,
            'ho_ten' => 'Nguyen Van An Updated',
        ])->assertRedirect(route('sinhvien.index'));
        $this->assertDatabaseHas('sinh_viens', [
            'id' => $sinhVien->id,
            'ho_ten' => 'Nguyen Van An Updated',
        ]);

        $this->delete(route('sinhvien.destroy', $sinhVien))
            ->assertRedirect();
        $this->assertDatabaseMissing('sinh_viens', ['id' => $sinhVien->id]);
    }

    public function test_class_with_students_cannot_be_deleted(): void
    {
        $lopHoc = $this->createClass('CNTT 1', 'K2025');
        SinhVien::create([
            'ma_sv' => 'SV001',
            'ho_ten' => 'Nguyen Van An',
            'lop_hoc_id' => $lopHoc->id,
            'email' => 'an@example.test',
            'trang_thai' => true,
        ]);

        $this->delete(route('lophoc.destroy', $lopHoc))
            ->assertRedirect()
            ->assertSessionHas('error');
        $this->assertDatabaseHas('lop_hocs', ['id' => $lopHoc->id]);
    }

    private function createClass(string $name, string $course): LopHoc
    {
        return LopHoc::create([
            'ten_lop' => $name,
            'khoa_hoc' => $course,
            'giao_vien_chu_nhiem' => 'Nguyen Van A',
            'si_so' => 30,
            'trang_thai' => true,
        ]);
    }
}
