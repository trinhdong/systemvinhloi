<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'product_code' => [
                'required',
                Rule::unique('products', 'product_code')->ignore($this->route('id'))->whereNull('deleted_at'),
            ],
            'product_name' => 'required',
            'price' => 'required',
            'color' => 'required',
            'capacity' => 'required',
            'unit' => 'required',
            'specifications' => 'required',
            'quantity_per_package' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_code.required' => 'Mã sản phẩm không được để trống.',
            'product_code.unique' => 'Mã sản phẩm đã tồn tại trong hệ thống.',
            'product_name.required' => 'Tên sản phẩm không được để trống.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'color.required' => 'Màu sắc sản phẩm không được để trống.',
            'capacity.required' => 'Dung tích sản phẩm không được để trống.',
            'unit.required' => 'Đơn vị tính không được để trống.',
            'specifications.required' => 'Quy cách sản phẩm không được để trống.',
            'quantity_per_package.required' => 'Số lượng theo quy cách không được để trống.',
        ];
    }
}
