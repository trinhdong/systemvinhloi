<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUpdateCategoryRequest extends FormRequest
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
            'category_name' => 'required|unique:categories,category_name',
        ];
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['category_name'] = [
                'required',
                Rule::unique('categories', 'category_name')->ignore($this->route('id'))->whereNull('deleted_at'),
            ];
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'category_name.required' => 'Vui lòng nhập tên danh mục.',
            'category_name.unique' => 'Tên danh mục đã tồn tại.',
        ];
    }
}
