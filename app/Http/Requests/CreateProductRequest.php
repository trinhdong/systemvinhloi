<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
    public function rules()
    {
        return [
            'product_code' => 'required|unique:products,product_code',
            'product_name' => 'required',
            'price' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'product_code.required' => 'Mã sản phẩm không được để trống.',
            'product_code.unique' => 'Mã sản phẩm đã tồn tại trong hệ thống.',
            'product_name.required' => 'Tên sản phẩm không được để trống.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'price.numeric' => 'Giá sản phẩm phải là một số hợp lệ.',
            // ...
        ];
    }
}
