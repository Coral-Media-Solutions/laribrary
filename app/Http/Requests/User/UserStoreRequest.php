<?php

namespace App\Http\Requests\User;


class UserStoreRequest extends UserRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|unique:users',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ];
    }
}
