<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'parent_id' => 'required',
            'sort_order' => 'required',
            'description' => 'required',
            'status' => 'required',
            'is_feature' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'parent_id.required' => 'Parent is required!',
            'sort_order.required' => 'Sort is required!',
            'description.required' => 'Description is required!',
            'status.required' => 'Status is required!',
            'is_feature.required' => 'Is Feature is required!',
        ];
    }
}
