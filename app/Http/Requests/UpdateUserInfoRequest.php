<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'display_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'display_name.required' => 'Tên hiển thị không được để trống!',
            'email.required' => 'Email không được để trống!',
            'email.email' => 'Định dạng email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng cho tài khoản khác.',
            'avatar.image' => 'File tải lên phải là hình ảnh!',
            'avatar.max' => 'Kích thước ảnh đại diện tối đa là 2MB.',
        ];
    }
}