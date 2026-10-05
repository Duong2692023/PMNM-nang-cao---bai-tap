<?php

namespace App\Http\Requests;

use App\Models\Menu;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

// Form Request dùng chung cho store() và update() của MenuController.
class MenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Chạy TRƯỚC khi validate: chuẩn hóa dữ liệu người dùng gửi lên
    protected function prepareForValidation(): void
    {
        $this->merge([
            'ten' => trim((string) $this->input('ten')),
            'duong_dan' => trim((string) $this->input('duong_dan')) ?: null,
            // <option value=""> gửi lên chuỗi rỗng -> đổi thành null (menu nhóm)
            'parent_id' => $this->input('parent_id') ?: null,
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Route::resource('menu', ...) -> tham số {menu}.
        // Trang thêm mới không có tham số này nên $menu = null.
        $menu = $this->route('menu');

        return [
            'ten' => [
                'required', 'string', 'max:100',
                // Không trùng tên trong CÙNG một nhóm; khi sửa thì bỏ qua chính nó
                Rule::unique('menus', 'ten')
                    ->where('parent_id', $this->input('parent_id'))
                    ->ignore($menu),
            ],
            // Chấp nhận: #, đường dẫn nội bộ bắt đầu bằng /, hoặc link http(s)
            'duong_dan' => ['nullable', 'string', 'max:255', 'regex:~^(#|/[^\s]*|https?://[^\s]+)$~'],
            'parent_id' => [
                'nullable', 'integer',
                // Menu cha phải tồn tại và phải là menu nhóm (cấp 1)
                Rule::exists('menus', 'id')->whereNull('parent_id'),
            ],
            'thu_tu' => 'required|integer|min:0|max:1000',
            'trang_thai' => 'required|boolean',
        ];
    }

    // Kiểm tra bổ sung SAU khi các rules ở trên đã chạy:
    // những ràng buộc cần truy vấn/so sánh mà rule có sẵn không diễn đạt được.
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $menu = $this->route('menu');
                if (!$menu instanceof Menu || $this->input('parent_id') === null) {
                    return;
                }

                if ((int) $this->input('parent_id') === $menu->id) {
                    $validator->errors()->add('parent_id', 'Không thể chọn chính menu này làm menu cha.');
                } elseif ($menu->children()->exists()) {
                    $validator->errors()->add('parent_id', 'Menu đang có menu con nên không thể chuyển thành menu con.');
                }
            },
        ];
    }

    public function attributes(): array
    {
        return [
            'ten' => 'tên menu',
            'duong_dan' => 'đường dẫn',
            'parent_id' => 'menu cha',
            'thu_tu' => 'thứ tự',
            'trang_thai' => 'trạng thái',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Vui lòng nhập :attribute.',
            'max' => ':Attribute không được vượt quá :max.',
            'min' => ':Attribute không được nhỏ hơn :min.',
            'integer' => ':Attribute phải là số nguyên.',
            'boolean' => ':Attribute không hợp lệ.',
            'ten.unique' => 'Tên menu đã tồn tại trong nhóm này.',
            'duong_dan.regex' => 'Đường dẫn phải là #, bắt đầu bằng / hoặc http(s)://',
            'parent_id.exists' => 'Menu cha không hợp lệ.',
        ];
    }
}
