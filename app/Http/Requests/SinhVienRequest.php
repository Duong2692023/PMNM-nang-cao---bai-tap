<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SinhVienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sinhVien = $this->route('sinhvien');
        $sinhVienId = $sinhVien instanceof \App\Models\SinhVien ? $sinhVien->getKey() : null;

        return [
            'ma_sv' => [
                'required',
                'string',
                'max:20',
                Rule::unique('sinh_viens', 'ma_sv')->ignore($sinhVienId),
            ],
            'ho_ten' => ['required', 'string', 'max:100'],
            'lop_hoc_id' => ['required', 'integer', 'exists:lop_hocs,id'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('sinh_viens', 'email')->ignore($sinhVienId),
            ],
            'trang_thai' => ['required', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'ma_sv' => 'mã số sinh viên',
            'ho_ten' => 'họ tên',
            'lop_hoc_id' => 'lớp quản lý',
            'email' => 'email',
            'trang_thai' => 'trạng thái',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Vui lòng nhập :attribute.',
            'email' => ':Attribute không đúng định dạng.',
            'exists' => ':Attribute không hợp lệ.',
            'unique' => ':Attribute đã được sử dụng.',
            'max' => ':Attribute không được vượt quá :max ký tự.',
        ];
    }
}
