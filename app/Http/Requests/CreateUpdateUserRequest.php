<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if ($this->isMethod('GET')) {
            return  [];
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];

        if ($this->isMethod('POST')) {
            $rules['email'] .= '|unique:users,email';
            $rules['password'] = 'required|string|min:8';
        }
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['email'] = [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->route('id'))->whereNull('deleted_at'),
            ];
        }
        if (!empty($this->input('phone'))) {
            $rules['phone'] = ['string', 'max:20', 'regex:/^0\d{9,10}$/'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Vui lòng nhập đúng định dạng địa chỉ email',
            'email.unique' => 'Địa chỉ email này đã tồn tại.',
            'password.required' => 'Vui nhập mật khẩu.',
            'password.min' => 'Vui lòng nhập mật khẩu lớn hơn hoặc 8 ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá :max ký tự.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
        ];
    }
}
