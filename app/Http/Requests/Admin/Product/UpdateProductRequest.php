<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'attribute_value' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'status' => 'required',
            'is_feature' => 'required',
        ];
    }
    public function messages(){
        return [
            'name.required' => 'Name is required!',
            'price.required' => 'Price is required!',
            'discount.required' => 'Discount is required!',
            'attribute_value.required' => 'Attribute Value is required!',
            'category_id.required' => 'Category is required!',
            'description.required' => 'Description is required!',
            'status.required' => 'Status is required!',
            'is_feature.required' => 'Is Featured is required!',
        ];
    }
}
