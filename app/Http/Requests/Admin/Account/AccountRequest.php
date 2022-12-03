<?php

namespace App\Http\Requests\Admin\Account;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'status' => 'required',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required!',
            'phone.required' => 'Phone is required!',
            'status.required' => 'Status is required!'
        ];
    }
}
