<?php

namespace Database\Factories;

use App\Models\LopHoc;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LopHoc>
 */
class LopHocFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Sinh tên lớp giống thực tế: 68PM1, 70HT3...
        $khoa = $this->faker->numberBetween(68, 71);
        $nganh = $this->faker->randomElement(['PM', 'HT', 'KM', 'MT', 'CD']);

        return [
            'ten_lop' => $khoa . $nganh . $this->faker->numberBetween(1, 5),
            'khoa_hoc' => 'K' . $khoa,
            'giao_vien_chu_nhiem' => $this->faker->name(),
            'si_so' => $this->faker->numberBetween(20, 50),
            'trang_thai' => $this->faker->boolean(),
            'ghi_chu' => $this->faker->sentence(),
        ];
    }
}
