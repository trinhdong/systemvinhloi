<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'unit_price' => 'required|array',
            'product_price' => 'required|array',
            'order_total_product_price' => 'required',
            'discount_percent' => 'required|array|max:100',
            'payment_type' => 'required',
            'payment_method' => 'required',
            'order_discount' => 'max:99999999999.99',
            'order_total' => 'max:99999999999.99',
        ];
        if (!(Auth::user()->role === STOCKER)) {
            $rules['customer_id'] = 'required';
        }
        if (!empty($this->input('payment_type') && $this->input('payment_type') == PAYMENT_ON_DELIVERY)) {
            unset($rules['payment_method']);
        }

        if (!empty($this->input('payment_method')) && $this->input('payment_method') == TRANFER) {
            $rules['bank_customer_name'] = 'required';
            $rules['bank_name'] = 'required';
            $rules['bank_code'] = 'required';
            $rules['bank_account_id'] = 'required';
            $rules['payment_date'] = 'required';
            if ($this->input('payment_type') == DEPOSIT) {
                $rules['deposit'] = 'required';
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Vui lòng chọn khách hàng',
            'product_id.required' => 'Vui lòng chọn sản phẩm',
            'quantity.required' => 'Vui lòng nhập số lượng',
            'bank_customer_name.required' => 'Vui lòng nhập tên chủ tài khoản',
            'bank_name.required' => 'Vui lòng nhập tên ngân hàng',
            'bank_code.required' => 'Vui lòng nhập số tài khoàn',
            'payment_type.required' => 'Vui lòng chọn hình thức thanh toán',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
            'deposit.required' => 'Vui lòng nhập số tiền cọc',
            'order_discount.max' => 'Số tiền quá lớn',
            'order_total.max' => 'Số tiền quá lớn',
            'discount_percent.max' => 'Chiết khấu không được lớn hơn 100%',
            'discount_percent.required' => 'Vui lòng nhập chiết khấu',
            'bank_account_id.required' => 'Vui lòng chọn tài khoản nhận tiền',
            'payment_date.required' => 'Vui lòng nhập ngày thanh toán',
        ];
    }
}
