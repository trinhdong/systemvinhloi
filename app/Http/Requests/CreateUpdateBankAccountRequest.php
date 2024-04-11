<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateBankAccountRequest extends FormRequest
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
            'bank_code' => 'required',
            'bank_name' => 'required',
            'bank_account_name' => 'required',
        ];
        return $rules;
    }

    public function messages(): array
    {
        return [
            'bank_code.required' => 'Vui lòng sô tài khoản ngân hàng.',
            'bank_name.required' => 'Vui lòng nhập tên ngân hàng.',
            'bank_account_name.required' => 'Vui lòng nhập tên chủ tài khoản.',
        ];
    }
}
