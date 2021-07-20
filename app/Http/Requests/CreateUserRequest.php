<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => [
                'required',
                'string',
            ],
            'last_name' => [
                'required',
                'string',
            ],
            'middle_name' => [
                'nullable',
                'string',
            ],
            'birth_date' => [
                'required',
                'date',
            ],
            'contact_number' => [
                'required',
                'numeric',
            ],
            'full_address' => [
                'required',
                'string',
            ],
            'avatar_path' => [
                'nullable',
                'string',
            ],
            'email' => [
                'required',
                'email',
                'unique:users',
            ],
            'status' => [
                'nullable',
                'numeric',
            ],
            'account_type' => [
                'required',
                'string',
                Rule::in(['Admin', 'ContentWriter']),
            ],
        ];
    }
}
