<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required_without_all:image|nullable|string|max:255',         
            'content' => 'required_without_all:image|nullable|string',
            'img' => 'required_without_all:title,content|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',             
            'is_pinned' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            //thiếu
            'title.required_without_all' => 'Vui lòng nhập tiêu đề/nội dung hoặc thêm một hình ảnh.',
            'content.required_without_all' => 'Vui lòng nhập tiêu đề/nội dung hoặc thêm một hình ảnh.',
            'img.required_without_all' => 'Vui lòng nhập tiêu đề/nội dung hoặc thêm một hình ảnh.',
            
            //lỗi định dạng
            'img.image' => 'File tải lên phải là định dạng hình ảnh.',
            'img.mimes' => 'Hệ thống chỉ hỗ trợ ảnh dạng: jpeg, png, jpg, gif.',
            'img.max' => 'Kích thước ảnh quá lớn (Tối đa 2MB).',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
        ];
    }
}
