<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => request()->route('user') 
                ?'required|string|max:255|unique:users,username,' . request()->route('user') 
                :'required|string|max:255|unique:users,username',
            'email' => request()->route('user') 
                ?'required|string|email|max:255|unique:users,email,' . request()->route('user') :
                'required|string|email|max:255|unique:users,email',
            'password' =>request()->route('user') 
                ?'nullable' :  'required|string|min:6',
            'avatar' => request()->route('user') 
                 ?'nullable' : 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'type'=>request()->route('user') 
                ?'nullable' :  'required|in:normal,silver,gold'
        ];
    }
}
