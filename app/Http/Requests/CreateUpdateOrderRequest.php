<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateOrderRequest extends FormRequest
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
            'order_number' => 'required',
            'customer_id' => 'required',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'unit_price' => 'required|array',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['order_number'] .= '|unique:order,order_number';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'order_number.required' => 'Vui lòng nhập mã đơn hàng',
            'order_number.unique' => 'Mã đơn hàng đã tồn tại trong hệ thống.',
            'customer_id.required' => 'Vui lòng chọn khách hàng',
            'product_id.required' => 'Vui lòng chọn sản phẩm',
            'quantity.required' => 'Vui lòng nhập số lượng',
        ];
    }
}
