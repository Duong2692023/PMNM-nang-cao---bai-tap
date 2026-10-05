<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

// Form Request: tách phần validate ra khỏi controller.
// Dùng chung cho cả store() và update() -> không phải viết lặp rules.
class LopHocRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Mặc định make:request sinh ra "return false" -> mọi request bị 403.
        // Khi có phân quyền sẽ kiểm tra ở đây, tạm thời cho phép tất cả.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ten_lop' => 'required|string|max:50',
            'khoa_hoc' => 'required|string|max:20',
            'giao_vien_chu_nhiem' => 'required|string|max:100',
            'si_so' => 'required|integer|min:0|max:200',
            'trang_thai' => 'required|boolean',
            'ghi_chu' => 'nullable|string',
        ];
    }

    // Tên hiển thị của các trường trong thông báo lỗi
    public function attributes(): array
    {
        return [
            'ten_lop' => 'tên lớp',
            'khoa_hoc' => 'khóa học',
            'giao_vien_chu_nhiem' => 'giáo viên chủ nhiệm',
            'si_so' => 'sĩ số',
            'trang_thai' => 'trạng thái',
            'ghi_chu' => 'ghi chú',
        ];
    }

    // Thông báo lỗi tiếng Việt (APP_LOCALE=en nên mặc định là tiếng Anh)
    public function messages(): array
    {
        return [
            'required' => 'Vui lòng nhập :attribute.',
            'max' => ':Attribute không được vượt quá :max.',
            'min' => ':Attribute không được nhỏ hơn :min.',
            'integer' => ':Attribute phải là số nguyên.',
            'boolean' => ':Attribute không hợp lệ.',
        ];
    }
}
